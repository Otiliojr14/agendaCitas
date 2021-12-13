<?php

// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

// Redirige a los usuarios si la sessión esta abierta
comprobarSesion();

require 'view/index.view.php';

 ?>
