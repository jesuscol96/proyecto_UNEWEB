<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Foros</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/foros_js.js"></script>
	<script src="js/funciones.js"></script>	
</head>
<body>	
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();
?>

<div id="foros_page">

	<div id="buscar_foros">
		<table>
			<tr>
				<th>Buscar:</th>
				<td><input id="input_buscar_foros"></td>
			</tr>			
		</table>
		<div id="resultados"></div>		
	</div>

	<div id="display_foro2">

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

<?php include 'html/footer.html'; ?>
</body>
</html>