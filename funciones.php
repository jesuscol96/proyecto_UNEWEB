<?php
function signup($tipo){

	//Get info from form
	$nombres=$_POST['nombres'];
	$apellidos=$_POST['apellidos'];
	$correo=$_POST['correo'];
	$username=$_POST['username'];
	$univ=$_POST['universidad'];
	$profesion=$_POST['profesion'];
	$clave=$_POST['clave'];
	$clave=md5($clave);

	//Require to access to global object
	global $link;

	//Check username and password
	$sql="SELECT username, email FROM usuarios WHERE username='$username' OR email='$correo'";

	if($result=$link->query($sql)){
	
		if($result->num_rows == 0){

			//Crear usuario nuevo
			$sql="INSERT INTO usuarios(nombre,apellido,email,username,universidad,profesion,clave,tipo)
				  VALUES ('$nombres','$apellidos', '$correo', '$username', '$univ', '$profesion', '$clave', '$tipo');";

			if($link->query($sql))
				echo "Usuario registrado exitosamente";
			else
				echo "Lo sentimos, ha ocurrido un error al registrar los datos.";
		}
		else
			echo "El correo electrónico o username ingresado ya ha sido usado, por favor intente de nuevo.";
	}
	else
		echo "Lo sentimos, ha ocurrido un error al registrar los datos.";

}

function login($user,$clave){

	//Data from form
	if(isset($_POST['user']) and isset($_POST['clave'])){

		$user=$_POST['user'];
		$clave=$_POST['clave'];
	}


	$clave=md5($clave);

	//Access to database
	global $link;

	//Check
	$sql="SELECT * FROM usuarios WHERE (username='$user' OR email='$user') AND clave='$clave'";
	
	if($result=$link->query($sql)){

		if($result->num_rows >0){
			
			$row=$result->fetch_assoc();						

			//Store info in superglobals session
			$_SESSION["id_usuarios"]=$row["id_usuarios"];
			$_SESSION["nombre"]=$row["nombre"];
			$_SESSION["apellido"]=$row["apellido"];
			$_SESSION["tipo"]=$row["tipo"];
			$_SESSION["email"]=$row["email"];
			$_SESSION["username"]=$row["username"];
			$_SESSION["link_image"]=$row["link_image"];
			$_SESSION["universidad"]=$row["universidad"];
			$_SESSION["profesion"]=$row["profesion"];
			$_SESSION["nivel_academico"]=$row["nivel_academico"];
			$_SESSION["descripcion"]=$row["descripcion"];

			echo "Ha iniciado su sesión correctamente.";
		}
		else
			echo "Ha ingresado un usuario que no existe o su clave erroneamente. Intente de nuevo.";
	}
	else
		echo "Lo sentimos, ocurrio un error al intentar accesar a su cuenta.";

}


function upload_image($path,$max_size){

	if(isset($_POST["submit_image"])){

		$extension=strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));
		$target=$path . "temporal_image_file" . "." . $extension;
		$check = getimagesize($_FILES["image"]["tmp_name"]);
		
		if($check!=false){

			if($extension== "jpg" or $extension== "jpeg" or $extension== "png" or $extension== "gif"){

				if($_FILES["image"]["size"]<$max_size){

					if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)){

						echo "Archivo cargado exitosamente.";
						return $extension;
					}
					else
						echo "No fue posible subir su archivo.";

				}
				else
					echo "Tamaño máximo de archivo superado, debe ser menor a " . $max_size/1000000 . "MB";
			}

			else
				echo "Formato no aceptado, solo se aceptan formatos jpg, jpeg, png y gif.";

		}

		else
			echo "El archivo seleccionado no es una imagen";

	}
	else 
		echo "No se recibió ninguna imagen.";

}

function add_profile_image_db($path,$extension){

	$source=$path . "temporal_image_file" . "." . $extension;
	if(isset($_SESSION['id_usuarios'])){

		if(file_exists($source)){

			$target=$path . "profile_image_" . $_SESSION['id_usuarios'] . "." . $extension;
			global $link;
			$sql="UPDATE usuarios SET link_image='$target' WHERE id_usuarios=$_SESSION[id_usuarios]";
			if($link->query($sql)){

				rename($source,$target);
				$_SESSION["link_image"]= $target;
				echo "Su imagen de perfil ha sido actualizada";

			}			


		}

	}
}

function crear_foro($fk_usuarios, $tema, $descripcion){

	$sql="INSERT INTO foros(fk_usuarios, tema, descripcion) VALUES ('$fk_usuarios','$tema','$descripcion')";
	global $link;
	if($link->query($sql))
		echo "Foro creado";
	else
		echo "Error creando foro.";

}

function mostrar_misforos($fk_usuarios){

	$sql="SELECT id_foros,tema, descripcion FROM foros WHERE fk_usuarios='$fk_usuarios'";
	global $link;
	echo '<table id="foros_creados">';
	echo "<tr><th>Foros creados por mí:</th></tr>";
	if($result=$link->query($sql)){


		while ($row=$result->fetch_assoc()) 
			echo '<tr onclick="foro_request(' . $row["id_foros"]. ')"' ."><td>Foro <b>". $row["tema"] ."</b>: " . $row["descripcion"] . "</tr>"; 
		echo "</table>";
	}		
	else
		echo "Error al cargar sus foros";

}


function mostrar_foro($id_foro){


	if(isset($_POST["id_foros"]))
		$id_foro=$_POST["id_foros"];	

	global $link;
	//Info del foro
	$sql="SELECT tema, descripcion FROM foros WHERE id_foros='$id_foro'";	
	$result=$link->query($sql);
	$row=$result->fetch_assoc();
	$tema=$row["tema"];
	$descripcion=$row["descripcion"];

	//tema y descripcion
	echo "<p><b>Tema: " . $tema . " Descripción: " . $descripcion . "</b></p>";
	

	//Mensajes
	$sql= "SELECT fk_usuarios, fk_foros, fecha, contenido FROM foro_comentarios WHERE fk_foros='$id_foro'";	
	$result=$link->query($sql);
	while($row=$result->fetch_assoc()){

		$username = get_username($row["fk_usuarios"]);
		
		echo "<p><b>" . $username .":</b></p>";		
		echo "<p> " . $row["contenido"] . "</p>";
		echo "<p>" . $row["fecha"] . "</p>";		
	}

}

function mensaje_foro(){

	$mensaje=$_POST["mensaje"];
	$fk_foro=$_POST["id_foro"];

	if(isset($_SESSION["id_usuarios"])){
		$fk_usuarios = $_SESSION["id_usuarios"];


		$sql="INSERT INTO foro_comentarios(fk_usuarios, fk_foros, fecha, contenido)
			   VALUES ('$fk_usuarios','$fk_foro',NOW(),'$mensaje')";

	    global $link;
	    if($link->query($sql))
	    	mostrar_foro($fk_foro); 
	}
	else
		echo "Inicia sesión para participar.";
    
}

