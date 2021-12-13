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

<h5 class="text-center pt-3 pb-3"><strong><i class="admin-icon fa fa-calendar-times-o"></i>¿Está seguro de que desea cancelar esta cita?</strong></h5>

<div class="container">
	<div class="row">
    <div class="contenedor_login col-10 offset-1 col-lg-6 offset-lg-3">
      <div class="contenido_login">
		<form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $idcita; ?>" method="post">
				<input type="hidden" id="idCita" name="idCita" value="<?php echo $idcita; ?>">
				<label for="matricula"><strong>Matrícula o identificador:</strong></label>
				<p class="name_user"><?php echo $cita['clave_usuario']; ?></p>
				<label for="name"><strong>Nombre:</strong></label>
				<p class="name_user"><?php if(!empty($cita['cal_nombre_full'])) {
						echo utf8_encode($cita['cal_nombre_full']);
					} elseif (!empty($cita['cper_nombre'])) {
						echo utf8_encode($cita['cper_nombre']);
					}?></p>
				<label for="name"><strong>Telefono del usuario:</strong></label>
				<p class="name_user"><?php if(!empty($cita['cper_telefono'])) {
						echo $cita['cper_telefono'];
					} else {
						echo "Telefóno no disponible";
					} ?></p>
				<label for="name"><strong>Email del usuario:</strong></label>
				<p class="name_user"><?php if(!empty($cita['cper_correo'])) {
						echo $cita['cper_correo'];
					} else {
						echo "Email no disponible";
					} ?></p>
				<label for="name"><strong>Departamento de la cita:</strong></label>
				<p class="name_user"><?php echo utf8_encode($cita['cdep_nombre']); ?></p>
				<label for="fecha_cita"><strong>Fecha de cita:</strong></label>
				<p class="name_user"><?php echo cambiaf_a_espanol($cita['relaci_fecha']); ?></p>
				<label for="name"><strong>Hora de inicio:</strong></label>
				<p class="name_user"><?php echo $cita['chd_inicio']; ?></p>
				<label for="name"><strong>Hora de fin:</strong></label>
				<p class="name_user"><?php echo $cita['chd_fin']; ?></p>
				<label for="name"><strong>Motivo de la cita:</strong></label>
				<p class="name_user"><?php echo utf8_encode(nl2br($cita['relaci_motivo'])); ?></p>
				<input type="submit" name="" value="Cancelar" class="boton">
		</form>
      </div>
    </div>
  </div>
	<div class="row options-below">
 		<div class="option-below col-md-12">
       <h5><a class="option" href="departamentoCitas.php"><i class="icono-left fa fa-mail-reply"></i>Volver</a></h5>
     </div>
   </div>
</div>




 <?php include_once '../templates/footer.php'; ?>