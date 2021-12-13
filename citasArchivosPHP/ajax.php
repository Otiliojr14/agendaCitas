<?php
require_once ('templates/funciones/bd_conexion.php');
require_once ('functions.php');

zonaHoraria();

$DateAndTime = date('Y-m-d H:i');

if(!empty($_POST["fecha_cita"])  && !isset($_POST["departamento_cita"])) {

	$sql = 'SELECT * FROM cat_feriados WHERE cfe_fecha = "'.$_POST['fecha_cita'].'"';
	$resultado = $mysqli->query($sql);

	if ($resultado->num_rows > 0) {
		echo '<option value="">Ha elegido un dia festivo, no se pueden asignar citas en este dia</option>';
	} else {
		$sql = 'SELECT * FROM cat_horario_disp INNER JOIN cat_departamentos ON cat_horario_disp.id_departamento = cat_departamentos.id_departamento
		WHERE chd_fecha = "'.$_POST['fecha_cita'].'" AND chd_estatus = 1';
		$resultado = $mysqli->query($sql);

		$cc = 0;
		$dd = 0;
		$cd = 0;
		$ce = 0;

		if ($resultado->num_rows > 0) {
			while ($departamentoDisponible = $resultado->fetch_assoc()) {
				// print_r($departamentoDisponible);
				$fechaDato = $departamentoDisponible['chd_fecha'] . ' ' . $departamentoDisponible['chd_inicio'];
				if ($departamentoDisponible['id_departamento'] == 1 && $cc == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] .  '</option>';
						$cc += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 2 && $dd == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$dd += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 3 && $cd == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$cd += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 4 && $ce == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$ce += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 5 && $a == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$a += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 6 && $b == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$b += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 7 && $c == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$c += 7;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 8 && $e == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$e += 8;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 9 && $f == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$f += 9;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 10 && $g == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$g += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 11 && $h == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$h += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 12 && $i == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$i += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 13 && $j == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$j += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 14 && $k == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$k += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 15 && $l == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$l += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 16 && $m == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$m += 1;
					}
				}
				if ($departamentoDisponible['id_departamento'] == 17 && $n == 0) {
					if ($fechaDato > $DateAndTime) {
						echo '<option value=' . $departamentoDisponible['id_departamento'] . '>' . $departamentoDisponible['cdep_nombre'] . '</option>';
						$n += 1;
					}
				}
			}
		} else {
			echo '<option value="">No hay horarios disponibles en este dia.</option>';
		}



	}
}

if(!empty($_POST["departamento_cita"]) && !empty($_POST["fecha_cita"])) {
	$sql = 'SELECT * FROM cat_horario_disp WHERE 	id_departamento = "'.$_POST['departamento_cita'].'" AND chd_estatus = 1 AND chd_fecha ="'.$_POST['fecha_cita'].'"';
	$resultado = $mysqli->query($sql);
	while ($horaDisponible = $resultado->fetch_assoc()) {
		$fechaDato = $horaDisponible['chd_fecha'] . ' ' . $horaDisponible['chd_inicio'];

		if ($fechaDato > $DateAndTime) {
			echo '<option value=' . $horaDisponible['id_horario'] . '>' . $horaDisponible['chd_inicio'] . ' - ' . $horaDisponible['chd_fin'] . '</option>';
		}

	}


	//
  // if($resultado->num_rows > 0) {
  //     echo "<p class='alert registro-cita'>Ha elegido un dia festivo, no se pueden asignar citas en este dia.</p>";
  // }
}



 ?>
