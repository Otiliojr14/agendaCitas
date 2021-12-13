<?php
require_once ('../templates/funciones/bd_conexion.php');

if(!empty($_POST["matricula"])) {
  $sql = 'SELECT cal_nombre_full FROM Cat_Alumnos WHERE cal_matricula = "'. strtoupper($_POST['matricula']) .'"';
	$resultado = $mysqli->query($sql);
	$student = $resultado->fetch_assoc();

  if($resultado->num_rows > 0) {
      echo "
      <label for='name'>Nombre:</label>
      <p id='name_user'>". $student['cal_nombre_full'] . "</p>";
  }else{
      echo "
			<label for='name'>Nombre:</label>
			<p id='name_user'>No se encontró el usuario</p>";
  }
}

if(!empty($_POST["no_prof"])) {
  $sql = 'SELECT cper_nombre FROM Cat_Personal WHERE cper_empleado = "'. ($_POST['no_prof']) .'"';
	$resultado = $mysqli->query($sql);
	$teacher = $resultado->fetch_assoc();

  if($resultado->num_rows > 0) {
      echo "<label for='name'>Nombre:</label>
      <p id='name_user'>". $teacher['cper_nombre'] . "</p>";
  }else{
      echo "<p id='name_user'>No se encontró el usuario</p>";
  }
}

if(!empty($_POST["no_adm"])) {
  $sql = 'SELECT cper_nombre FROM Cat_Personal WHERE cper_empleado = "'. ($_POST['no_adm']) .'"';
	$resultado = $mysqli->query($sql);
	$administrative = $resultado->fetch_assoc();

  if($resultado->num_rows > 0) {
      echo "<label for='name'>Nombre:</label>
      <p id='name_user'>". $administrative['cper_nombre'] . "</p>";
  }else{
      echo "<p id='name_user'>No se encontró el usuario</p>";
  }
}

if(!empty($_POST["curp_rfc"])) {
  $sql = 'SELECT cper_nombre, cper_apat FROM Cat_Personas WHERE cper_curp = "'. strtoupper($_POST['curp_rfc']).'"';
	$resultado = $mysqli->query($sql);
	$externo = $resultado->fetch_assoc();

  if($resultado->num_rows > 0) {
      echo "<label for='name'>Nombre:</label>
      <p id = 'name_user'>". $externo['cper_nombre'] . ' ' . $externo['cper_apat'] . "</p>" . '
      <label for="password">Contraseña:</label>
      <input type="password" name="password" value="" class="input_valor" required>';
  }else{
		$sql = 'SELECT * FROM Cat_Sexo';
		$resultado = $mysqli->query($sql);
		$sexo = $resultado->fetch_assoc();
		
      echo '
      <label for="name">Nombre:</label>
			<input type="text" name="name" value="" class="input_valor" required>
			<label for="apellido_materno">Apellido paterno:</label>
			<input type="text" name="apellido_paterno" value="" class="input_valor" required>
			<label for="apellido_materno">Apellido materno:</label>
			<input type="text" name="apellido_materno" value="" class="input_valor" required>
			<label for="genero">Género:</label>
			<select id="genero" name="genero" class="input_valor" required>
				<option value="1">Masculino</option>
				<option value="2">Femenino</option>
      </select>
			<label for="fecha_nacimiento">Fecha de nacimiento:</label>
			<input type="date" name="fecha_nacimiento" value="" class="input_valor" required>
			<label for="mail">Email:</label>
			<input type="email" name="mail" value="" class="input_valor" required>
			<label for="phone">Teléfono:</label>
			<input type="text" name="phone" value="" class="input_valor" required>
			<label for="tutor">Tutor:</label>
			<input type="text" name="tutor" value="" class="input_valor" required>
      <p class="alert registro">No se encontró el usuario en el sistema. Ingrese los datos para registrarse. Cuando se registre, puede tardar un momento en registrar los datos al sistema.</p>';
  }
}

 ?>
