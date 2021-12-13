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

<div class="container options-admin">
  <div class="row">
    <div class="contenedor_usuario col-lg-6">
      <a href="admin_festivos.php" class="link_cuadro">
        <div class="tipo_usuario">
          <img src="<?php echo RUTA; ?>/img/calendar.png" alt="" height="200px">
          <h3 class="title-option">Administrar dias festivos</h3>
        </div>
      </a>
    </div>
    <div class="contenedor_usuario col-lg-6">
      <a href="admin_departamentos.php" class="link_cuadro">
        <div class="tipo_usuario">
          <img src="<?php echo RUTA; ?>/img/department.png" alt="" height="200px">
          <h3 class="title-option">Administrar horarios de departamentos</h3>
        </div>
      </a>
    </div>
  </div>
	<div class="row">
    <div class="contenedor_usuario col-lg-12">
      <a href="departamentoCitas.php" class="link_cuadro">
        <div class="tipo_usuario">
          <img src="<?php echo RUTA; ?>/img/cita.png" alt="" height="200px">
          <h3 class="title-option">Administrar citas</h3>
        </div>
      </a>
    </div>
  </div>
</div>


<?php include_once '../templates/footer.php'; ?>
