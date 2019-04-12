<?php

	session_start();
	ob_start();

	if( !isset($_SESSION['usuario']) ){
	 	header('Location: vistas/vista_ingresar');exit();
	}else{
		header('Location: vistas/vista_principal');
	}

?>