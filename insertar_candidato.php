<?php
session_start(); //Permite utilizar variables de sesión

require 'modelos/Voto.php';
require 'modelos/Candidato.php';
require 'DAO/VotoDAO.php';
require 'DAO/CandidatoDAO.php';
require 'util/MensajesFlash.php';
require 'util/Sesion.php';
require 'util/ConexionBD.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    
    
    $candidato = new Candidato();
    $error = false;
    
    //Comprobamos que hay un nombre
    if (empty($_POST['nombre'])) {
        MensajesFlash::anadir_mensaje("El nombre es obligatorio.");
        $error = true;
    }else{//Guardamos el nombre en un variable limpiandolo antes
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    //Comprobamos que hay una foto
    if (empty($_FILES['foto']['name'])){
        MensajesFlash::anadir_mensaje("La foto es obligatioria.");
        $error = true;
    } else{
        //Comprobamos el formato de la foto sea png gif o jpeg y que no sea de un tamaño excesivo
        if ($_FILES['foto']['type'] != 'image/png' &&
            $_FILES['foto']['type'] != 'image/gif' &&
            $_FILES['foto']['type'] != 'image/jpeg') {
        MensajesFlash::anadir_mensaje("El archivo seleccionado no es una foto.");
        $error = true;
        }
        if ($_FILES['foto']['size'] > 1000000) {
        MensajesFlash::anadir_mensaje("El archivo seleccionado es demasiado grande. Debe tener un tamaño inferior a 1MB");
        $error = true;
        }
    }
    
    if (!$error) {
        //Copiar foto
        //Generamos un nombre para la foto
        $nombre_foto = md5(time() + rand(0, 999999));
      
        
        $extension_foto = substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.') + 1);
        //Limpiamos la extensión de la foto
        $extension_foto = filter_var($extension_foto,FILTER_SANITIZE_SPECIAL_CHARS);
        //Comprobamos que no exista ya una foto con el mismo nombre, si existe calculamos uno nuevo
        while (file_exists("imagenes/$nombre_foto.$extension_foto")) {
            $nombre_foto = md5(time() + rand(0, 999999));
        }
        //movemos la foto a la carpeta que queramos guardarla y con el nombre original
        move_uploaded_file($_FILES['foto']['tmp_name'], "imagenes/$nombre_foto.$extension_foto");
        $foto = $_FILES['foto']['tmp_name'];
        //Insertamos el candidato en la BBDD
        $candidato->setNombre($nombre);
        $candidato->setFoto("$nombre_foto.$extension_foto");
        
        $conn = ConexionBD::conectar();
        
        $canDAO = new CandidatoDAO($conn);
        $canDAO->insertar($candidato);
        MensajesFlash::anadir_mensaje("Candidato creado.");
        header('Location: index.php');
        
        die();
        
        }
    
    
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Insertar candidato</title>
        <style type="text/css">
            .error{
                color: red;
            }
        </style>
    </head>
    <body>
        <?php MensajesFlash::imprimir_mensajes() ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre del candidato: </label>
            <input type="text" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre)) {echo $nombre;}?>"><br><br>
            <label for="foto">Foto del candidato: </label>
            <input type="file" name="foto" accept="image/*"><br><br>
            <input type="submit" value="registrar">
            <input type="button" value="volver" onclick="location.href = 'index.php'">
        </form>
    </body>
</html>
