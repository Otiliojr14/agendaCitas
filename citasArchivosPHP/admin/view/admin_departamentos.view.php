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

 <h5 class="text-center pt-3 pb-3"><strong><i class="admin-icon fa fa-building-o"></i>Administrar horario de departamentos</strong></h5>

<div class="container">
  <div class="row">
     <p class="title-admin-option"><i class="admin-icon fa fa-building"></i>Lista de departamentos.</p>
  </div>
  <table class="table table-bordered">
      <thead>
          <tr>
              <th>Departamentos</th>
              <th class="option-basic">Editar horarios</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach ($departamentos as $departamento): ?>
          <tr>
            <td><?php echo utf8_encode($departamento['cdep_nombre']); ?></td>
						<td class="option-basic"><a href="admin_horario.php?id=<?php echo $departamento['id_departamento']; ?>"><i class="fa fa-edit"></i></a></td>
          </tr>
				<?php endforeach; ?>
      </tbody>
  </table>

	<div class="row options-below">
		<div class="option-below col-md-6">
      <h5><a class="option" href="<?php echo RUTA; ?>/admin"><i class="icono-left fa fa-mail-reply"></i>Volver</a></h5>
    </div>
		<div class="option-below col-md-6">
      <h5><a class="option" href="horarioAll.php">Agregar horario a todos los departamentos<i class="icono fa fa-clock-o "></i></</a></h5>
    </div>
  </div>

</div>



<?php include_once '../templates/footer.php'; ?>
