<?php
    include_once '../templates/header.php';
?>

<div class="header-admin container row">
	<div class="admin-nombre col-md-8">
		<h5><i class="admin-icon fa fa-user"></i>Administrador: <?php echo utf8_encode($name_user['cper_nombre']); ?></h5>
	</div>
	<div class="sesion-admin col-md-4">
		<h5><a href="cerrar_sesion.php">Cerrar sesión<i class="icono fa fa-sign-out"></i></a></h5>
	</div>
</div>

<h5 class="text-center pt-3 pb-3"><strong><i class="admin-icon fa fa-clock-o"></i>¿Está seguro de que desea quitar este horario?</strong></h5>

<div class="container">
	<div class="row">
    <div class="contenedor_login col-10 offset-1 col-lg-6 offset-lg-3">
      <div class="contenido_login">
		<form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $idhorario; ?>" method="post">
				<input type="hidden" id="idCita" name="idCita" value="<?php echo $idhorario; ?>">
				<label for="matricula"><strong>Departamento:</strong></label>
				<p class="name_user"><?php echo $horario['cdep_nombre']; ?></p>
                <label for="name"><strong>Fecha de la cita:</strong></label>
				<p class="name_user"><?php echo cambiaf_a_espanol($horario['chd_fecha']); ?></p>
                <label for="name"><strong>Día de la cita:</strong></label>
				<p class="name_user"><?php echo $horario['chd_dia_semana']; ?></p>
				<label for="name"><strong>Hora de atención de la cita:</strong></label>
				<p class="name_user"><?php echo $horario['chd_inicio'] . " - " . $horario['chd_fin']; ?></p>
				<label for="name"><strong>Estatus de la cita:</strong></label>
				<p class="name_user"><?php if ($horario['chd_estatus'] == 1) {
                    echo '<span class="badge badge-primary">DISPONIBLE PARA RESERVAR</span>';
                  } else {
                    echo '<span class="badge badge-danger">OCUPADO/RESERVADO</span>';
                  } ?></p>
				<input type="submit" name="" value="Cancelar" class="boton">
		</form>
      </div>
    </div>
  </div>
	<div class="row options-below">
 		<div class="option-below col-md-12">
       <h5><a class="option" href="admin_departamentos.php"><i class="icono-left fa fa-mail-reply"></i>Volver</a></h5>
     </div>
   </div>
</div>


 <?php include_once '../templates/footer.php'; ?>