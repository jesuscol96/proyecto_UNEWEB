<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Propuestas</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/ver_oferta_js.js"></script>
	<script src="js/funciones.js"></script>	
</head>
<body>	
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();

eliminar_propuesta();

?>

<table id="tabla_propuestas">
	<tr>
		<th>Propuestas recibidas</th>
		<th>Propuestas hechas por mí</th>
	</tr>
	<tr>
		<td><?php ver_propuestas();  ?></td>
		<td><?php ver_mispropuestas(); ?></td>
	</tr>
</table>

<?php include 'html/footer.html'; ?>



