<?php
	include ('../modelos/modelo_casas.php');

	$obj_casas = new Casas();

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if($_SESSION['tipo'] === "Administrador") {
		
			if (isset($_POST['Busqueda_casa']) && $_POST['Busqueda_casa'] != "") {
				
				$obj_casas->Buscar_casa($_POST['Busqueda_casa']);
			
			}

			if (isset($_POST['ID_casa']) && $_POST['ID_casa'] != "") {
				
				$obj_casas->Eliminar_casa($_POST['ID_casa']);

			}
			
			if (array_key_exists('Dueno_agregar', $_POST) &&
				array_key_exists('Adeudo_agregar', $_POST) &&
				array_key_exists('Usuario_agregar', $_POST) ) {

				$obj_casas->set_dueno($_POST['Dueno_agregar']);
				$obj_casas->set_adeudo($_POST['Adeudo_agregar']);
				$obj_casas->set_usuario_id($_POST['Usuario_agregar']);

				$obj_casas->Agregar_casa();

			}

			if (array_key_exists('Id_editar', $_POST) &&
				array_key_exists('Dueno_editar', $_POST) &&
				array_key_exists('Adeudo_editar', $_POST) &&
				array_key_exists('Usuario_editar', $_POST) ) {

				$obj_casas->set_id($_POST['Id_editar']);
				$obj_casas->set_dueno($_POST['Dueno_editar']);
				$obj_casas->set_adeudo($_POST['Adeudo_editar']);
				$obj_casas->set_usuario_id($_POST['Usuario_editar']);

				$obj_casas->Editar_casa();

			}

		}

	}//Fin del if SERVER

?>