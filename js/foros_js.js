/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: JS file for misforos.php file 
*
* */

doc=document;
var selected_foro=1; //Foro Id
$(document).ready(function(){

	$("#input_buscar_foros").change(buscar);
	$("#enviar").click(enviar_mensaje);



});


function buscar(){

	var keyword = document.getElementById("input_buscar_foros").value;	
	
	var con = new XMLHttpRequest();
	con.open("POST", "procesos.php", true);
	con.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	con.send("form=6&keyword=" + keyword);

	con.onreadystatechange=function(){

		if (this.readyState == 4 && this.status == 200){

			var result=this.responseText;
			$("#resultados").html(result);

		}
			
	};
}



