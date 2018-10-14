/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: JS file for categorias.php file 
*
* */



doc=document;

$(document).ready(function(){

	$("#agregar_categoria").click(agregar_categoria);
	$("#eliminar_categoria").click(eliminar_categorias);	
	





});

function agregar_categoria(){

	var categoria = $("#nueva_categoria").val();
	
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=23&nueva_categoria="+ categoria);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result = this.responseText;					
			$("#mostrar_categorias").html(result);
		}
		
	};

}


function eliminar_categorias(){

	var check=$(":checkbox");
	var n=check.length;

	for (var i = 0; i<n;i++) {

		if(check.eq(i).prop("checked")){

			var id=check.eq(i).attr("name");
			eliminar_1categoria(id);			
		}
		
	}	

}

function eliminar_1categoria(id_categoria){


	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=22&id_categoria="+ id_categoria);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result = this.responseText;					
			$("#mostrar_categorias").html(result);
		}
		
	};

}