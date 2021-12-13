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

 <h5 class="text-center pt-3 pb-3"><strong><i class="admin-icon fa fa-calendar-plus-o"></i>Añadir día festivo</strong></h5>

 <div class="container">
   <div class="row">
     <div class="contenedor_login col-10 offset-1 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
       <div class="contenido_login">
         <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
           <label for="no_adm">Elija el día que desea agregar:</label>
           <input type="date" id="agregar_dia" name="agregar_dia" min="<?php echo $fecha_actual; ?>" value="" class="input_valor" onBlur="mostrarFestivo()" required>
           <script type="text/javascript">
             function mostrarFestivo() {
               jQuery.ajax({
               url: "ajax.php",
               data:'agregar_dia='+$("#agregar_dia").val(),
               type: "POST",
               success:function(data){
                 $('#festivo_aviso').html(data);
               },
               error:function (){}
               });
             };
           </script>
           <p id="festivo_aviso"></p>
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
           <input type="submit" name="" value="Agregar" class="boton">
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
