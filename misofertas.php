<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Mis ofertas</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/misofertas_js.js"></script>
	<script src="js/funciones.js"></script>	
</head>
<body>	
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();
agregar_categoria_type("ofertas");
eliminar_categorias_type("ofertas");
?>
<form action="" method="post" id="crear_oferta">
	<table border="1">
		<tr>
			<th colspan="2">Crear oferta</th>
		</tr>
		<tr>
			<td>Tema: </td>
			<td>
				<input type="text" name="tema">
			</td>
		</tr>
		<tr>
			<td>Descripción: </td>
			<td>
				<textarea name="descripcion"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" name="submit" value="Crear">
			</td>
		</tr>
	</table>
</form>

<div id="modificar_oferta">
	<form action="" method="post">		
		<input type="hidden" name="id_ofertas">
		<table border="1">
			<tr>
				<th colspan="2">Modificar oferta</th>
			</tr>
			<tr>
				<td>Tema: </td>
				<td>
					<input type="text" name="tema" value="tema">
				</td>
			</tr>
			<tr>
				<td>Descripción: </td>
				<td>
					<textarea name="descripcion"></textarea>
				</td>
			</tr>			
			<tr>
				<td colspan="2" align="center">
					<input type="submit" name="submit_modificar" value="Modificar">
				</td>
			</tr>		
		</table>
	</form>

	<table>
		<form action="" method="post">
			<input type="hidden" name="id_type">			
			<tr>
				<th colspan="2">Agregue una categoría: </th>				
			</tr>
			<tr>
				<td>(puede agregar varias, una a la vez)</td>
				<td><?php mostrar_categorias(); ?></td>
			</tr>
			<tr>
				<td><input type="submit" value="Agregar categoria" name="submit_categoria"></td>
				<td><input type="submit" value="Eliminar categorias" name="delete_categorias"></td>
			</tr>
		</form>					
	</table>

	<form action="procesos.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="form" value="8">
		<input type="hidden" name="id_ofertas">
		<table>
			<tr>
				<th colspan="2">Agregar una imagen</th>				
			</tr>			
			<tr>
				<td colspan="2">
					<input type="file" name="image">
				</td>				
			</tr>
			<tr>
				<td>Descripcion de la imagen: </td>
				<td><input type="text" name="image_descripcion"></td>
			</tr>
			<tr>
				<td colspan="2">
	    			<input type="submit" value="Agregar imagen" name="submit_image">
	    		</td>
			</tr>
			
		</table>
	</form>

	<form action="procesos.php" method="post">
		<input type="hidden" name="id_ofertas">
		<input type="hidden" name="form" value="9">
		<input type="submit" value="Eliminar todas las imagenes" name="delete_images">
	</form>			 
</div>



<?php
	//Crea la oferta al enviar el formulario.
	if(isset($_POST["submit"]))
		crear_oferta();

	if(isset($_POST["submit_modificar"]))
		update_ofertas();
?>

<div id="lista_ofertas">

<?php
	ver_misofertas();

	include 'html/footer.html';
?>

	
	
</div>

</body>
</html>