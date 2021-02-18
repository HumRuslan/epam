<?php

/** @var \PDO $pdo */
require_once './pdo_ini.php';

// cities
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `cities` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`id`)
);
SQL;

try {
    $pdo->exec($sql);
    echo 'Success';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
echo PHP_EOL;

// states
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `states` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
    PRIMARY KEY (`id`)
);
SQL;

try {
    $pdo->exec($sql);
    echo 'Success';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
echo PHP_EOL;

// airports
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `airports` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
    `code` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
    `city_id` INT(10) UNSIGNED NOT NULL,
    `state_id` INT(10) UNSIGNED NOT NULL,
    `address` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
    `timezone` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
    PRIMARY KEY (`id`),
    FOREIGN KEY `FK_CITY` (`city_id`) REFERENCES `cities`(`id`),
    FOREIGN KEY `FK_STATE` (`state_id`) REFERENCES `states`(`id`)
)
SQL;

try {
    $pdo->exec($sql);
    echo 'Success';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}