<?php

session_start(); //Permite utilizar variables de sesión

require 'modelos/Voto.php';
require 'modelos/Candidato.php';
require 'DAO/VotoDAO.php';
require 'DAO/CandidatoDAO.php';
require 'util/MensajesFlash.php';
require 'util/Sesion.php';
require 'util/ConexionBD.php';

$conn = ConexionBD::conectar();

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$ip = filter_var($_GET['ip'], FILTER_SANITIZE_STRING);
$voto = new Voto();
$votoDAO = new VotoDAO($conn);


//Comprueba que existe la cookie
if (!isset($_COOKIE['votado'])) {
    
    
    if ($votoDAO->existe($ip)) {
        MensajesFlash::anadir_mensaje("La IP de su equipo ya tiene un voto asignado");
        header("Location: index.php");
        die();
    }
    
    $voto->setId_candidato($id);
    $voto->setIp_cliente($ip);

    if($votoDAO->insertar($voto)){
        setcookie('votado', 'true', time() + 60 * 60 * 24);
    
        MensajesFlash::anadir_mensaje("El voto se ha ejecutado con éxito");
        header("Location: index.php");
        die();
    }else{
      MensajesFlash::anadir_mensaje("No se ha podido ejecutar el voto");
      header("Location: index.php");
      die();
    }
} else {
    MensajesFlash::anadir_mensaje("Ya has votado");
    header("Location: index.php");
}