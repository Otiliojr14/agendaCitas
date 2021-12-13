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

<h5 class="text-center pt-3 pb-3"><strong><i class="admin-icon fa fa-building"></i>Departamento: Logística</strong></h5>

 <div class="container">
   <div class="row">
      <p class="title-admin-option"><i class="admin-icon fa fa-calendar-check-o"></i>Lista de citas registradas</p>
   </div>
   <table class="table table-bordered">
       <thead>
           <tr>
               <th>Matricula</th>
               <th>Nombre</th>
               <th>Departamento</th>
               <th>Fecha</th>
               <th>Hora inicio</th>
               <th>Hora final</th>
               <th class="option-basic">Ver motivo</th>
               <th class="option-basic">Asistencia</th>
           </tr>
       </thead>
       <tbody>
			<tbody>
         <?php foreach ($citas as $cita): ?>
					 <tr>
						 <td><?php echo $cita['clave_usuario']; ?></td>
						 <td><?php echo utf8_encode($cita['cal_nombre']); ?></td>
						 <td><?php echo utf8_encode($cita['cdep_nombre']); ?></td>
						 <td><?php
							$diaEspanol = cambiaf_a_espanol($cita['relaci_fecha']);
							echo $diaEspanol;
						?></td>
						 <td><?php echo $cita['chd_inicio']; ?></td>
						 <td><?php echo $cita['chd_fin']; ?></td>
       <td class="option-basic"><a href="detalle_cita.php?id=<?php echo $cita['id_cita']; ?>"><i class="fa fa-file-text-o"></i></a></td>
						 <td class="option-basic"><?php if ($cita['relaci_asistencia'] == 1) {
							echo '<a href = attendance.php?id='. $cita['id_cita'] .'><i class="fa fa-check-square-o"></i></a>';
						 } else {
							echo '<a href = attendance.php?id='. $cita['id_cita'] .'><i class="fa fa-square-o"></i></a>';
						 }; ?></td>						 
						 <!-- <td class="option-basic"><a href="cancelar_cita.php?id=<?php echo $cita['id_cita']; ?>"><i class="fa fa-calendar-times-o"></i></a></td> -->
					 </tr>
         <?php endforeach; ?>
		 <?php foreach ($citasProfesor as $citaProfesor): ?>
					 <tr>
						 <td><?php echo $citaProfesor['clave_usuario']; ?></td>
						 <td><?php echo utf8_encode($citaProfesor['cper_nombre']); ?></td>
						 <td><?php echo utf8_encode($citaProfesor['cdep_nombre']); ?></td>
						 <td><?php
							$diaEspanol = cambiaf_a_espanol($citaProfesor['relaci_fecha']);
							echo $diaEspanol;
						?></td>
						 <td><?php echo $citaProfesor['chd_inicio']; ?></td>
						 <td><?php echo $citaProfesor['chd_fin']; ?></td>
       <td class="option-basic"><a href="detalle_cita.php?id=<?php echo $citaProfesor['id_cita']; ?>"><i class="fa fa-file-text-o"></i></a></td>
						 <td class="option-basic"><?php if ($citaProfesor['relaci_asistencia'] == 1) {
							echo '<a href = attendance.php?id='. $citaProfesor['id_cita'] .'><i class="fa fa-check-square-o"></i></a>';
						 } else {
							echo '<a href = attendance.php?id='. $citaProfesor['id_cita'] .'><i class="fa fa-square-o"></i></a>';
						 }; ?></td>						 
						<!-- <td class="option-basic"><a href="cancelar_cita.php?id=<?php echo $citaProfesor['id_cita']; ?>"><i class="fa fa-calendar-times-o"></i></a></td> -->
					 </tr>
         <?php endforeach; ?>
		 <?php foreach ($citasExterno as $citaExterno): ?>
					 <tr>
						 <td><?php echo $citaExterno['clave_usuario']; ?></td>
						 <td><?php echo utf8_encode($citaExterno['cper_nombre']); ?></td>
						 <td><?php echo utf8_encode($citaExterno['cdep_nombre']); ?></td>
						 <td><?php
							$diaEspanol = cambiaf_a_espanol($citaExterno['relaci_fecha']);
							echo $diaEspanol;
						?></td>
						 <td><?php echo $citaExterno['chd_inicio']; ?></td>
						 <td><?php echo $citaExterno['chd_fin']; ?></td>
       <td class="option-basic"><a href="detalle_cita.php?id=<?php echo $citaExterno['id_cita']; ?>"><i class="fa fa-file-text-o"></i></a></td>
						 <td class="option-basic"><?php if ($citaExterno['relaci_asistencia'] == 1) {
							echo '<a href = "#"><i class="fa fa-check-square-o"></i></a>';
						 } else {
							echo '<a href = "#"><i class="fa fa-square-o"></i></a>';
						 }; ?></td>
						 
						 <!-- <td class="option-basic"><a href="cancelar_cita.php?id=<?php echo $citaExterno['id_cita']; ?>"><i class="fa fa-calendar-times-o"></i></a></td> -->
					 </tr>
         <?php endforeach; ?>
       </tbody>
   </table>

	<?php if (empty($citas) && empty($citasProfesor) && empty($citasExterno)): ?>
		<h5 class="text-center pt-3 pb-3"><i class="admin-icon fa fa-calendar-times-o"></i>Todavía no hay citas registradas.</h5>
	<?php endif; ?>

 </div>

<?php include_once '../templates/footer.php'; ?>