<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Admin foros</title>
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

if(isset($_SESSION["tipo"]) and $_SESSION["tipo"]=='A'){

?>

<form action="" method="post">
	<table>
		<tr>
			<td>Buscar:  </td>
			<td><input type="text" name="foro_keyword"></td>
			<td><input type="submit" value="Buscar foros"></td>
		</tr>
	</table>
	
</form>




<?php
	eliminar_admin_foros();
	mostrar_admin_foros();
}

 include 'html/footer.html';
?>



</body>
</html>	