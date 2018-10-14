<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Ver publicación</title>
	<link rel="stylesheet" href="style.css" />
	<script src="js/jquery.js"></script>
	<script src="js/verpublicacion_js.js"></script>
	<script src="js/funciones.js"></script>	
</head>
<body>	
<?php
require_once 'dblink.php';
include 'funciones.php';
include 'html/header.html';
include_menu();

if(isset($_POST["id_publicaciones"]))
	ver_publicacion();
else
	echo "Error: no se encontró ninguna publicación";

if(isset($_SESSION["id_usuarios"]) and isset($_POST["id_publicaciones"]))
	form_post($_POST["id_publicaciones"],"publicaciones",17);
else
	echo "<p>Inicia sesión para comentar.</p>";
?>


<div id="publicaciones_comentarios">
	<?php
		if(isset($_POST["id_publicaciones"]))
			mostrar_comentarios($_POST["id_publicaciones"],"publicaciones");
	?>
</div>


<?php include 'html/footer.html'; ?>



</body>
</html>