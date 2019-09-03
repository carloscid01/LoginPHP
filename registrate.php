<?php
session_start();
if (isset($_SESSION['usuario'])) {
	# code...
	header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD']=='POST') {
	# code...
	$usuario=filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING);
	$password=$_POST['password'];
	$password2=$_POST['password2'];
	
	
	$errores='';

	
	if (empty($usuario) or empty($password) or empty ($password2))
	 {
		$errores.='<li>Por favor rellena los datos Correctamente</li>';
	}else{
		try {
			$conexion=new PDO('mysql:host=localhost;dbname=curso','root','Carloscid_azul!');
		} catch (PDOException $e) {
			echo "Error".$e->getMessage();
			
		}
		$statement=$conexion->prepare('SELECT * FROM usuarios WHERE usuario =:usuario LIMIT 1');
		$statement->execute(array(':usuario'=>$usuario));
		$resultado= $statement->fetch();
		if ($resultado != false) {
			# code...
			$errores.='<li>Usuario ya existe</li>';
		}
		//se encrypta contraseña
		$password=hash('sha512', $password);
		$password2=hash('sha512', $password2);
		
		if ($password!=$password2) {
			# code...
			$errores.='<li>Contraseña no son iguales</li>';
		}

	}
	if ($errores =="") {
		# code...
		$statement=$conexion->prepare('INSERT INTO usuarios (id,usuario,pass) values (null,:usuario,:pass)');
		$statement->execute(array(':usuario'=>$usuario,':pass'=>$password));
		header('Location:login.php');
	}
}

require 'views/registrate.view.php';

 ?>