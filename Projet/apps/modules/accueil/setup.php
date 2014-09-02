<?php

$sql = "SELECT * FROM modules WHERE lien = '2048'";
$retour = $app['db']->fetchAssoc($sql);

if ($retour == '') {
    
    $sql = "INSERT INTO modules (rang, name, lien, icon, front, selected, version) VALUES (?,?,?,?,?,?,?)";
    $app['db']->executeUpdate($sql, array(0, '2048', '2048', 'fa fa-gamepad', 2, 1, 0.1));
    
} 

elseif ($retour['selected'] == 0) {
   
        $sql = "UPDATE modules SET selected = 1 WHERE lien = '2048'";
        $app['db']->executeUpdate($sql, array());
   
}
