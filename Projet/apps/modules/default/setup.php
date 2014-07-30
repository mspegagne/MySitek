<?php


$sql = "INSERT INTO modules (rang, name, lien, icon, front, selected, version) VALUES (?,?,?,?,?,?,?)";
$app['db']->executeUpdate($sql, array(0,'2048', '2048', 'fa fa-gamepad', 2, 1, 0.1));

