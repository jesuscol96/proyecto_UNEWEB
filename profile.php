<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mi perfil</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/profile_js.js"></script>
</head>
<body>
	
<?php


require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';

//Seleccionar menu adecuado
include_menu();

if(isset($_SESSION["id_usuarios"])){


	$extension=upload_image("images/",2000000);
	echo "<br>";
	add_profile_image_db("images/",$extension);		

?>

<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="image">
    <input type="submit" value="Cambiar imagen de perfil" name="submit_image">
</form>

<table id="profile_table">
	<tr>
		<td rowspan="5" width="50%">
			<img src="<?php echo $_SESSION["link_image"];  ?>" alt="Sin imagen">
		</td>
		<td colspan="2">
			<?php 
				echo "<b>Nombre: </b>". "<label class='user_data'>". $_SESSION["nombre"] . "</label>". "  " ."<label class='user_data'>" .
					 $_SESSION["apellido"] . "</label>";
			 ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php 
				echo "<b>Email: </b> <label class='user_data'>" . $_SESSION["email"] . "</label>";
			 ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" >
			<?php 
				echo "<b>Username: </b><label class='user_data'>". $_SESSION["username"] . "</label>";
			 ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php 
				echo "<b>Universidad: </b><label class='user_data'>". $_SESSION["universidad"] . "</label>";
			 ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php 
				echo "<b>Profesión:</b> <label class='user_data'>". $_SESSION["profesion"] . "</label>";
			 ?>
		</td>
		<td>
			<?php echo "<b>Nivel académico:</b> <label class='user_data'>". $_SESSION["nivel_academico"] . "</label>";				
			 ?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<b>Descripción del perfil: </b> <label class="user_data"><?php echo $_SESSION["descripcion"] ?></label>
		</td>
	</tr>

</table>

<button id="modificar_boton">Modificar información</button>



<form action="procesos.php" method="post" id="modificar_tabla" style="display: none;">
	<table>
		<tr>
			<td>Nombre: </td>
			<td><input type="text" name="nombre"></td>
		</tr>
		<tr>
			<td>Apellido: </td>
			<td><input type="text" name="apellido"></td>
		</tr>		
		<tr>
			<td>Email: </td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td>Username: </td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>Universidad: </td>
			<td><input type="text" name="universidad"></td>
		</tr>
		<tr>
			<td>Profesión: </td>
			<td><input type="text" name="profesion"></td>
		</tr>
		<tr>
			<td>Nivel académico: </td>
			<td><input type="text" name="nivel_academico"></td>
		</tr>
		<tr>
			<td colspan="2">Descripción personal: </td>
		</tr>
		<tr>
			<td colspan="2"><textarea name="descripcion"></textarea></td>
		</tr>
		<tr>
			<td>Clave: </td>
			<td><input type="password" name="clave"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="modificar_submit" value="Modificar"></td>
		</tr>

	</table>
	<input type="hidden" name="form" value="26">
</form>

<?php
}

	include 'html/footer.html';
?>

</body>
</html>