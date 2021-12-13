<?php

require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])) {

	$errores = '';

  $conexion = conexion($bd_config);
  $name_user = mostrarAdminName($conexion);

  $id = idDepartamento($_GET['id']);

  $statement = $conexion -> prepare('SELECT * FROM cat_departamentos WHERE id_departamento = :id');
  $statement->execute(array(':id' => $id));
  $departamento = $statement->fetch();

  $horario = obtenerDepartamentoHorario($conexion, $id);

  $fecha_actual = date("Y-m-d");

  if (!$id || $id <= 0 || $id > 4) {
  	header('Location: admin_departamentos.php');
  }

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$dia = $_POST['agregarDiaPersonalizado'];
		$horaInicio = $_POST['agregarDiaHorario'];

		$hora_final = agregarMediaHora($horaInicio);

		$nombreDia = get_nombre_dia($dia);

		if (empty($dia) || empty($horaInicio)) {
			$errores .= 'Introduce todos los datos';
		} else {

			$statement = $conexion -> prepare('SELECT * FROM cat_feriados WHERE cfe_fecha = :fecha');
			$statement->execute(array(':fecha' => $dia));
			$resultado = $statement->fetch();
	
			$statement = $conexion -> prepare('SELECT * FROM cat_horario_disp WHERE chd_fecha = :fecha AND id_departamento = :ID');
			$statement->execute(array(':fecha' => $dia, ':ID' => $id));
			$resultadoDia = $statement->fetch();

			if ($resultado !== false) {
				$errores = 'Eligió un día festivo. No se pueden asignar horas en dias festivos.';
			} elseif ($fechaNombre == 'Sabado' || $fechaNombre == 'Domingo') {
				$errores = 'No se pueden asignar horas en días no laborales.';
			} /* elseif ($resultadoDia !== false) {
				$errores = 'Ya hay horas asignadas en este dia en el departamento.';
			} */ else {			
				
				$statement = $conexion->prepare("INSERT INTO cat_horario_disp
					(id_horario, id_departamento, chd_inicio, chd_fin, chd_dia_semana, chd_fecha, chd_estatus)
					VALUES (null, :idDepartamento, :hora_inicio, :hora_fin, :nombre_dia, :fecha, :estatus)");
				$statement->execute(array(':idDepartamento' => $id, ':hora_inicio' => $horaInicio, ':hora_fin' => $hora_final, ':nombre_dia' => $nombreDia, ':fecha' => $dia, ':estatus' => 1));
				$aviso = 'Horario agregado.';
			}
		}
	}
	require 'view/añadirHoraPersonalizada.view.php';
} else {
  header('Location: ' . RUTA);
}



 ?>
