<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Administrar categorias</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/categorias_js.js"></script>
</head>
<body>
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();

if(isset($_SESSION["tipo"]) and $_SESSION["tipo"]=='A'){


	?>

	<div id="manejar_categorias">
		
		<table>
			<tr>
				<th>Agregue una categoria: </th>
				<td><input type="text" id="nueva_categoria"></td>
				<td><button id="agregar_categoria">Crear categoria</button></td>
				<td><button id="eliminar_categoria">Eliminar categorias</button></td>
			</tr>
		</table>			
		
			

			
	</div>
	<br><br>

	<div id="mostrar_categorias">

		<?php ver_categorias(); ?>

		


		
	</div>







	<?php

}
	include 'html/footer.html';

?>

	
</body>
</html>