function include_menu(){

	if(isset($_SESSION["id_usuarios"])){

	//Seleccionar menu adecuado
	if($_SESSION['tipo']=='A')
		include 'html/menu_admin.html';
	else
		include 'html/menu_usuario.html';	
	}

//default sin usuario
	else
		include 'html/menu.html';	

}


function buscar_foros(){

	//Extrat keyword
	$keyword=$_POST["keyword"];

	$sql="SELECT * FROM foros WHERE (tema LIKE '%$keyword%') OR (descripcion LIKE '%$keyword%')";

	global $link;
	if($result=$link->query($sql)){

		if($result->num_rows>0){

			echo "<table>";

			while($row=$result->fetch_assoc()){

				//Get username
				$sql="SELECT username FROM usuarios WHERE id_usuarios='$row[fk_usuarios]'";		
				$result2=$link->query($sql);
				$result2=$result2->fetch_assoc();
				$username = $result2["username"];


				echo '<tr onclick="foro_request(' . $row["id_foros"]. ')"' .'><td>';				
				echo "<b>Tema: </b>" . $row["tema"] . " " . "<b>Creador: </b>" . $username;
				echo "</td></tr>";			

			}

			echo "</table>";
		}
		else
			echo "No se encontraron foros.";

	}

	else
		echo $link->error;

}

function crear_oferta(){

	if($_SESSION["id_usuarios"]){

		$id_usuarios=$_SESSION["id_usuarios"];
		$tema=$_POST["tema"];
		$descripcion=$_POST["descripcion"];

		$sql="INSERT INTO ofertas(fk_usuarios, tema, descripcion,fecha)  VALUES('$id_usuarios', '$tema', '$descripcion',NOW())";
		global $link;
		if($link->query($sql))
			echo "Oferta creada";
		else
			echo "Error creado oferta";

	}
}

function ver_misofertas(){

	if($_SESSION["id_usuarios"]){

		$id_usuarios=$_SESSION["id_usuarios"];
		

		$sql="SELECT id_ofertas, tema, descripcion FROM ofertas WHERE fk_usuarios='$id_usuarios'";
		global $link;
		if($result=$link->query($sql)){

			if($result->num_rows>0){

				while($row=$result->fetch_assoc()){  ?>

					
					<table border="1"  <?php   echo 'name="' . $row['id_ofertas'] .'"';    ?>>
						<tr><th colspan="2"><?php echo $row["tema"]; ?></th></tr>
						<tr>
							<td rowspan="3"><?php echo $row["descripcion"]; ?></td>
							<td>
								<form action="veroferta.php" method="post">
									<input type="hidden" name="id_oferta" value="<?php echo $row['id_ofertas']; ?>">
									<input type="submit" value="Ver">
								</form>
							</td>
						</tr>
						<tr>
							<td><button id="modificar"
							 <?php echo 'onclick="modificar_oferta(' . $row['id_ofertas'] . ')"'  ?> >Modificar
							</button></td>
						</tr>
						<tr>
							<td>
								<form action="procesos.php" method="post">
									<input type="hidden" name="eliminar_oferta" value="<?php echo $row['id_ofertas']; ?>">
									<input type="hidden" name="form" value="7">
									<input type="submit" value="Eliminar">
								</form>					
							</td>
						</tr>
					</table>
		<?php

				}
			}
			else
				echo "Ud. no tiene ofertas.";
		}
	}
}

function eliminar_oferta(){

	$id_ofertas=$_POST["eliminar_oferta"];

	$sql="DELETE FROM ofertas WHERE id_ofertas='$id_ofertas'";
	global $link;
	$link->query($sql);


}

function update_ofertas(){

	$id_ofertas=$_POST["id_ofertas"];	
	$tema=$_POST["tema"];
	$descripcion=$_POST["descripcion"];

	$sql="UPDATE ofertas SET tema='$tema', descripcion='$descripcion' WHERE id_ofertas='$id_ofertas'";
	global $link;

	if($link->query($sql))
		echo "Oferta actualizada";
	else
		"No se pudo actualizar la oferta";

}

function add_oferta_image_db($path,$extension){

	$descripcion=$_POST["image_descripcion"];
	$id_ofertas=$_POST["id_ofertas"];
	$source=$path . "temporal_image_file" . "." . $extension;

	if(isset($_SESSION['id_usuarios'])){

		if(file_exists($source)){

			global $link;
			//Crear registro de imagen
			$sql="INSERT INTO media_ofertas(descripcion,type,fk_ofertas) VALUES('$descripcion','imagen','$id_ofertas')";
			$link->query($sql);

			//Obtener el id de la imagen
			$sql="SELECT MAX(id_media_ofertas) FROM media_ofertas";
			$last_id=$link->query($sql)->fetch_assoc();
			$last_id=$last_id["MAX(id_media_ofertas)"];
			//		

			$target=$path . "imagen_oferta_" . $last_id . "." . $extension;
			global $link;
			$sql="UPDATE media_ofertas SET link='$target' WHERE id_media_ofertas='$last_id'";
			if($link->query($sql)){

				rename($source,$target);

				echo "Imagen agregada";

				//Done
			}
			else 
				echo $link->error;	
		}
		else
			echo "file does not exist";
	}
}

function eliminar_imagenes(){

	$id_ofertas=$_POST["id_ofertas"];

	global $link;
	$sql = "SELECT link FROM media_ofertas WHERE fk_ofertas='$id_ofertas'";

	//borrar imagenes.
	if($result=$link->query($sql))
		while($row=$result->fetch_assoc())
			unlink($row["link"]);
		
	
	//Borrar registros.
	$sql = "DELETE FROM media_ofertas WHERE fk_ofertas='$id_ofertas'";
	$link->query($sql);

}

