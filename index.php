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

$ip = $_SERVER['REMOTE_ADDR'];

$canDAO = new CandidatoDAO($conn);
$candidatos = $canDAO->obtener_todos();
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Votos a candidatos</title>
        <style type="text/css">
            .candidato{
                width: 300px;
                height: 250px;
                border: 2px black solid;
                padding: 5px;
                margin: 10px;   
                float: left;
                position: relative;
            }
             .foto_candidato{
               margin-top: 20px;
                height: 100px;
                background-size: contain;
                background-position: center;
                background-repeat:no-repeat;
            }
            .error{
                color: red;
            }
        </style>
    </head>
    <body>
        <h1>Candidatos presentados</h1>
        <?php MensajesFlash::imprimir_mensajes() ?>
        <?php

        foreach ($candidatos as $c) {?>          
        <div class="candidato">
            <p>Id candidato = <?= $c->getId()?></p>
            <p>Nombre candidato = <?= $c->getNombre()?></p>
            <p>Votos recibidos = <?= count($c->getVotos()) ?></p>
            <button><a href="borrar.php?id=<?= $c->getId() ?>" style="text-decoration:none">Borrar candidato</a> </button>
            <button><a href="insertar_voto.php?id=<?= $c->getId() ?>&ip=<?= $ip ?>" style="text-decoration:none">Votar</a> </button>
            <div class="foto_candidato" style="background-image:url('imagenes/<?=$c->getFoto()?>')">
                  
            </div>
            
        </div>      
       <?php } ?>
        
        <a href="insertar_candidato.php">Insertar nuevo candidato</a>
    </body>
</html>
