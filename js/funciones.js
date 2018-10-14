/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: general purpuse functions 
*
* */



function foro_request(id_foros){

	selected_foro=id_foros;  //Recordar foro seleccionado.
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=4&id_foros=" + id_foros);


	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result=this.responseText;
			$("#foro_mensajes").html(result);
		}
			
	};
};


function enviar_mensaje(){

	//get mensaje
	var code_msj = $("#mensaje").val();
	
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=5&id_foro="+ selected_foro +"&mensaje=" + code_msj);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result=this.responseText;
			$("#foro_mensajes").html(result);
			var position=$("#foro_mensajes")[0].scrollHeight;
			$("#foro_mensajes").scrollTop(position);
			$("#mensaje").val("");
		}		

	};
};


//objecto que permite cambiar imagenes.
var cambiar_imagen = {

	contador: 0,		
	cantidad: 2,

	cambiar: function(sentido){

		var length=arguments.length;

		for (var i =1 ; i < length; i++) 
		 	arguments[i].eq(this.contador).hide("slow");

		if(sentido){

			if(this.contador < this.cantidad-1)
				this.contador+=1;
			else
				this.contador=0;
		}
		else{

			if(this.contador > 0)
				this.contador-=1;
			else
				this.contador=this.cantidad-1;
		}

		for (var i =1 ; i < length; i++) 
		 	arguments[i].eq(this.contador).show("slow");
		
	}

}


function enviar_comentario(id_usuario,id_post,post,form){

	//get mensaje
	var code_msj = $("#comentario_contenido").val();
	
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form="+ form +"&id_usuarios="+ id_usuario + "&id_"+post+"=" + id_post   +"&comentario=" + code_msj);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result= this.responseText;
			code_msj = $("#comentario_contenido").val("");
			$("#"+ post +"_comentarios").html(result);
		}
	};
};


function enviar_propuesta(id_usuario,id_oferta){

	//get mensaje
	var code_msj = $("#propuesta").val();
	
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=11&id_usuarios="+ id_usuario + "&id_ofertas=" + id_oferta   +"&propuesta=" + code_msj);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result = this.responseText;					
			$("#form_propuesta").hide("fast");
			$("#resultado_oferta").text(result);
			$("#propuesta").val("");
		}
		
	};
};

function fav(form, id_type,sel){

	//get mensaje
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form="+ form + "&id_type="+ id_type +"&sel=" + sel);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var boton=$("#fav");

			if(sel){
				boton.text("Quitar favorito");
				$("#fav").attr("onclick","fav(" + form + "," + id_type + ",0)");
			}
			else{
				boton.text("Hacer favorito");
				$("#fav").attr("onclick","fav("+ form +","+ id_type + ",1)");
			}

		}
	};
};

function fav_perfil(form, id_type,sel){

	//get mensaje
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form="+ form + "&id_type="+ id_type +"&sel=" + sel);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var boton=$("#"+id_type);

			if(sel){
				boton.text("Quitar favorito");
				$("#"+id_type).attr("onclick","fav_perfil(" + form + "," + id_type + ",0)");
			}
			else{
				boton.text("Hacer favorito");
				$("#"+id_type).attr("onclick","fav_perfil("+ form +","+ id_type + ",1)");
			}

		}
	};
};