function ver_oferta(){


	if(isset($_POST["id_oferta"])){

		$id_ofertas=$_POST["id_oferta"];
		$sql="SELECT * FROM ofertas WHERE id_ofertas='$id_ofertas'";
		global $link;
		$row=$link->query($sql)->fetch_assoc();

		//Obtener tema y descripcion
		$tema=$row["tema"];
		$descripcion=$row["descripcion"];
		$fecha=$row["fecha"];

		//Obtener username.
		$fk_usuarios=$row["fk_usuarios"];
		$sql="SELECT username FROM usuarios WHERE id_usuarios='$fk_usuarios'";		
		$username=$link->query($sql)->fetch_assoc()["username"];

		//Obtener links de las imagenes.
		$sql="SELECT link FROM media_ofertas WHERE fk_ofertas='$id_ofertas'";		
		$result1=$link->query($sql);
		$sql="SELECT descripcion FROM media_ofertas WHERE fk_ofertas='$id_ofertas'";	
		$result2=$link->query($sql);

		//Check fav
		if($sel=is_fav($id_ofertas,"ofertas"))
			$fav="Hacer favorito";
		else
			$fav="Quitar favorito";
					

		?>



		<table id="tabla_oferta" border="1">
			<tr>
				<th><?php echo $tema;   ?></th>
				<th>Por: <?php echo $username;   ?></th>
				<td><b>Publicado el:</b> <?php echo $fecha; ?></td>
				<td>
					<?php if(isset($_SESSION["id_usuarios"])){ ?>
						<button id="hacer_propuesta">Hacer una propuesta</button>
					<?php } ?>
					</td>
				<td>
					<?php if(isset($_SESSION["id_usuarios"])){ ?>
						<button id="fav" onclick="<?php echo "fav(24,$id_ofertas,$sel)" ?>"> <?php echo $fav; ?></button>
					<?php } ?>
				</td>
			</tr>

			
			<tr>
				<td colspan="5">
					<?php 
						if($result1->num_rows){
							$i=0;
							while($row=$result1->fetch_assoc()){
								echo '<img style="display: none" class="image_oferta" src="'. $row["link"] .'" alt="No se pudo cargar la imagen">';
								$i++;
							}
						}
						else
							echo "Sin imagenes."
					  ?>					
				</td>		
			</tr>
			<tr>
				<td colspan="5">
					<?php 
						if($result2->num_rows){
							$i=0;
							echo "<b>Descrición de la imagen: </b>";
							while($row=$result2->fetch_assoc()){
								echo '<div class="image_descripcion" style="display: none">'. $row["descripcion"] .'</div>';
								$i++;
							}
						}						
					  ?>
				</td>
			</tr>
			<tr>
				<td><button id="anterior">Anterior</button></td>
				<td colspan="4"><button id="siguiente">Siguiente</button></td>
			</tr>
			<tr>
				<td colspan="5"><b>Categorías: </b> <?php identificar_categorias("ofertas",$id_ofertas); ?></td>
			</tr>
			<tr>
				<td colspan="5"><?php echo "<p><b>Descrición de la oferta: </b></p>" .$descripcion;   ?></td>
			</tr>
		</table>

		<?php
	}

	else
		echo "Error: no se encontró ninguna oferta.";
}


function mostrar_comentarios($id_post,$post){

	global $link;
	$sql="SELECT * FROM ". $post.  "_comentarios WHERE fk_". $post ."='$id_post' ORDER BY fecha DESC";
	$result = $link ->query($sql);

	if($result->num_rows){

		

		while ($row=$result->fetch_assoc()) {

			$username = get_username($row["fk_usuarios"]);
			echo '<p>';
			echo  "<b>"  .$username. "</b>";
			echo "  (" . $row["fecha"]  .  "):  ";
			echo  $row["contenido"];
			echo '</p>';

		}
		
	}

	else
		echo "No hay comentarios aun.";
}


function comentar_post($id_post,$post){

	$id_usuarios = $_POST["id_usuarios"];	
	$comentario = $_POST["comentario"];

	global $link;
	$sql="INSERT INTO ".  $post."_comentarios(fk_usuarios, fk_".$post. ", contenido, fecha)
		   VALUES('$id_usuarios','$id_post', '$comentario', NOW())";

	if($link->query($sql))
		mostrar_comentarios($id_post,$post);
	
}

function hacer_propuesta(){

	$id_usuarios = $_POST["id_usuarios"];
	$id_ofertas = $_POST["id_ofertas"];
	$propuesta = $_POST["propuesta"];

	global $link;
	$sql="INSERT INTO propuestas(fk_usuarios, fk_ofertas, descripcion)
		   VALUES('$id_usuarios','$id_ofertas', '$propuesta')";

	if($link->query($sql))
	 echo "Propuesta enviada.";
	else
		echo "Error al enviar propuesta.";	
	
}



function eliminar_propuesta(){

	if(isset($_POST["elimina_propuesta"])){

		$id_propuestas=$_POST["elimina_propuesta"];

		$sql="DELETE FROM propuestas WHERE id_propuestas='$id_propuestas'";
		global $link;
		$link->query($sql);		
	}
}

function ver_propuestas(){

	if(isset($_SESSION["id_usuarios"])){

		$id_usuarios=$_SESSION["id_usuarios"];

		global $link;

		$sql="SELECT id_ofertas, tema FROM ofertas WHERE fk_usuarios='$id_usuarios'";
		$result1=$link->query($sql);

		if($result1->num_rows){

			while ($row1=$result1->fetch_assoc()) {

				$tema=$row1["tema"];
				$id_ofertas=$row1["id_ofertas"];

				$sql="SELECT id_propuestas, fk_usuarios, descripcion FROM propuestas WHERE fk_ofertas='$id_ofertas'";
				$result2=$link->query($sql);

				echo '<br><p><b>Propuestas de la oferta "' . $tema  . '":</b></p><br>';

				if($result2->num_rows){

					while ($row2=$result2->fetch_assoc()) {

						$descripcion=$row2["descripcion"];
						$id_propuestas=$row2["id_propuestas"];
						$fk_usuarios=$row2["fk_usuarios"];
						$sql="SELECT username FROM usuarios WHERE id_usuarios='$fk_usuarios'";		
						$username=$link->query($sql)->fetch_assoc()["username"];

						echo "<p>Propuesta realizada por:  <b>" . $username . "</b></p>";
						echo "<p><b>Descripción:</b> " . $descripcion . "</p>";
						?>
							<form action="" method="post">
								<input type="hidden" name="elimina_propuesta" value="<?php echo $id_propuestas;  ?>">
								<input type="submit" value="Eliminar">	
							</form>
							<br>					

						<?php
						
					}
				}
				else
					echo "<p>Esta oferta no tiene propuestas.</p>";
			}
		}
		else
			echo "Ud. no ha publicado ofertas.";

	}
	else
		echo "Inicie sesión para ver las propuestas.";

}

