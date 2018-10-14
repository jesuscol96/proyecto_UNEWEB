<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Publicaciones</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/funciones.js"></script>	
</head>
<body>	
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();

?>
<p>Busca publicaciones con palabras claves: </p>
<form action="" method="post">
	<input type="text" name="publicaciones_kw">
	<input type="submit" value="Buscar">
</form>
<br>

<?php
	buscar_publicaciones();

	include 'html/footer.html';
 ?>



</body>
</html>	