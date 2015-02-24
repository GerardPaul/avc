<?php

require("config.inc.php");

$username = 'admin';
$salt1 = md5(uniqid(rand(), true));
$salt = substr($salt1, 0, 25);
$password = hash('sha256', $salt . 'admin');

$sql = "INSERT INTO avc_users (username, password, salt, firstname, lastname, type) "
        . "VALUES (:username, :password, :salt, 'Gerard Paul', 'Labitad', 'admin')";
$p = array(
    ':username' => $username,
    ':password' => $password,
    ':salt' => $salt
);
$r = $db->prepare($sql);
$q = $r->execute($p);