function ver_mispropuestas(){

	if($_SESSION["id_usuarios"]){

		$id_usuarios=$_SESSION["id_usuarios"];

		global $link;
		$sql="SELECT * from propuestas WHERE fk_usuarios='$id_usuarios'";
		$result=$link->query($sql);

		if($result->num_rows){

			while ($row=$result->fetch_assoc()) {

				$id_ofertas=$row["fk_ofertas"];
				$id_propuestas=$row["id_propuestas"];
				$descripcion=$row["descripcion"];

				//Nombre de la oferta
				$sql="SELECT tema FROM ofertas WHERE id_ofertas='$id_ofertas'";
				$tema=$link->query($sql)->fetch_assoc()["tema"];

				echo '<br><p><b>Propuesta a la oferta "' . $tema  . '":</b></p><br>';
				echo "<p><b>Descripción:</b> " . $descripcion . "</p>";
				?>
					<form action="" method="post">
						<input type="hidden" name="elimina_propuesta" value="<?php echo $id_propuestas;  ?>">
						<input type="submit" value="Eliminar">	
					</form>
					<br>					

				<?php
			}
		}
		else
			echo "Ud. no ha realizado propuestas.";

	}
}

function get_username($fk_usuarios){

	global $link;
	$sql="SELECT username FROM usuarios WHERE id_usuarios='$fk_usuarios'";		
	$username=$link->query($sql)->fetch_assoc()["username"];

	return $username;
}



function buscar_ofertas(){

	

	if(isset($_POST["ofertas_kw"])){

		$keyword=$_POST["ofertas_kw"];
		$sql="SELECT * FROM ofertas WHERE (tema LIKE '%$keyword%') OR (descripcion LIKE '%$keyword%') ORDER BY fecha DESC";
	}
	else
		$sql="SELECT * FROM ofertas ORDER BY fecha DESC";

	global $link;
	$result=$link->query($sql);


	if($result->num_rows){

		while ($row=$result->fetch_assoc()) {

			?>
				<table border="1">
					<tr>
						<th colspan="2"><?php echo $row["tema"]; ?></th>
					</tr>
					<tr>
						<td rowspan="4"><?php echo $row["descripcion"]; ?></td>
					</tr>
					<tr>
						<td>Publicado por: <?php echo get_username($row["fk_usuarios"]); ?></td>
					</tr>
					<tr>
						<td>Publicado el: <?php echo $row["fecha"]; ?></td>
					</tr>
					
					<tr>
						<td>
							<form action="veroferta.php" method="post">
								<input type="hidden" name="id_oferta" value="<?php echo $row["id_ofertas"]; ?>">
								<input type="submit" value="Ver">
							</form>
						</td>
					</tr>
				</table>
			<?php		
		}	
	}
	else
		echo "No hay ofertas publicadas.";



}

//publicaciones code

function crear_publicacion(){

	if($_SESSION["id_usuarios"]){

		$id_usuarios=$_SESSION["id_usuarios"];
		$tema=$_POST["tema"];
		$descripcion=$_POST["descripcion"];

		$sql="INSERT INTO publicaciones(fk_usuarios, tema, descripcion,fecha)  VALUES('$id_usuarios', '$tema', '$descripcion',NOW())";
		global $link;
		if($link->query($sql))
			echo "Publicación creada";
		else
			echo "Error creando publicación";

	}
}

function ver_mispublicaciones(){

	if($_SESSION["id_usuarios"]){

		$id_usuarios=$_SESSION["id_usuarios"];
		

		$sql="SELECT id_publicaciones, tema, descripcion, fecha FROM publicaciones WHERE fk_usuarios='$id_usuarios'";
		global $link;
		if($result=$link->query($sql)){

			if($result->num_rows>0){

				while($row=$result->fetch_assoc()){  ?>

					
					<table border="1"  <?php   echo 'name="' . $row['id_publicaciones'] .'"';    ?>>
						<tr><th colspan="2"><?php echo $row["tema"]; ?></th></tr>
						<tr>
							<td rowspan="3"><?php echo $row["descripcion"]; ?></td>
							<td>
								<form action="verpublicacion.php" method="post">
									<input type="hidden" name="id_publicaciones" value="<?php echo $row['id_publicaciones']; ?>">
									<input type="submit" value="Ver">
								</form>
							</td>
						</tr>
						<tr>
							<td><button id="modificar"
							 <?php echo 'onclick="modificar_publicacion(' . $row['id_publicaciones'] . ')"'  ?> >Modificar
							</button></td>
						</tr>
						<tr>
							<td>
								<form action="procesos.php" method="post">
									<input type="hidden" name="eliminar_publicacion" value="<?php echo $row['id_publicaciones']; ?>">
									<input type="hidden" name="form" value="12">
									<input type="submit" value="Eliminar">
								</form>					
							</td>
						</tr>
					</table>
		<?php

				}
			}
			else
				echo "Ud. no tiene publicaciones.";
		}
	}
}

function eliminar_publicacion(){

	$id_publicacion=$_POST["eliminar_publicacion"];

	$sql="DELETE FROM publicaciones WHERE id_publicaciones='$id_publicacion'";
	global $link;
	$link->query($sql);


}

function update_publicaciones(){

	$id_publicaciones=$_POST["id_publicaciones"];	
	$tema=$_POST["tema"];
	$descripcion=$_POST["descripcion"];

	$sql="UPDATE publicaciones SET tema='$tema', descripcion='$descripcion' WHERE id_publicaciones='$id_publicaciones'";
	global $link;

	if($link->query($sql))
		echo "Publicación actualizada";
	else
		"No se pudo actualizar la Publicación";

}

function add_publicacion_file_db($path,$extension,$type){

	$descripcion=$_POST[$type . "_descripcion"];
	$id_publicaciones=$_POST["id_publicaciones"];
	$source=$path . "temporal_". $type ."_file" . "." . $extension;

	if(isset($_SESSION['id_usuarios'])){

		if(file_exists($source)){

			global $link;
			//Crear registro de archivo
			$sql="INSERT INTO media_publicaciones(descripcion,type,fk_publicaciones) VALUES('$descripcion','$type','$id_publicaciones')";
			$link->query($sql);

			//Obtener el id del archivo
			$sql="SELECT MAX(id_media_publicaciones) FROM media_publicaciones";
			$last_id=$link->query($sql)->fetch_assoc();
			$last_id=$last_id["MAX(id_media_publicaciones)"];
			//		

			$target=$path . $type . "_publicacion_" . $last_id . "." . $extension;
			global $link;
			$sql="UPDATE media_publicaciones SET link='$target' WHERE id_media_publicaciones='$last_id'";
			if($link->query($sql)){

				rename($source,$target);

				echo "Archivo cargado exitosamente";

				//Done
			}
			else 
				echo $link->error;	
		}
		else
			echo "file does not exist";
	}
}

function upload_pdf($path,$max_size){

	if(isset($_POST["submit_pdf"])){

		$extension=strtolower(pathinfo($_FILES["pdf_file"]["name"],PATHINFO_EXTENSION));
		$target=$path . "temporal_pdf_file" . "." . $extension;		
		
		if($extension=="pdf"){			

			if($_FILES["pdf_file"]["size"]<$max_size){

				if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target)){

					echo "Archivo cargado exitosamente.";
					return $extension;
				}
				else
					echo "No fue posible subir su archivo.";

			}
			else
				echo "Tamaño máximo de archivo superado, debe ser menor a " . $max_size/1000 . "KB";			

		}

		else
			echo "El archivo seleccionado no es un archivo PDF.";

	}
	else 
		echo "No se recibió ningún archivo PDF.";

}

