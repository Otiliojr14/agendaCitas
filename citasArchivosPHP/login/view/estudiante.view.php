<?php include_once '../templates/header.php';
			require_once ('../templates/funciones/bd_conexion.php');
?>
		<h4 class="text-center pt-3"><i class="admin-icon fa fa-user"></i>Tipo de usuario: Estudiante</h4>
<?php
			include '../templates/estado_citas.php';
?>
			<div class="row indicacion">
				<div class="container pt-2 pb-2">
					<h5>Ingrese los datos</h5>
				</div>
			</div>
		</div>
		<!-- /Notificaciones -->
		<!-- Login cuadro -->
		<div class="container">
			<div class="row">
				<div class="contenedor_login col-10 offset-1 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
					<div class="contenido_login">
						<form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
							<label for="matricula">Matricula:</label>
							<input type="text" id="matricula" name="matricula" value="" class="input_valor" onBlur="mostrarEstudiante()">
							<script type="text/javascript">
							function mostrarEstudiante() {
								jQuery.ajax({
								url: "mostrar_Nombre.php",
								data:'matricula='+$("#matricula").val(),
								type: "POST",
								success:function(data){
									$('#student_name').html(data);
								},
								error:function (){}
								});
							};
							</script>
							<p id="student_name"></p>
							<label for="password">Contraseña:</label>
							<input type="password" name="password" id="password" value="" class="input_valor">
							<?php if (!empty($errores)): ?>
								<div class="alert error">
										<?php echo $errores; ?>
								</div>
							<?php endif; ?>
							<input type="submit" name="" value="Ingresar" class="boton">
						</form>
					</div>
				</div>
			</div>
		</div>
<?php include_once '../templates/footer.php'; ?>
