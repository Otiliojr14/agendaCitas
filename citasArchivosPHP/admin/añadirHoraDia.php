<?php
// Archivos de configuracion de base de datos y funciones
require '../admin/config.php';
require '../functions.php';

session_start();

if (isset($_SESSION['citaDamr_admin'])) {

  $errores = '';

	zonaHoraria();

	// Conectando con la base de datos
	$conexion = conexion($bd_config);

	// Busca el usuario de la sesion y muestra el nombre
	$name_user = mostrarUsuarioName($conexion);

  $id = idDepartamento($_GET['id']);

  $fecha_actual = date("Y-m-d");
	$fecha_actual = date("Y-m-d",strtotime($fecha_actual. "+ 1 days"));

  if (!$id || $id <= 0 || $id > 4) {
  	header('Location: admin_departamentos.php');
  }

  $statement = $conexion -> prepare('SELECT * FROM cat_departamentos WHERE id_departamento = :id');
  $statement->execute(array(':id' => $id));
  $departamento = $statement->fetch();

  $horario = obtenerDepartamentoHorario($conexion, $id);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $dia = $_POST['agregarDiaHora'];

    $statement = $conexion -> prepare('SELECT * FROM cat_feriados WHERE cfe_fecha = :fecha');
		$statement->execute(array(':fecha' => $dia));
		$resultado = $statement->fetch();

		$statement = $conexion -> prepare('SELECT * FROM cat_horario_disp WHERE chd_fecha = :fecha AND id_departamento = :ID');
		$statement->execute(array(':fecha' => $dia, ':ID' => $id));
		$resultadoDia = $statement->fetch();

    $nombreDia = get_nombre_dia($dia);
		$fechaNombre = get_nombre_dia($dia);

    if ($resultado !== false) {
			$errores = 'Eligió un día festivo. No se pueden asignar horas en dias festivos.';
		} elseif ($resultadoDia !== false) {
			$errores = 'Ya hay horas asignadas en este dia en el departamento.';
		} elseif ($fechaNombre == 'Sabado' || $fechaNombre == 'Domingo') {
			$errores = 'No se pueden asignar horas en días no laborales.';
		} else {

      for ($i=8; $i <=14 ; $i += 1) {
        $h = $i + 1;
				if ($i < 10) {
					$horaInicio1 = "0" . $i . ":00";
	        $hora_final1 = "0" . $i . ":30";
	        $horaInicio2 = "0" . $i . ":30";
					if ($h < 10) {
						$hora_final2 = "0" . $h . ":00";
					} else {
						$hora_final2 = $h . ":00";
					}
				} else {
					$horaInicio1 = $i . ":00";
	        $hora_final1 = $i . ":30";
	        $horaInicio2 = $i . ":30";
	        $hora_final2 = $h . ":00";
				}


        $statement = $conexion->prepare("INSERT INTO cat_horario_disp
  				(id_horario, id_departamento, chd_inicio, chd_fin, chd_dia_semana, chd_fecha, chd_estatus)
  				VALUES (null, :idDepartamento, :hora_inicio, :hora_fin, :nombre_dia, :fecha, :estatus)");
  			$statement->execute(array(':idDepartamento' => $id, ':hora_inicio' => $horaInicio1, ':hora_fin' => $hora_final1, ':nombre_dia' => $nombreDia, ':fecha' => $dia, ':estatus' => 1));

        $statement = $conexion->prepare("INSERT INTO cat_horario_disp
  				(id_horario, id_departamento, chd_inicio, chd_fin, chd_dia_semana, chd_fecha, chd_estatus)
  				VALUES (null, :idDepartamento, :hora_inicio, :hora_fin, :nombre_dia, :fecha, :estatus)");
  			$statement->execute(array(':idDepartamento' => $id, ':hora_inicio' => $horaInicio2, ':hora_fin' => $hora_final2, ':nombre_dia' => $nombreDia, ':fecha' => $dia, ':estatus' => 1));
      }
      $aviso = 'Horario completo del día agregado.';
		}
  }

	require 'view/añadirHoraDia.view.php';

} else {
	header('Location: ' . RUTA);
}

 ?>