function eliminar_pub_files($type){

	if(isset($_POST["id_publicaciones"])){
	
		$id_publicaciones=$_POST["id_publicaciones"];
	
		global $link;
		$sql = "SELECT link FROM media_publicaciones WHERE fk_publicaciones='$id_publicaciones' AND type='$type'";
	
		//borrar archivos.
		if($result=$link->query($sql))
			if($check=$result->num_rows)
				while($row=$result->fetch_assoc())
					unlink($row["link"]);
			
		
		//Borrar registros.
		$sql = "DELETE FROM media_publicaciones WHERE fk_publicaciones='$id_publicaciones' AND type='$type'";
	
		if($check)
			$link->query($sql);

	}

}

function ver_publicacion(){


	if(isset($_POST["id_publicaciones"])){

		$id_publicaciones=$_POST["id_publicaciones"];
		$sql="SELECT * FROM publicaciones WHERE id_publicaciones='$id_publicaciones'";
		global $link;
		$row=$link->query($sql)->fetch_assoc();

		//Obtener tema y descripcion
		$tema=$row["tema"];
		$descripcion=$row["descripcion"];
		$fecha=$row["fecha"];

		//Obtener username.
		$fk_usuarios=$row["fk_usuarios"];
		$username=get_username($fk_usuarios);

		//Obtener links de las imagenes y pdfs.
		$sql="SELECT link, descripcion FROM media_publicaciones WHERE fk_publicaciones='$id_publicaciones' AND type='image'";		
		$result=$link->query($sql);

		if($result->num_rows){

			$link_img="";
			$descripcion_img="";
			while ($row=$result->fetch_assoc()) {

				$link_img=$link_img .'<img style="display: none" class="image_publicacion" src="'. $row["link"] .'" alt="No se pudo cargar la imagen">';
				$descripcion_img=$descripcion_img .'<div class="image_descripcion" style="display: none">'. $row["descripcion"] .'</div>';		
			}
		}
		else{
			$link_img="Esta publicación no tiene imágenes";
			$descripcion_img="";
		}

		$sql="SELECT link, descripcion FROM media_publicaciones WHERE fk_publicaciones='$id_publicaciones' AND type='pdf'";	
		$result=$link->query($sql);	

		if($result->num_rows){

			$link_pdf="<p><b>Archivos anexos a esta publicación: </b></p><ul>";			
			while ($row=$result->fetch_assoc()) 
				$link_pdf= $link_pdf . '<li><a target="_blank" class="pdf_link" href="'.	$row["link"] .'">'.$row["descripcion"]  .'</a></li>';
			$link_pdf= $link_pdf . '</ul>';	
		}
		else
			$link_pdf="Esta publicación no tiene PDFs";	


		//Check fav
		if($sel=is_fav($id_publicaciones,"publicaciones"))
			$fav="Hacer favorito";
		else
			$fav="Quitar favorito";		

		?>
		<table id="tabla_oferta" border="1">
			<tr>
				<th><?php echo $tema;   ?></th>
				<th>Por: <?php echo $username;   ?></th>
				<td>Publicado el: <?php echo $fecha; ?></td>				
				<td>
					<?php if(isset($_SESSION["id_usuarios"])){ ?>
						<button id="fav" onclick="<?php echo "fav(25,$id_publicaciones,$sel)" ?>"> <?php echo $fav; ?></button></td>
					<?php } ?>
			</tr>

			
			<tr>
				<td colspan="3"><?php echo $link_img; ?>	</td>
				<td rowspan="3"><?php echo $link_pdf; ?></td>		
			</tr>
			<tr>
				<td colspan="3"><?php echo $descripcion_img; ?>	</td>
			</tr>
			<tr>
				<td><button id="anterior">Anterior</button></td>
				<td colspan="2"><button id="siguiente">Siguiente</button></td>
			</tr>
			<tr>
				<td colspan="4"><b>Categorías: </b> <?php identificar_categorias("publicaciones",$id_publicaciones); ?></td>
			</tr>
			<tr>
				<td colspan="4"><?php echo "<p><b>Descrición de la publicación: </b></p>" .$descripcion;   ?></td>
			</tr>
		</table>

		<?php
	}

	else
		echo "Error: no se encontró ninguna publicación.";
}

function form_post($id_post,$post,$form){

?>
<div id="comentar_post">
	<table>
		<tr>
			<th>Mi comentario: </th>
			<td><textarea placeholder="Escribe acá tu comentario." id="comentario_contenido"></textarea></td>
			<td><button id="submit_comentario" onclick="<?php echo "enviar_comentario($_SESSION[id_usuarios],$id_post,'$post',$form)"; 	?>">
			Comentar</button></td>
		</tr>		
	</table>
</div>
<?php

 } 

 function buscar_publicaciones(){

	

	if(isset($_POST["publicaciones_kw"])){

		$keyword=$_POST["publicaciones_kw"];
		$sql="SELECT * FROM publicaciones WHERE (tema LIKE '%$keyword%') OR (descripcion LIKE '%$keyword%') ORDER BY fecha DESC";
	}
	else
		$sql="SELECT * FROM publicaciones ORDER BY fecha DESC";

	global $link;
	$result=$link->query($sql);


	if($result->num_rows){

		while ($row=$result->fetch_assoc()) {

			?>
				<table border="1">
					<tr>
						<th colspan="2"><?php echo $row["tema"]; ?></th>
					</tr>
					<tr>
						<td rowspan="4"><?php echo $row["descripcion"]; ?></td>
					</tr>
					<tr>
						<td>Publicado por: <?php echo get_username($row["fk_usuarios"]); ?></td>
					</tr>
					<tr>
						<td>Publicado el: <?php echo $row["fecha"]; ?></td>
					</tr>
					
					<tr>
						<td>
							<form action="verpublicacion.php" method="post">
								<input type="hidden" name="id_publicaciones" value="<?php echo $row["id_publicaciones"]; ?>">
								<input type="submit" value="Ver">
							</form>
						</td>
					</tr>
				</table>
			<?php		
		}	
	}
	else
		echo "No hay ofertas publicadas.";

}

