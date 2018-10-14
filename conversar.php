<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Chats</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/conversar_js.js"></script>
	<script src="js/funciones.js"></script>	
</head>
<body>	
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();

?>

<div id="main_chat">

	<div id="chat_list">
		<input type="text" name="user_keyword">
		<input type="submit" value="Buscar">
		
		<div id="users_list"></div>		
	</div>

	<div id="chat_activo">

		
		<div id="mensajes_recibidos"></div>


		<table  id="chat_tabla">
		<tr>
			<td><input id="mensaje" ></td>
			<td><button id="enviar">Enviar</button></td>
			<td><button id="eliminar_chat">Eliminar chat</button></td>
		</tr>		
		</table>		
	</div>

			

</div>

<?php include 'html/footer.html'; ?>

</body>
</html>