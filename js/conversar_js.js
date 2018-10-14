/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: JS file for chat.php file 
*
* */



doc=document;
var selected_user=1;
var intervalo=30000;
$(document).ready(function(){

	//Buscar users
	$("#chat_list").find("[type='submit']").click(buscar_users);
	$("#enviar").click(enviar_msj_chat);
	$("#eliminar_chat").click(eliminar_chat);
	setInterval(function(){ chat_request(selected_user); }, intervalo);



});


function buscar_users(){

	//get keyword
	var keyword = $("[name='user_keyword']").val();
	
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=18&user_keyword="+ keyword);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result = this.responseText;					
			$("#users_list").html(result);
		}
		
	};

}

function chat_request(id_usuario){

	selected_user=id_usuario;  //Recordar chat seleccionado.
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=19&id_usuario=" + id_usuario);


	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result=this.responseText;
			$("#mensajes_recibidos").html(result);
			var position=$("#mensajes_recibidos")[0].scrollHeight;
			$("#mensajes_recibidos").scrollTop(position);
		}
			
	};
};

function enviar_msj_chat(){

	//get mensaje
	var code_msj = $("#mensaje").val();
	
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=20&id_usuario="+ selected_user +"&mensaje=" + code_msj);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result=this.responseText;
			$("#mensajes_recibidos").html(result);
			$("#mensaje").val("");
			var position=$("#mensajes_recibidos")[0].scrollHeight;
			$("#mensajes_recibidos").scrollTop(position);
		}		

	};
};


function eliminar_chat(){

	var continuar=confirm("¿Seguro desea eliminar el chat actual?");

	if(continuar){

		var con = new XMLHttpRequest();
		con.open("POST", "procesos.php", true);
		con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		con.send("form=21&id_usuario="+ selected_user);
	
		con.onreadystatechange=function(){
	
			if (this.readyState == 4 && this.status == 200){
	
				var result=this.responseText;
				$("#mensajes_recibidos").html(result);

			}		
	
		};
	}
};