function buscar_user(){

	if(isset($_POST["user_keyword"])){

		$keyword=$_POST["user_keyword"];

		global $link;	
		$sql="SELECT id_usuarios, nombre, apellido, username, link_image FROM usuarios WHERE (nombre LIKE '%$keyword%') 
			  OR (apellido LIKE '%$keyword%') OR (username LIKE '%$keyword%')";

		//process
		$result=$link->query($sql);

		if($result->num_rows){


			while($row=$result->fetch_assoc()){
			
				?>	
					<table  onclick="<?php echo "chat_request(". $row["id_usuarios"] .")"; ?>"> 
						<tr>
							<td rowspan="3" style="width: 50%;">
								<img src="<?php echo $row["link_image"] ?>" alt="Sin foto :(" >
							</td>
						</tr>
						<tr>
							<td><?php echo $row["nombre"] ." " . $row["apellido"]; ?></td>				
						</tr>
						<tr>
							<td>Username: <?php echo $row["username"]; ?></td>
						</tr>
					</table>
	
				<?php
			}
		}

		else
			echo "No se encontraron usuarios.";	
	
	}
}

function sel_chat($mostrar){


	if(isset($_SESSION["id_usuarios"])){

		if(isset($_POST["id_usuario"])){

			$user1=$_SESSION["id_usuarios"];
			$user2=$_POST["id_usuario"];			

			global $link;
			$sql="SELECT id_chats FROM chats WHERE 
				  (fk_usuarios1='$user1' AND fk_usuarios2='$user2') OR (fk_usuarios1='$user2' AND fk_usuarios2='$user1')";

			$result=$link->query($sql);

			if($result->num_rows){
				
				if($mostrar)	mostrar_chat($user1,$user2);
				return $result->fetch_assoc()["id_chats"];

			}
			else{

				$sql="INSERT INTO chats(fk_usuarios1,fk_usuarios2) VALUES($user1,$user2)";
				$link->query($sql);
			}


		}		
	}
}

function mostrar_chat($user1,$user2){ //usuario 1 es de session

	global $link;

	$sql="SELECT msj.mostrar, msj.fk_usuarios, msj.fecha, msj.contenido FROM chats, chats_mensajes AS msj WHERE msj.fk_chats=chats.id_chats
		  AND ((chats.fk_usuarios1='$user1' AND chats.fk_usuarios2='$user2') OR (chats.fk_usuarios1='$user2' AND chats.fk_usuarios2='$user1'))";	  
	
	$result=$link->query($sql);

	if($result->num_rows){

		while ($row=$result->fetch_assoc()) {

			$condicion1=($row["fk_usuarios"]==$user1 && $row["mostrar"]==1); //Solo el autor puede ver
			$condicion2=($row["fk_usuarios"]==$user2 && $row["mostrar"]==2); //Solo el receptor puede ver
			$condicion3=($row["fk_usuarios"]==$user1 || $row["fk_usuarios"]==$user2) && ($row["mostrar"]==3); //Cualquiera de los dos

			$check=  $condicion1 || $condicion2 || $condicion3;							

			if($check){

				$username=get_username($row["fk_usuarios"]);
				$mensaje=$row["contenido"];
				$fecha=$row["fecha"];

				echo "<p><b>" . $username .":</b></p>";		
				echo "<p> " . $row["contenido"] . "</p>";
				echo "<p>" . $row["fecha"] . "</p>";
			}

		}
	}
	else
		echo "No hay mensajes en este chat";

}

function enviar_chat(){


	if(isset($_SESSION["id_usuarios"])){

		if(isset($_POST["id_usuario"])){

			$mensaje=$_POST["mensaje"];
			$user1=$_SESSION["id_usuarios"];
			$user2=$_POST["id_usuario"];
			$id_chats=sel_chat(false);

			global $link;
			$sql="INSERT INTO chats_mensajes(mostrar,fk_chats,fk_usuarios,fecha,contenido)
				   VALUES(3,$id_chats,$user1,NOW(),'$mensaje')";
			
			if($link->query($sql))
				mostrar_chat($user1,$user2);
			else
				echo "Error, chat no existe.";

		}		

	}		
			
}

function eliminar_chat(){


	if(isset($_SESSION["id_usuarios"])){

		if(isset($_POST["id_usuario"])){

			$user1=$_SESSION["id_usuarios"];
			$user2=$_POST["id_usuario"];
			$id_chats=sel_chat(false);

			global $link;
			$sql="UPDATE chats_mensajes SET mostrar=2 WHERE fk_chats='$id_chats' AND mostrar=3 AND fk_usuarios='$user1'";
			$link->query($sql);
			$sql="UPDATE chats_mensajes SET mostrar=4 WHERE fk_chats='$id_chats' AND mostrar=1 AND fk_usuarios='$user1'";
			$link->query($sql);
			$sql="UPDATE chats_mensajes SET mostrar=1 WHERE fk_chats='$id_chats' AND mostrar=3 AND fk_usuarios='$user2'";
			$link->query($sql);
			$sql="UPDATE chats_mensajes SET mostrar=4 WHERE fk_chats='$id_chats' AND mostrar=2 AND fk_usuarios='$user2'";
			$link->query($sql);

			//Delete useless menssages
			$sql="DELETE FROM chats_mensajes WHERE mostrar=4";
			$link->query($sql);
			
		}		

	}		
			
}

function agregar_categoria(){

	if(isset($_POST["nueva_categoria"])){

		global $link;
		$sql="INSERT INTO categorias(campo) VALUES('$_POST[nueva_categoria]')";
		if($link->query($sql))
			ver_categorias();
	}

}

function ver_categorias(){

	global $link;
	$sql="SELECT * FROM categorias";
	$result=$link->query($sql);

	if($result->num_rows){

		echo '<table style="width: 50%; border: 2px solid black;">';
		echo "<tr><td align='center'><b>Categorias</b></td></tr>";

		while($row=$result->fetch_assoc()){

			echo "<tr>";
			echo "<td> " . $row["campo"]. "</td><td>Eliminar  ". 
				'<input type="checkbox" class="check_eliminar" name="'. $row["id_categorias"] . '"' . '></td>';
			echo "</tr>";

		}

		echo "</table>";
	}

}

function eliminar_categoria(){


	if(isset($_POST["id_categoria"])){

		$id_categoria=$_POST["id_categoria"];
		global $link;
		$sql="DELETE FROM categorias WHERE id_categorias=$id_categoria";

		if($link->query($sql))
			ver_categorias();

	}
}

