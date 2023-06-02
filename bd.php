<?php
$dbname="app";
$servidor="localhost";
$user="root";
$password="";
try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$dbname", $user, $password);
} catch (PDOException $e){
    echo $e->getMessage();
} 