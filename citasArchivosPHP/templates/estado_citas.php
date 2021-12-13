<!-- Notificaciones -->
<div class="notifications container pt-3 text-center">
	<div class="row">
		<div class="container pt-2 pb-2">
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

				if ($feriado == 1) {
					echo '<h5>' . $hoy . ' - <span class="badge badge-secondary">Dia festivo</span></h5>';
				} elseif (get_nombre_dia($today) == 'Sabado' || get_nombre_dia($today) == 'Domingo') {
					echo '<h5>' . $hoy . ' - <span class="badge badge-warning">Dia de descanso</span></h5>';
				} else {
					echo '<h5>' . $hoy . ' - <span class="badge badge-primary">Dia normal</span></h5>';
				}
				?>
		</div></h4>
	</div>