function mostrar_admin_foros(){

	if(isset($_POST["foro_keyword"])){


		$keyword=$_POST["foro_keyword"];
		global $link;
		$sql="SELECT * FROM foros WHERE (tema LIKE '%$keyword%') OR (descripcion LIKE '%$keyword%')";
		$result=$link->query($sql);

		if($result->num_rows){
		
			echo '<table border="1">';
			echo "<tr><th colspan='2'>Resultados:  </th></tr>";
	
	
			while ($row=$result->fetch_assoc()) {

				echo "<tr><td>Foro: <b>". $row["tema"] ."</b> Descripción: " . $row["descripcion"] . "</td><td>"; 
				?>
					<form action="" method="post"> 
						<input type="hidden" name="id_foro_eliminar" value="<?php echo $row["id_foros"]; ?>">
						<input type="submit" value="Eliminar">	
					</form>
				<?php
				echo "</td></tr>";
			}

			echo "</table>";	

		}
		else
			echo "No se encontraron foros.";		

	} 	

}

function eliminar_admin_foros(){

	if(isset($_POST["id_foro_eliminar"])){

		$id_foros=$_POST["id_foro_eliminar"];

		global $link;
		$sql="DELETE FROM foros WHERE id_foros='$id_foros'";
		$link->query($sql);

	}
}

function fav($id_type,$type,$sel){

	if(isset($_SESSION["id_usuarios"])){

		$id_usuarios=$_SESSION["id_usuarios"];
		global $link;

		if($sel)				
			$sql="INSERT INTO " . $type ."_fav(fk_usuarios,fk_" . $type . ") VALUES('$id_usuarios','$id_type')";		
		else
			$sql="DELETE FROM ". $type . "_fav WHERE fk_usuarios='$id_usuarios' AND fk_" . $type . "='$id_type'";

		$link->query($sql);	
		

	
	}

}

function is_fav($id_type,$type){

	if(isset($_SESSION["id_usuarios"])){	
	
		$id_usuarios=$_SESSION["id_usuarios"];
	
		global $link;
		$sql="SELECT * FROM ". $type . "_fav WHERE fk_usuarios='$id_usuarios' AND fk_" . $type . "='$id_type'";
		$result=$link->query($sql)->num_rows;
	
		if($result)
			return 0;
		else
			return 1;
	}
}

function modificar_perfil(){


	if(isset($_POST["modificar_submit"]) and isset($_SESSION["id_usuarios"])){

		$id_usuarios=$_SESSION["id_usuarios"];
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$correo=$_POST['email'];
		$username=$_POST['username'];
		$univ=$_POST['universidad'];
		$profesion=$_POST['profesion'];
		$nivel_academico=$_POST["nivel_academico"];
		$descripcion=$_POST["descripcion"];
		$clave=$_POST['clave'];
		$clave_md5=md5($clave);

		global $link;
		$sql="UPDATE usuarios SET nombre='$nombre', apellido='$apellido', clave='$clave_md5', email='$correo', username='$username', 
			  universidad='$univ', profesion='$profesion', nivel_academico='$nivel_academico', descripcion='$descripcion'
			  WHERE id_usuarios='$id_usuarios'";
		

		$link->query($sql);

		//Refresh session variables.		
		login($username,$clave);

	}

}

