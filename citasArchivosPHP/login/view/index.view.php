<?php include_once '../templates/header.php';
			require_once ('../templates/funciones/bd_conexion.php');
			include_once '../templates/estado_citas.php';
?>


			<div class="row indicacion">
				<div class="container pt-2 pb-2">
					<h5>Indica el tipo de usuario</h5>
				</div>
			</div>
		</div>
		<!-- /Notificaciones -->
		<!-- Elegir usuario -->
		<div class="container">
			<div class="row">
				<div class="contenedor_usuario col-sm-6 col-lg-4">
					<a href="estudiante.php" class="link_cuadro">
						<div class="tipo_usuario">
							<img src="<?php echo RUTA; ?>/img/student.png" alt="" height="200px">
							<h3>Estudiante</h3>
						</div>
					</a>
				</div>
				<div class="contenedor_usuario col-sm-6 col-lg-4">
					<a href="profesor.php" class="link_cuadro">
						<div class="tipo_usuario">
							<img src="<?php echo RUTA; ?>/img/teacher.png" alt="" height="200px">
							<h3>Profesor</h3>
						</div>
					</a>
				</div>
				<div class="contenedor_usuario col-sm-6 col-lg-4">
					<a href="administrativo.php" class="link_cuadro">
						<div class="tipo_usuario">
							<img src="<?php echo RUTA; ?>/img/administrator.png" alt="" height="200px">
							<h3>Administrativo</h3>
						</div>
					</a>
				</div>
				<div class="contenedor_usuario col-sm-6 col-lg-4 d-lg-none">
					<a href="usuario_externo.php" class="link_cuadro">
						<div class="tipo_usuario">
							<img src="<?php echo RUTA; ?>/img/user.png" alt="" height="200px">
							<h3>Usuario Externo</h3>
						</div>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="contenedor_usuario offset-lg-4 col-lg-4 d-none d-lg-block">
					<a href="usuario_externo.php" class="link_cuadro">
						<div class="tipo_usuario">
							<img src="<?php echo RUTA; ?>/img/user.png" alt="" height="200px">
							<h3>Usuario Externo</h3>
						</div>
					</a>
				</div>
			</div>
			</div>
		</div>
<?php include_once '../templates/footer.php'; ?>
