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

<div class="container">
  <div class="row">
     <p class="title-admin-option"><i class="admin-icon fa fa-calendar"></i>Lista de días festivos registrados</p>
  </div>
  <table class="table table-bordered">
      <thead>
          <tr>
              <th>Fecha</th>
              <th>Día</th>
              <th class="option-basic">Eliminar</th>
          </tr>
      </thead>
      <tbody>

        <?php foreach ($dias as $dia): ?>
					<tr>
						<td><?php
						$diaEspanol = cambiaf_a_espanol($dia['cfe_fecha']);
						echo $diaEspanol;
						?></td>
						<td><?php
						$diaNombre  = get_nombre_dia($dia['cfe_fecha']);
						echo $diaNombre;
						?></td>
						<td class="option-basic"><a href="eleminar_dia.php?id=<?php echo $dia['id_feriado']; ?>"><i class="fa fa-trash"></i></a></td>
					</tr>
        <?php endforeach; ?>
      </tbody>
  </table>
	
	

	<?php $numeroPaginas = totalPaginas($datos_por_pagina, $conexion);?>
	<?php if (!empty($dias)): ?>
	<section class="paginacion">
		<ul>
			<?php if (paginaActual() === 1): ?>
				<li class="disabled"> &laquo; </li>
			<?php else: ?>
				<li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?p=' . paginaActual() - 1; ?>"> &laquo;  </a></li>
			<?php endif ?>

			<?php for($i=1; $i<=$numeroPaginas; $i++): ?>
				<?php if (paginaActual() === $i): ?>
					<li class="active">
						<?php echo $i; ?>
					</li>
				<?php else: ?>
					<li>
						<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?p=' . $i; ?>"> <?php echo $i; ?> </a>
					</li>
				<?php endif; ?>
			<?php endfor; ?>

			<?php if (paginaActual() == $numeroPaginas): ?>
				<li class="disabled"> &raquo; </li>
			<?php else: ?>
				<li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?p=' . paginaActual() + 1; ?>"> &raquo;  </a></li>
			<?php endif ?>
		</ul>
	</section>
	<?php else: ?>
	<h5 class="text-center pt-3 pb-3"><i class="admin-icon fa fa-calendar-times-o"></i>Todavía no hay dias festivos asignados.</h5>
	<?php endif; ?>

  <div class="row options-below">
		<div class="option-below col-md-6">
      <h5><a class="option" href="<?php echo RUTA; ?>/admin"><i class="icono-left fa fa-mail-reply"></i>Volver</a></h5>
    </div>
    <div class="option-below col-md-6">
      <h5><a class="option" href="añadir_dia.php">Agregar<i class="icono fa fa-calendar-plus-o"></i></a></h5>
    </div>
  </div>
</div>

<?php include_once '../templates/footer.php'; ?>
