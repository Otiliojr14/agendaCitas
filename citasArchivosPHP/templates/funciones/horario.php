<?php
date_default_timezone_set('America/Mexico_City');
$today = date('Y-m-d');
$hoy = date('d/m/Y');
$feriado = 0;
try {
	$sql = "SELECT cfe_fecha FROM cat_feriados";
	$resultado = $mysqli->query($sql);
} catch (Exception $e) {
	$error = $e->getMessage();
	echo $error;
}
while ($admin = $resultado->fetch_assoc()) {
	if ($admin['cfe_fecha'] == $today ) {
		$feriado = 1;
	}}
 ?>
