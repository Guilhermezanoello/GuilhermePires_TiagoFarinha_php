<?php
	DEFINE("USER_BD","root");
	DEFINE("PASS_BD","");
	DEFINE("NOME_BD","formaest");
	$hostname_conn = "localhost";
	
	// Conectamos ao nosso servidor MySQL
	if(!($conn = mysqli_connect($hostname_conn, USER_BD, PASS_BD))) 
	{
	   echo "Erro ao conectar ao MySQL.";
	   exit;
	}
	// Selecionamos nossa base de dados MySQL
	if(!($con = mysqli_select_db($conn, NOME_BD))) 
	{
	   echo "Erro ao selecionar ao MySQL.";
	   exit;
	}

?>