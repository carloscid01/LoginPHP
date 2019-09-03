<?php 
session_start();
if (isset($_SESSION['usuario'])) {
	# code...
	header('Location:index.php');

}
$errores="";
if ($_SERVER['REQUEST_METHOD']=='POST') {
	# code...
	$usuario=filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING);
	$password=$_POST['password'];
	$password=hash('sha512', $password);
	try {
			$conexion=new PDO('mysql:host=localhost;dbname=curso','root','Carloscid_azul!');
		} catch (PDOException $e) {
			echo "Error".$e->getMessage();
			
		}

		$statement=$conexion->prepare('SELECT * FROM usuarios where usuario=:usuario AND pass =:password');

	$statement->execute(array(':usuario'=>$usuario,':password'=>$password));
	$resultado=$statement->fetch();
	if ($resultado !==false) {
		# code...
		$_SESSION['usuario']=$usuario;
		header('Location: index.php');
	}else{
		$errores.='<li>Datos Incorrectos</li>';
	}
}
require 'views/login.view.php';
 ?>