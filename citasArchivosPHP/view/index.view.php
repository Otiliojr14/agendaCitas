<?php

include_once 'templates/header.php';

 ?>

 <div class="header-admin container row">
   <div class="admin-nombre col-sm-6 d-none d-sm-block">
     <h5><i class="admin-icon fa fa-user"></i>Bienvenido, <?php
		 if(!empty($name_user['cal_nombre'])) {
				echo $name_user['cal_nombre'];
			} elseif (!empty($name_user['cper_nombre'])) {
				echo $name_user['cper_nombre'];
			} ?></h5>
   </div>
   <div class="sesion-admin col-sm-6 d-none d-sm-block">
     <h5><a href="cerrar_sesion.php">Cerrar sesión<i class="icono fa fa-sign-out"></i></a></h5>
   </div>
   <div class="admin-nombre col-12 d-sm-none text-center">
     <h5><i class="admin-icon fa fa-user"></i>Bienvenido, <?php
		 if(!empty($name_user['cal_nombre'])) {
				echo $name_user['cal_nombre'];
			} elseif (!empty($name_user['cper_nombre'])) {
				echo $name_user['cper_nombre'];
			} ?></h5>
   </div>
   <div class="sesion-admin col-12 d-sm-none text-center pt-3">
     <h5><a href="cerrar_sesion.php">Cerrar sesión<i class="icono fa fa-sign-out"></i></a></h5>
   </div>
 </div>

 <div class="container">
   <div class="row">
     <div class="contenedor_login col-10 offset-1 col-lg-6 offset-lg-3">
       <div class="contenido_login">
         <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
           <label for="fecha_cita"><i class="admin-icon fa fa-calendar"></i>¿En que día desea registrar su cita?</label>
           <input type="date" id="fecha_cita" name="fecha_cita" min="<?php echo $fecha_actual; ?>" value="" class="input_valor" onBlur="fechaDisponible()" required>
					 <script type="text/javascript">
						 function fechaDisponible() {
							 jQuery.ajax({
							 url: "ajax.php",
							 data:'fecha_cita='+$("#fecha_cita").val(),
							 type: "POST",
							 success:function(data){
								 $('#departamento_cita').html(data);
							 },
							 error:function (){}
							 });
						 };
					 </script>

					 <label for="departamento_cita"><i class="admin-icon fa fa-building"></i>¿En que departamento desea agendar su cita?</label>
					 <select id="departamento_cita" name="departamento_cita" class="input_valor" onBlur="horarioDepartamento()" required>
            </select>
					<script type="text/javascript">
						function horarioDepartamento() {
							jQuery.ajax({
							url: "ajax.php",

              data:{'departamento_cita': $("#departamento_cita").val(),
             'fecha_cita': $("#fecha_cita").val()},
							type: "POST",
							success:function(data){
								$('#hora_cita').html(data);
							},
							error:function (){}
							});
						};
					</script>

           <label for="hora_cita"><i class="admin-icon fa  fa-clock-o"></i>¿A que hora desea agendar su cita?</label>
					 <select id="hora_cita" name="hora_cita" class="input_valor" required>
          </select>

           <label for="motivo_cita"><i class="admin-icon fa fa-pencil-square"></i>Motivo de la cita:</label>
           <textarea name="motivo_cita" class="input_valor" required></textarea>

           <?php if (!empty($errores)): ?>
             <div class="alert error">
                 <?php echo $errores; ?>
             </div>
           <?php endif; ?>
					 <?php if (!empty($aviso)): ?>
             <div class="alert success">
                 <?php echo $aviso; ?>
             </div>
           <?php endif; ?>
           <input type="submit" name="" value="Agendar cita" class="boton">
         </form>
       </div>
     </div>
   </div>
 </div>

<?php include_once 'templates/footer.php'; ?>
