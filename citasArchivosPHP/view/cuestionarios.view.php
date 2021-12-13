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
     <div class="contenedor_login col-10 offset-1 col-lg-4 offset-lg-4">
       <div class="contenido_login">
         <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
           <label for="fecha_cita">¿Durante los ultimos 14 días, has presentado uno o más de los siguientes síntomas?</label>
            <input type="checkbox" id="fiebre" name="fiebre" value="1">
            <label for="fiebre"> Fiebre</label><br>
            <input type="checkbox" id="tos" name="tos" value="1">
            <label for="tos"> Tos seca</label><br>
            <input type="checkbox" id="olfato" name="olfato" value="1">
            <label for="olfato"> Perdida de olfato</label><br>
            <input type="checkbox" id="gusto" name="gusto" value="1">
            <label for="gusto"> Perdida de gusto</label><br>
            <input type="checkbox" id="fatiga" name="fatiga" value="1">
            <label for="fatiga"> Fatiga</label><br>
            <input type="checkbox" id="garganta" name="garganta" value="1">
            <label for="garganta"> Dolor de garganta</label><br>
            <input type="checkbox" id="respiro" name="respiro" value="1">
            <label for="respiro"> Difucultad para respirar</label><br>			
           <input type="submit" name="" value="Continuar" class="boton">
         </form>
       </div>
     </div>
   </div>
 </div>

<?php include_once 'templates/footer.php'; ?>

 
 