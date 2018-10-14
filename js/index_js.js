/*
*  Author: Jesus Colmenares
*  Date: September 2018
*  Project: final uneweb project
*  Description: JS file for misforos.php file 
*
* */

doc=document;

$(document).ready(function(){

	$("#login_boton").click(function(){

		$("#index_signup").hide("slow");
		$("#index_login").show("slow");
	})


	$("#signup_boton").click(function(){

		$("#index_login").hide("slow");
		$("#index_signup").show("slow");
	})

	


});