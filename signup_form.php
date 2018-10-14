
<?php

function signup_form($code){

?>

<form action="procesos.php" method="post">
	<input type="hidden" value="<?php echo $code ?>" name="form">

	<table>
		<tr>
			<td>Nombres:</td>
			<td><input type="text" name="nombres"></td>
		</tr>
		<tr>
			<td>Apellidos:</td>
			<td><input type="text" name="apellidos"></td>
		</tr>
		<tr>
			<td>Correo electrónico:</td>
			<td><input type="email" name="correo"></td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>Universidad:</td>
			<td><input type="text" name="universidad"></td>
		</tr>
		<tr>
			<td>Profesión:</td>
			<td><input type="text" name="profesion"></td>
		</tr>
		<tr>
			<td>Clave:</td>
			<td><input type="password" name="clave"></td>
		</tr>
		<tr>
			<td colspan="2"  align="center"><input type="submit" value="Registrarse"></td>
		</tr>
		
	</table>	
	
</form>

<?php
}
?>