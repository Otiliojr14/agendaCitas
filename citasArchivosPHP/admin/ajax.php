<?php
require_once ('../templates/funciones/bd_conexion.php');
require '../functions.php';

if (!empty($_POST["agregar_dia"])) {

  $sql = 'SELECT * FROM cat_feriados WHERE cfe_fecha = "'.$_POST['agregar_dia'].'"';
	$resultado = $mysqli->query($sql);

  if ($resultado->num_rows > 0) {
		echo "<p class = 'alert registro'>Este dia ya esta asignado como festivo.</p>";
	}
}

if (!empty($_POST["agregarDiaHora"]) && !empty($_POST["idDepartamento"]) ) {

  $sql = 'SELECT * FROM cat_feriados WHERE cfe_fecha = "'.$_POST['agregarDiaHora'].'"';
	$resultado = $mysqli->query($sql);

  if ($resultado->num_rows > 0) {
		echo "<p class = 'alert error'>Es un dia festivo, no se pueden asignar horas.</p>";
	}

	$sql = 'SELECT * FROM cat_horario_disp WHERE chd_fecha = "'.$_POST['agregarDiaHora'].'" AND id_departamento ="'.$_POST['idDepartamento'].'"';
	$resultado = $mysqli->query($sql);

	if ($resultado->num_rows > 0) {
		echo "<p class = 'alert error'>Ya hay horas asignadas en este dia en el departamento.</p>";
	}

	$fechaNombre = get_nombre_dia($_POST['agregarDiaHora']);

	if ($fechaNombre == 'Sabado' || $fechaNombre == 'Domingo') {
		echo "<p class = 'alert error'>No se pueden asignar horas en días no laborales.</p>";
	}

}

if (!empty($_POST["agregarDiaPersonalizado"]) && !empty($_POST["idDepartamento"]) ) {

  $sql = 'SELECT * FROM cat_feriados WHERE cfe_fecha = "'.$_POST['agregarDiaHora'].'"';
	$resultado = $mysqli->query($sql);

  if ($resultado->num_rows > 0) {
		echo "<p class = 'alert error'>Es un dia festivo, no se pueden asignar horas.</p>";
	}

	$sql = 'SELECT * FROM cat_horario_disp WHERE chd_fecha = "'.$_POST['agregarDiaHora'].'" AND id_departamento ="'.$_POST['idDepartamento'].'"';
	$resultado = $mysqli->query($sql);

	if ($resultado->num_rows > 0) {
		echo "<p class = 'alert error'>Ya hay horas asignadas en este dia en el departamento.</p>";
	}

	$fechaNombre = get_nombre_dia($_POST['agregarDiaHora']);

	if ($fechaNombre == 'Sabado' || $fechaNombre == 'Domingo') {
		echo "<p class = 'alert error'>No se pueden asignar horas en días no laborales.</p>";
	}

}


 ?>
