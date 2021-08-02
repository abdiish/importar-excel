<?php
//Funciones generales, para conectar y descoenectar la base de datos
include('config.php');

try {

    $connect = new PDO("mysql:host=$server; dbname=db_tycsa", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $error) {

    echo 'Error: ' .$error->getMessage();
}

?>