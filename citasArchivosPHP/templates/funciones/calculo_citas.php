<?php

	$disp_cc = 0;
	$total_cc = 0;
	$disp_dd = 0;
	$total_dd = 0;
	$disp_cd = 0;
	$total_cd = 0;
	$disp_ce = 0;
	$total_ce = 0;

	try {
		$sql = "SELECT id_departamento, chd_estatus, chd_fecha FROM cat_horario_disp";
		$resultado = $mysqli->query($sql);
	} catch (Exception $e) {
		$error = $e->getMessage();
		echo $error;
	}
	while ($horario = $resultado->fetch_assoc()) {
		if ($horario['chd_estatus'] == 1 and $horario['id_departamento'] == 1 and $horario['chd_fecha'] == $today) {
			$disp_cc = $disp_cc + 1;
		}

		if ($horario['id_departamento'] == 1 and $horario['chd_fecha'] == $today) {
			$total_cc = $total_cc + 1;
		}

		if ($horario['chd_estatus'] == 1 and $horario['id_departamento'] == 2 and $horario['chd_fecha'] == $today) {
			$disp_dd = $disp_dd + 1;
		}

		if ($horario['id_departamento'] == 2 and $horario['chd_fecha'] == $today) {
			$total_dd = $total_dd + 1;
		}

		if ($horario['chd_estatus'] == 1 and $horario['id_departamento'] == 3 and $horario['chd_fecha'] == $today) {
			$disp_cd = $disp_cd + 1;
		}

		if ($horario['id_departamento'] == 3 and $horario['chd_fecha'] == $today) {
			$total_cd = $total_cd + 1;
		}

		if ($horario['chd_estatus'] == 1 and $horario['id_departamento'] == 4 and $horario['chd_fecha'] == $today) {
			$disp_ce = $disp_ce + 1;
		}

		if ($horario['id_departamento'] == 4 and $horario['chd_fecha'] == $today) {
			$total_ce = $total_ce + 1;
		}
	}
?>
