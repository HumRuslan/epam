<?php

$sql = [
    'where' => [],
    'order' => '',
    'limit' => '',
    'prepare' => []
];

function snakeCaseToCamelCase(string $input)
{
    return preg_replace_callback('/_(.?)/', function ($matches){
        return ucfirst($matches[1]);
    }, $input);
}

function getUniqueFirstLetters($pdo)
{
    $sql = 'SELECT DISTINCT(LEFT(name, 1)) as `letter` FROM cities ORDER BY `letter`';
    $result = [];
    foreach ($pdo->query($sql) as $value) {
        $result[] = $value['letter'];
    }
    return $result;
}

function getFilterByFirstLetter($value, $sql)
{
    $sql['where'][] = "`airports`.`name` LIKE :firstLatter";
    $sql['prepare'] = array_merge($sql['prepare'], ['firstLatter' => $value . '%']);
    return $sql;
}

function getFilterByState($value, $sql)
{
    $sql['where'][] = "`states`.`name` = :state";
    $sql['prepare'] = array_merge($sql['prepare'], ['state' => $value]);
    return $sql;
}

function getSort($value, $sql)
{
    $sql['order'] = "$value";
    return $sql;
}

function getPage($value, $sql)
{
    $start = ($value - 1) * 5;
    $sql['limit'] = "$start, 5";
    return $sql;
}

function getAirports($pdo, $sql)
{
    $query = "SELECT count(`airports`.`name`) as `count`
              FROM `airports`
              LEFT JOIN `cities`
                ON `airports`.`city_id` = `cities`.`id`
              LEFT JOIN `states`
                ON `airports`.`state_id` = `states`.`id`
    ";
    $query .= ($sql['where']) ? ' WHERE ' . implode(' AND ', $sql['where']) : '';
    $sth = $pdo->prepare($query);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    foreach ($sql['prepare'] as $key => $value){
        $sth->bindParam(":$key", $sql['prepare'][$key]);
    }
    $sth->execute();
    $result = $sth->fetch();
    $count = $result['count'];

    $query = "SELECT `airports`.`name` as `name`, `airports`.`code` as `code`, 
                     `airports`.`address` as address, `airports`.`timezone` as timezone,
                     `cities`.name as city_name,
                     `states`.name as state_name
              FROM `airports`
              LEFT JOIN `cities`
                ON `airports`.`city_id` = `cities`.`id`
              LEFT JOIN `states`
                ON `airports`.`state_id` = `states`.`id`
    ";
    $query .= ($sql['where']) ? ' WHERE ' . implode(' AND ', $sql['where']) : '';
    $query .= ($sql['order']) ? ' ORDER BY ' . $sql['order'] : '';
    $query .= ($sql['limit']) ? ' LIMIT ' . $sql['limit'] : ' LIMIT 5';
    $sth = $pdo->prepare($query);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    foreach ($sql['prepare'] as $key => $value){
        $sth->bindParam(":$key", $sql['prepare'][$key]);
    }
    $sth->execute();
    $airports = $sth->fetchAll();

    return ['count' => $count, 'airports' => $airports];
}
