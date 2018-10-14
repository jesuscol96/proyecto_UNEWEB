<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Ofertas</title>
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
<p>Busca ofertas con palabras claves: </p>
<form action="" method="post">
	<input type="text" name="ofertas_kw">
	<input type="submit" value="Buscar">
</form>
<br>

<?php
	buscar_ofertas();

	include 'html/footer.html';
 ?>



</body>
</html>	