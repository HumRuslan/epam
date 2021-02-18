<?php

/** @var \PDO $pdo */
require_once './pdo_ini.php';

echo "Import is started";
$index = 0;
foreach (require_once('../web/airports.php') as $item) {
    try {
        // Cities
        $sth = $pdo->prepare('SELECT id FROM cities WHERE name = :name');
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->execute(['name' => $item['city']]);
        $city = $sth->fetch();

        if (!$city) {
            $sth = $pdo->prepare('INSERT INTO cities (name) VALUES (:name)');
            $sth->execute(['name' => $item['city']]);
            $cityId = $pdo->lastInsertId();
        } else {
            $cityId = $city['id'];
        }

        // States
        $sth = $pdo->prepare('SELECT id FROM states WHERE name = :name');
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->execute(['name' => $item['state']]);
        $state = $sth->fetch();

        if (!$state) {
            $sth = $pdo->prepare('INSERT INTO states (name) VALUES (:name)');
            $sth->execute(['name' => $item['state']]);
            $stateId = $pdo->lastInsertId();
        } else {
            $stateId = $state['id'];
        }

        // Airports
        $sth = $pdo->prepare('INSERT INTO airports (name, code, city_id, state_id, address, timezone) 
                                        VALUES (:name, :code, :city_id, :state_id, :address, :timezone)');
        $sth->execute([
            'name' => $item['name'],
            'code' => $item['code'],
            'city_id' => $cityId,
            'state_id' => $stateId,
            'address' => $item['address'],
            'timezone' => $item['timezone']
        ]);
        $index++;
    } catch (PDOException $e) {
        echo "Record: $index";
        echo PHP_EOL;
        echo 'Error: ' . $e->getMessage();
    }
}

echo "Import is success";
echo PHP_EOL;
echo "Records: $index";