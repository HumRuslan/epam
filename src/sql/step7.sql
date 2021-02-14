USE `shop`;
--  Товари, яких не має в наявності
SELECT c.`category`, t.`tovar`, t.`price`,
       IF (t.`description` IS NULL, 'NOT DESCRIPTION', t.`description`) as `descrition`
FROM `tovar` AS t
LEFT JOIN `category` AS c
    ON t.`category_id` = c.`id`
WHERE t.`count` = 0
ORDER BY c.`category`;

--  Товари, які є в наявності
SELECT c.`category`, t.`tovar`, t.`price`,
       IF (t.`description` is null, 'NOT DESCRIPTION', t.`description`) as `descrition`, t.`count`
FROM `tovar` AS t
LEFT JOIN `category` AS c
    ON t.`category_id` = c.`id`
WHERE t.`count` > 0
ORDER BY c.`category`, t.`tovar`;

-- Кількість товарів по категоріям
SELECT c.`category`, SUM(t.`count`) as `count_tovar`
FROM `tovar` AS t
LEFT JOIN `category` AS c
    ON t.`category_id` = c.`id`
GROUP BY c.`category`
ORDER BY c.`category`;

-- Продані товари (ціна за одиницю, кількість, загальна сумма)
SELECT c.`category`, t.`tovar`, t.`price`,
       COUNT(t.`price`) AS `count`, SUM(t.`price`) AS `summa`,
       IF (t.`description` IS NULL, 'NOT DESCRIPTION', t.`description`) AS `descrition`
FROM `tovar` AS t
LEFT JOIN `category` AS c
    ON t.`category_id` = c.`id`
INNER JOIN `item` AS i
    ON t.`id` = i.`tovar_id`
GROUP BY t.`tovar`
ORDER BY COUNT(t.`price`) DESC, SUM(t.`price`) DESC;

-- Топ 3 продаж
SELECT c.`category`, t.`tovar`, t.`price`,
       COUNT(t.`price`) AS `count`, SUM(t.`price`) AS `summa`,
       IF (t.`description` IS NULL, 'NOT DESCRIPTION', t.`description`) AS `descrition`
FROM `tovar` AS t
LEFT JOIN `category` AS c
    ON t.`category_id` = c.`id`
INNER JOIN `item` AS i
    ON t.`id` = i.`tovar_id`
GROUP BY t.`tovar`
ORDER BY COUNT(t.`price`) DESC, SUM(t.`price`) DESC
LIMIT 3;

-- Топ продаж (при умові, що може бути декілько товарів)
SELECT c.`category`, t.`tovar`, t.`price`,
       COUNT(t.`price`) AS `count`, SUM(t.`price`) AS `summa`,
       IF (t.`description` IS NULL, 'NOT DESCRIPTION', t.`description`) AS `descrition`
FROM `tovar` AS t
LEFT JOIN `category` AS c
    ON t.`category_id` = c.`id`
INNER JOIN `item` AS i
    ON t.`id` = i.`tovar_id`
GROUP BY t.`tovar`
HAVING COUNT(t.`price`) = (
    SELECT MAX(sq.`count`) FROM
        (SELECT COUNT(`tovar`.`id`) AS `count`
         FROM `tovar`, `item`
         WHERE `tovar`.`id` = `item`.`tovar_id`
         GROUP BY `tovar`.`id`
        ) AS sq
)
ORDER BY SUM(t.`price`) DESC;

-- Інформація про рахунки
SELECT o.`number`, o.`date`, c.`family`, c.`name`, c.`phone`,
       (SELECT SUM(`tovar`.`price`)
        FROM `item`
        LEFT JOIN `tovar`
        ON `item`.`tovar_id` = `tovar`.`id`
        WHERE `item`.`order_id` = o.`id`
       ) AS `summa`,
       IF (o.`status` = 0, 'NOT COMPLETED', 'COMPLETED') AS `status`
FROM `order` AS o
INNER JOIN `customer` AS c
    ON o.`customer_id` = c.`id`
ORDER BY o.`date`;

-- Інформація про всіх зареєстрованих покупців та кількість покупок які вони здійснили
SELECT c.`family`, c.`name`, c.`phone`, COUNT(o.`id`) AS count
FROM `order` AS o
RIGHT JOIN `customer` AS c
    ON c.`id` = o.`customer_id`
GROUP BY c.`family`
ORDER BY `count` DESC, c.`family`;

-- Інформація про зареєстрованих покупців, здійснили хоча б одну покупку
SELECT c.`family`, c.`name`, c.`phone`
FROM `customer` AS c
WHERE c.`id` IN (
    SELECT DISTINCT `order`.`customer_id` FROM `order`
)
ORDER BY c.`family`;

-- Інформація про зареєстрованих покупців, здійснили хоча б одну покупку
-- З детальною інформацією про кількість покупок та суммою
SELECT c.`family`, c.`name`, c.`phone`, COUNT(o.`id`) AS count,
(SELECT SUM(t.`price`)
	FROM `item` AS i, `tovar` AS t
    WHERE i.`tovar_id` = t.`id` AND i.`order_id` = o.`id`
) AS `summa`
FROM `order` AS o
RIGHT JOIN `customer` AS c
    ON c.`id` = o.`customer_id`
GROUP BY c.`family`
HAVING COUNT(o.`id`) > 0
ORDER BY `count` DESC, c.`family`;

-- Інформація про зареєстрованих покупців, які нічого не купляли

SELECT c.`family`, c.`name`, c.`phone`
FROM `customer` AS c
WHERE c.`id` NOT IN (
    SELECT DISTINCT `order`.`customer_id` FROM `order`
)
ORDER BY c.`family`;

-- Провести всі order зі статусом false з оновленням кількості товару та перевіркою його наявності

DELIMITER $$
CREATE PROCEDURE order_complited()
BEGIN
    DECLARE flag  INT DEFAULT 1;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
	    SET flag = 0;
    START TRANSACTION;
    UPDATE `tovar`
    SET `tovar`.`count` = `tovar`.`count` - (
        SELECT SUM(`item`.`count`)
        FROM `item`, `order`
        WHERE `item`.`order_id` = `order`.`id` AND `order`.`status` = 0 AND `item`.`tovar_id` = `tovar`.`id`
    )
    WHERE `tovar`.`id` IN (
        SELECT DISTINCT(`item`.`tovar_id`)
        FROM `item`, `order`
        WHERE `item`.`order_id` = `order`.`id` AND `order`.`status` = 0
    );
    UPDATE `order`
    SET `order`.`status` = 1
    WHERE `order`.`status` = 0;
    SELECT flag;
    IF flag = 0 THEN
        ROLLBACK;
        SELECT 'ERROR - "Insufficient quantity"' AS msg;
    ELSE
        COMMIT;
        SELECT 'SUCCES - "Data has updated"' AS msg;
    END IF;
END $$
DELIMITER ;

CALL order_complited();