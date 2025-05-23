<?php

$host="localhost";
$usuario="root";        
$contraseña="";
$nombre_bd="api";

$conn= new mysqli($host, $usuario, $contraseña, $nombre_bd);
if($conn->connect_error){
    die("Error de conexión: " . $conn->connect_error);
}else{
    return $conn;
}


?>