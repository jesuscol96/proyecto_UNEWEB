<?php
session_start();

require_once 'dblink.php';
require_once 'funciones.php';

if(isset($_POST['form'])){

	$form=$_POST['form'];


	switch ($form) {
		case 1:
				signup('U');
				echo '<meta http-equiv="refresh"  content="2; index.php">';
				break;
		case 2:
				login(0,0);
				echo '<meta http-equiv="refresh"  content="2; index.php">';
				break;
		case 3:
				signup('A');
				session_unset();
				session_destroy();
				echo '<meta http-equiv="refresh"  content="2; index.php">';
				break;
		case 4:
				mostrar_foro(0);
				break;
		case 5:
				mensaje_foro();
				break;
		case 6:
				 buscar_foros();
				break;
		case 7:
				 eliminar_oferta();
				 echo '<meta http-equiv="refresh"  content="0; misofertas.php">';
				break;
		case 8:
				$extension=upload_image("images/",2000000);
				add_oferta_image_db("images/",$extension);
				echo '<meta http-equiv="refresh"  content="0; misofertas.php">';
				break;
		case 9:
				eliminar_imagenes();
				echo '<meta http-equiv="refresh"  content="0; misofertas.php">';
				break;
		case 10:
				comentar_post($_POST["id_ofertas"],"ofertas");
				break;
		case 11:
				hacer_propuesta();
				break;
		case 12:
				eliminar_publicacion();
				echo '<meta http-equiv="refresh"  content="0; mispublicaciones.php">';
				break;
		case 13:
				$extension=upload_image("images/",2000000);
				add_publicacion_file_db("images/",$extension,"image");
				echo '<meta http-equiv="refresh"  content="0; mispublicaciones.php">';				
				break;
		case 14:
				$extension=upload_pdf("pdf/",200000);
				add_publicacion_file_db("pdf/",$extension,"pdf");
				echo '<meta http-equiv="refresh"  content="0; mispublicaciones.php">';
				break;
		case 15:
				eliminar_pub_files("image");
				echo '<meta http-equiv="refresh"  content="0; mispublicaciones.php">';
				break;
		case 16:
				eliminar_pub_files("pdf");
				echo '<meta http-equiv="refresh"  content="0; mispublicaciones.php">';
				break;	
		case 17:
				comentar_post($_POST["id_publicaciones"],"publicaciones");
				break;
		case 18:
				buscar_user();
				break;
		case 19:
				sel_chat(true);
				break;
		case 20:
				enviar_chat();
				break;
		case 21:
				eliminar_chat();
				break;
		case 22:
				eliminar_categoria();
				break;
		case 23:
				agregar_categoria();
				break;
		case 24:
				fav($_POST["id_type"],"ofertas",$_POST["sel"]);
				break;	
		case 25:
				fav($_POST["id_type"],"publicaciones",$_POST["sel"]);
				break;	
		case 26:
				modificar_perfil();
				echo '<meta http-equiv="refresh"  content="0; profile.php">';
				break;
		case 27:
				fav($_POST["id_type"],"usuarios_fav",$_POST["sel"]);
				break;				
		default:
			# code...
			break;
	}

}

else 	
	echo '<meta http-equiv="refresh"  content="0; index.php">';


?>
	

