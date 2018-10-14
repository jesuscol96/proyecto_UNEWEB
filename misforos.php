<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mis foros</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/misforos_js.js"></script>
	<script src="js/funciones.js"></script>
</head>
<body>	
<?php

require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();
if(isset($_SESSION["id_usuarios"])){
?>
<div id="crear_foros">
	<p>Crear un foro:</p>
	<form action="" method="post">
		<table border="1">
			<tr>
				<td>Tema del foro: </td>
				<td><input type="text" name="tema"></td>
			</tr>
			<tr>
				<td>Descripción: </td>
				<td><textarea name="descripcion_foro" id="" cols="30" rows="10"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit_crear_foro" value="Crear foro"></td>
			</tr>
		</table>
	</form>	
</div>

<div><?php
if(isset($_POST["submit_crear_foro"]))
	crear_foro($_SESSION["id_usuarios"],$_POST["tema"],$_POST["descripcion_foro"]);
?></div><?php

?><div id="foros"><div id="foros_list"><?php
mostrar_misforos($_SESSION["id_usuarios"]);
?></div>

<div id="display_foro">

	<div id="foro_mensajes">		
	</div>

	<table  id="foro_tabla">
	<tr>
		<td><input id="mensaje" ></td>
		<td><button id="enviar">Enviar</button></td>
	</tr>		
	</table>

</div>
</div>
<?php
}
	include 'html/footer.html';
?>
</body>
</html>