<?php
include_once '../templates/header.php';
 ?>
 <div class="header-admin container row">
   <div class="admin-nombre col-md-8">
     <h5><i class="admin-icon fa fa-user"></i>Administrador: <?php echo utf8_encode($name_user['cper_nombre']) ?></h5>
   </div>
   <div class="sesion-admin col-md-4">
     <h5><a href="cerrar_sesion.php">Cerrar sesión<i class="icono fa fa-sign-out"></i></a></h5>
   </div>
 </div>

 <h5 class="text-center pt-3 pb-3"><strong><i class="admin-icon fa fa-calendar-minus-o"></i>Eleminar día festivo</strong></h5>

 <div class="container">
	 <div class="row">
		 <div class="contenedor_login col-10 offset-1 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
			 <div class="contenido_login">
				 <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
					 <label for="no_adm">¿Desea eleminar este día festivo?</label>
					 <p class="name_user"><?php echo cambiaf_a_espanol($festivo['cfe_fecha']);?></p>
					 <label for="no_adm">Día de la semana:</label>
					 <p class="name_user"><?php echo get_nombre_dia($festivo['cfe_fecha']);?></p>
					 <input type="hidden" value="<?php echo $festivo['id_feriado']; ?>" name="id">
					 <input type="submit" name="" value="Eleminar" class="boton">
				 </form>
			 </div>
		 </div>
	 </div>

	 <div class="row options-below">
		 <div class="option-below col-md-12">
			 <h5><a class="option" href="<?php echo RUTA; ?>/admin/admin_festivos.php"><i class="icono-left fa fa-mail-reply"></i>Volver</a></h5>
		 </div>
	 </div>
 </div>

 <?php include_once '../templates/footer.php'; ?>
