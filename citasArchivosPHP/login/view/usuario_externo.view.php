<?php include_once '../templates/header.php';
			require_once ('../templates/funciones/bd_conexion.php');
?>
		<h4 class="text-center pt-3"><i class="admin-icon fa fa-user"></i>Tipo de usuario: Externo</h4>
<?php
			include_once '../templates/estado_citas.php';
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
							<label for="curp_rfc">CURP o RFC:</label>
							<input type="text" id="curp_rfc" name="curp_rfc" value="" class="input_valor" onBlur="mostrarExterno()">
							<script type="text/javascript">
							function mostrarExterno() {
								jQuery.ajax({
								url: "mostrar_Nombre.php",
								data:'curp_rfc='+$("#curp_rfc").val(),
								type: "POST",
								success:function(data){
									$('#externo_name').html(data);
								},
								error:function (){}
								});
							};
							</script>
							<p id="externo_name"></p>
							<?php if (!empty($aviso)): ?>
								<div class="alert success">
										<?php echo $aviso; ?>
								</div>
							<?php endif; ?>
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
