<?php 
session_start();
if (isset($_SESSION['usuario'])) {
	# code...
	header('Location: contenido.php');
}else{
	header('Location: registrate.php');
}

 ?>