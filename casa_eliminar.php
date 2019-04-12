<?php
session_start();
ob_start();
if(!isset($_SESSION['usuario'])){
  header('Location: ingresar');
  exit();
}

include('config/conexion.php');
include('include/header.php');
if(empty($_GET['id'])){
  header('Location: ver_casas');
  exit();
} 

if(isset($_SESSION['usuario'])) { 
	if($_SESSION['tipo'] === "Administrador") {
		$id = htmlspecialchars( mysqli_real_escape_string($enlace, $_GET['id']) );

		$query = "DELETE FROM casas WHERE id = ".$id;
		$resultado = mysqli_query($enlace,$query);
		if($resultado){
			$_SESSION['flash'] = "CaE";
	  		echo '<script>
					location.href="ver_casas";
				</script>';
		}
		else {
			echo "<script>alert('Casa no eliminada...');</script>";
		}
	}
	else {
		echo "<script>alert('No tienes los permisos...');</script>";
	}
}
?>