<?php


$sql = "INSERT INTO modules (name, lien, icon, front, selected, version) VALUES (?,?,?,?,?,?)";
$app['db']->executeUpdate($sql, array('2048', '2048', 'fa fa-gamepad', 1, 0, 0.1));

