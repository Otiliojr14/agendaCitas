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

<h5 class="text-center pt-3 pb-3"><strong><i class="admin-icon fa fa-calendar-plus-o"></i>Lista de horarios de <?php echo utf8_encode($departamento['cdep_nombre']); ?></strong></h5>


<div class="container">
	<table class="table table-bordered pt-3">
      <thead>
          <tr>
							<th>Fecha</th>
              <th>Día</th>
              <th>Hora inicio</th>
              <th>Hora final</th>
              <th>Estado</th>
              <th class="option-basic">Desactivar horario</th>
          </tr>
      </thead>
			<tbody>
				<?php foreach ($horas as $hora): ?>
          <tr>
            <td><?php echo cambiaf_a_espanol($hora['chd_fecha']); ?></td>
            <td><?php echo get_nombre_dia($hora['chd_fecha']); ?></td>
            <td><?php echo $hora['chd_inicio']; ?></td>
            <td><?php echo $hora['chd_fin']; ?></td>
            <td><?php if ($hora['chd_estatus'] == 1) {
              echo '<span class="badge badge-primary">LIBRE</span>';
            } else {
              echo '<span class="badge badge-danger">RESERVADO</span>';
            } ?></td>
            <td class="option-basic"><a href="cancelar_horario.php?id=<?php echo $hora['id_horario']; ?>"><i class="fa fa-times"></i></a></td>
          </tr>
				<?php endforeach; ?>
			</tbody>
  </table>

  <?php
  include_once 'view/paginacion.php';
  ?>

	<div class="row options-below">
		<div class="option-below col-md-4">
      <h5><a class="option" href="admin_departamentos.php"><i class="icono-left fa fa-mail-reply"></i>Volver</a></h5>
    </div>
    <div class="option-below col-md-4">
      <h5><a class="option" href="añadirHoraPersonalizada.php?id=<?php echo $id; ?>">Agregar hora personalizada<i class="icono fa fa-clock-o "></i></a></h5>
    </div>
		<div class="option-below col-md-4">
      <h5><a class="option" href="añadirHoraDia.php?id=<?php echo $id; ?>">Agregar horas por dia<i class="icono fa fa-clock-o "></i></a></h5>
    </div>
  </div>
</div>


</div>


 <?php include_once '../templates/footer.php'; ?>