function ver_perfiles(){


	if(isset($_POST["perfiles_kw"])){

		$keyword=$_POST["perfiles_kw"];

		$sql="SELECT * FROM usuarios WHERE (nombre LIKE '%$keyword%') OR (apellido LIKE '%$keyword%') OR (username LIKE '%$keyword%')
			  OR (descripcion LIKE '%$keyword%')";
	}
	else
		$sql="SELECT * FROM usuarios;";

				 

		global $link;
		$result=$link->query($sql);	
		echo $link->error;


		if($result->num_rows){

			while ($row=$result->fetch_assoc()) {

				if($row["username"]!=""){

					if($sel=is_fav($row["id_usuarios"],"usuarios_fav"))
						$fav="Hacer favorito";
					else
						$fav="Quitar favorito";

				?>
					<table border="1" id="tabla_perfiles" style="width: 100%;">
						<tr>
							<td rowspan="3"><img src="<?php echo $row["link_image"]; ?>" alt="Sin foto :("></td>
							<td colspan="2"><b>Nombre: <?php echo $row["nombre"] . " ". $row["apellido"]; ?></b></td>
							<td>

								<?php if(isset($_SESSION["id_usuarios"])){ ?>
									<button id="<?php echo $row["id_usuarios"]; ?>" onclick="<?php echo "fav_perfil(27,$row[id_usuarios],$sel)" ?>"> <?php echo $fav; ?>								
									</button>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td><b>Username:</b> <?php echo $row["username"]; ?></td>
							<td colspan="2"><b>Email: <?php echo $row["email"]; ?> </b></td>
						</tr>
						<tr>
							<td><b>Profesión:</b> <?php echo $row["profesion"]; ?> </td>
							<td><b>Nivel académico:</b>  <?php echo $row["nivel_academico"]; ?> </td>
							<td><b>Universidad:</b> <?php echo $row["universidad"]; ?> </td>
						</tr>
						<tr>
							<td colspan="4"><b>Descripción: </b>  <?php echo $row["descripcion"]; ?> </td>
						</tr>
					</table>
				<?php
				}
				else
					echo "No se encontraron perfiles.";	
			}	
		}
		else
			echo "No se encontraron perfiles.";

}

function ver_perfiles_fav(){


	if(isset($_SESSION["id_usuarios"])){

		$id_usuarios=$_SESSION["id_usuarios"];
		global $link;

		$sql="SELECT  user.id_usuarios, user.nombre, user.apellido, user.email, user.username, user.link_image, user.universidad, 
			  user.profesion, user.nivel_academico, user.descripcion FROM usuarios AS user, usuarios_fav_fav AS fav 
			  WHERE fav.fk_usuarios=$id_usuarios AND  user.id_usuarios=fav.fk_usuarios_fav";

		$result=$link->query($sql);
		
		if($result->num_rows){

			while ($row=$result->fetch_assoc()) {

				?>
					<table border="1" id="tabla_perfiles" >
						<tr>
							<td rowspan="3"><img src="<?php echo $row["link_image"]; ?>" alt="Sin foto :("></td>
							<td colspan="3"><b>Nombre: <?php echo $row["nombre"] . " ". $row["apellido"]; ?></b></td>							
						</tr>
						<tr>
							<td><b>Username:</b> <?php echo $row["username"]; ?></td>
							<td colspan="2"><b>Email: <?php echo $row["email"]; ?> </b></td>
						</tr>
						<tr>
							<td><b>Profesión:</b> <?php echo $row["profesion"]; ?> </td>
							<td><b>Nivel académico:</b>  <?php echo $row["nivel_academico"]; ?> </td>
							<td><b>Universidad:</b> <?php echo $row["universidad"]; ?> </td>
						</tr>
						<tr>
							<td colspan="4"><b>Descripción: </b>  <?php echo $row["descripcion"]; ?> </td>
						</tr>
					</table>

				<?php
			}
		}
		else
			echo "Ud. no tiene perfiles favoritos.";
	}
	else
		echo "Inicie sesión para ver sus perfiles favoritos";

}

function ver_ofertas_fav(){


	if(isset($_SESSION["id_usuarios"])){

		$id_usuarios=$_SESSION["id_usuarios"];
		global $link;

			$sql="SELECT o.id_ofertas, o.tema, o.descripcion, o.fecha, u.username FROM ofertas AS o, ofertas_fav AS fav, usuarios AS u 
				  WHERE fav.fk_usuarios=$id_usuarios AND  o.id_ofertas=fav.fk_ofertas AND o.fk_usuarios=u.id_usuarios";

		$result=$link->query($sql);
		
		if($result->num_rows){

			while ($row=$result->fetch_assoc()) {

				?>
					<table  style="width: 100%;">
						<tr>
							<th colspan="3"><?php echo $row["tema"]; ?></th>
						</tr>

						<tr>
							<td>Publicado el: <?php echo $row["fecha"]; ?></td>
							<td>Por: <?php echo $row["username"]; ?></td>
							<td>
								<form action="veroferta.php" method="post">
									<input type="hidden" name="id_oferta" value="<?php echo $row['id_ofertas']; ?>">
									<input type="submit" value="Ver">
								</form>
							</td>
						</tr>						
						<tr>
							<td colspan="3">
								<b>Descripción: </b><?php echo $row["descripcion"]; ?>
							</td>
						</tr>						
						
					</table>

				<?php
			}
		}
		else
			echo "Ud. no tiene ofertas favoritas.";
	}
	else
		echo "Inicie sesión para ver sus ofertas favoritas";
	
}

function ver_publicaciones_fav(){


	if(isset($_SESSION["id_usuarios"])){

		$id_usuarios=$_SESSION["id_usuarios"];
		global $link;

			$sql="SELECT p.id_publicaciones, p.tema, p.descripcion, p.fecha, u.username FROM publicaciones AS p, publicaciones_fav 
				  AS fav, usuarios AS u  WHERE fav.fk_usuarios=$id_usuarios AND  p.id_publicaciones=fav.fk_publicaciones AND
				  p.fk_usuarios=u.id_usuarios";

		$result=$link->query($sql);
		
		if($result->num_rows){

			while ($row=$result->fetch_assoc()) {

				?>
					<table  style="width: 100%;">
						<tr>
							<th colspan="3"><?php echo $row["tema"]; ?></th>
						</tr>

						<tr>
							<td>Publicado el: <?php echo $row["fecha"]; ?></td>
							<td>Por: <?php echo $row["username"]; ?></td>
							<td>
								<form action="verpublicacion.php" method="post">
									<input type="hidden" name="id_publicaciones" value="<?php echo $row['id_publicaciones']; ?>">
									<input type="submit" value="Ver">
								</form>
							</td>
						</tr>						
						<tr>
							<td colspan="3">
								<b>Descripción: </b><?php echo $row["descripcion"]; ?>
							</td>
						</tr>						
						
					</table>

				<?php
			}
		}
		else
			echo "Ud. no tiene publicaciones favoritas.";
	}
	else
		echo "Inicie sesión para ver sus publicaciones favoritas";
	
}

function  mostrar_categorias(){

	global $link;
	$sql="SELECT * FROM categorias";
	$result=$link->query($sql);

	echo '<select name="id_categorias">';

	if($result->num_rows)
		while($row=$result->fetch_assoc())						
			echo '<option value="'. $row["id_categorias"]    .'">'. $row["campo"]  .'</option>';
		
	echo '</select>';
}

function agregar_categoria_type($type){

	if(isset($_POST["submit_categoria"]) and isset($_SESSION["id_usuarios"])){

		$id_type=$_POST["id_type"];
		$id_categorias=$_POST["id_categorias"];
		global $link;

		$sql="INSERT INTO " . $type ."_categorias(fk_categorias, fk_". $type.") VALUES($id_categorias,$id_type)";
		$link->query($sql);

	}

}

function eliminar_categorias_type($type){

	if(isset($_POST["delete_categorias"])){


		$id_type=$_POST["id_type"];
		global $link;

		$sql="DELETE FROM " . $type ."_categorias WHERE fk_" . $type . "=$id_type";
		$link->query($sql);
	}

}

function identificar_categorias($type,$id_type){

	global $link;

	$sql="SELECT type.campo FROM ". $type ."_categorias AS cat, " . "categorias AS type WHERE cat.fk_" . $type ."=$id_type AND 
		  cat.fk_categorias=type.id_categorias";		 

	$result=$link->query($sql);

	$categorias="";

	if($result->num_rows)
		while ($row=$result->fetch_assoc()) 
			$categorias= $categorias ."#" . $row["campo"] . "  " ;

	echo $categorias;

}

function admin_comentarios($type){

	global $link;
	$sql="SELECT c.id_". $type ."_comentarios, u.username, type.tema, c.contenido, c.fecha FROM ". $type.  "_comentarios AS c, ". $type .
		  " AS type, usuarios AS u WHERE c.fk_". $type ."=type.id_". $type. " AND c.fk_usuarios=u.id_usuarios ORDER BY c.fecha DESC";
	
	$result = $link ->query($sql);

	if($result->num_rows){		

		while ($row=$result->fetch_assoc()) {


			?>
				<table style="width: 100%;">
					<tr>
						<td colspan="2"><b>Post: </b><?php echo $row["tema"]; ?></td>									
					</tr>
					<tr>
						<td><b>Publicado el: </b> <?php echo $row["fecha"];  ?></td>
						<td><b>Por: </b> <?php echo $row["username"];  ?></td>
					</tr>
					<tr>
						<td colspan="2"><b>Contenido: </b> <?php echo $row["contenido"];   ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<form action="" method="post">
								<input type="hidden" name="<?php echo "eliminar_comentario_". $type; ?>" 
									value="<?php echo $row["id_" . $type. "_comentarios"]; ?>">
								<input type="submit" value="Eliminar">
							</form>
						</td>
					</tr>			
				</table>

			<?php		

		}
		
	}

}

function eliminar_admin_comentarios($type){

	global $link;

	if(isset($_POST["eliminar_comentario_" . $type])){

		$id_comentario=$_POST["eliminar_comentario_" . $type];

		$sql="DELETE FROM ". $type . "_comentarios WHERE id_" . $type . "_comentarios=$id_comentario";

		$link->query($sql);		
	}
}

function receivers_mail(){

	global $link;
	$sql="SELECT email FROM usuarios WHERE tipo='A'";
	$result=$link->query($sql);

	if($result->num_rows)
		while ($row=$result->fetch_assoc()) 
			$correos[]=$row["email"];

	return implode(", ", $correos);
}





















