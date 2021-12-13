<?php

// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])) {
    $id = $_SESSION['citaDamr_admin'];

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = (mostrarAdminName($conexion));
    
    $idhorario = idDepartamento($_GET['id']);
    
    if (!$idhorario) {
  	header('Location: ' . RUTA . '/admin');
    }
    
    $statement = $conexion->prepare("
        SELECT * FROM cat_horario_disp
        INNER JOIN cat_departamentos ON cat_horario_disp.id_departamento = cat_departamentos.id_departamento
		WHERE id_horario = $idhorario");
	$statement->execute();
	$horario = $statement->fetch();
    
    // print_r($horario);
    
    if (!$horario) {
		header('Location: ' . RUTA . '/admin');
	}
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $horario = limpiarDatos($_POST['$idhorario']);
        
        $statement = $conexion->prepare("UPDATE cat_horario_disp SET chd_estatus = :estatus WHERE id_horario = :horario");
		$statement->execute(array(':estatus' => 0, ':horario' => $horario));
        header('Location: admin_departamentos.php');		
    }
    
    require 'view/cancelar_horario.view.php';
} else {
	header('Location: ' . RUTA);
}


 ?>