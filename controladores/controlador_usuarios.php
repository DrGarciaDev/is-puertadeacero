<?php
	include ('../modelos/modelo_usuarios.php');

	$obj_usuarios = new Usuarios();

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if($_SESSION['tipo'] === "Administrador") {
		
			if (isset($_POST['Busqueda']) && $_POST['Busqueda'] != "") {
				
				$obj_usuarios->Buscar($_POST['Busqueda']);
			
			}

			if (isset($_POST['ID']) && $_POST['ID'] != "") {
				
				$obj_usuarios->Eliminar($_POST['ID']);

			}
			
			if (array_key_exists('Tipo', $_POST) &&
				array_key_exists('Nombres', $_POST) &&
				array_key_exists('Ape_pat', $_POST) &&
				array_key_exists('Ape_mat', $_POST) &&
				array_key_exists('Telefono', $_POST) &&
				array_key_exists('Correo', $_POST) &&
				array_key_exists('Contrasena', $_POST) &&
				array_key_exists('Contrasena2', $_POST) ) {

				$obj_usuarios->set_tipo($_POST['Tipo']);
				$obj_usuarios->set_nombres($_POST['Nombres']);
				$obj_usuarios->set_ape_paterno($_POST['Ape_pat']);
				$obj_usuarios->set_ape_materno($_POST['Ape_mat']);
				$obj_usuarios->set_telefono($_POST['Telefono']);
				$obj_usuarios->set_email($_POST['Correo']);
				$obj_usuarios->set_pass($_POST['Contrasena']);
				$obj_usuarios->set_pass2($_POST['Contrasena2']);

				$obj_usuarios->Agregar();

			}

			if (array_key_exists('Id_editar', $_POST) &&
				array_key_exists('Tipo_editar', $_POST) &&
				array_key_exists('Nombres_editar', $_POST) &&
				array_key_exists('Ape_pat_editar', $_POST) &&
				array_key_exists('Ape_mat_editar', $_POST) &&
				array_key_exists('Telefono_editar', $_POST) &&
				array_key_exists('Correo_editar', $_POST) &&
				array_key_exists('Contrasena_editar', $_POST) &&
				array_key_exists('Contrasena2_editar', $_POST) ) {
				
				$obj_usuarios->set_id($_POST['Id_editar']);
				$obj_usuarios->set_tipo($_POST['Tipo_editar']);
				$obj_usuarios->set_nombres($_POST['Nombres_editar']);
				$obj_usuarios->set_ape_paterno($_POST['Ape_pat_editar']);
				$obj_usuarios->set_ape_materno($_POST['Ape_mat_editar']);
				$obj_usuarios->set_telefono($_POST['Telefono_editar']);
				$obj_usuarios->set_email($_POST['Correo_editar']);
				$obj_usuarios->set_pass($_POST['Contrasena_editar']);
				$obj_usuarios->set_pass2($_POST['Contrasena2_editar']);

				$obj_usuarios->Editar();

			}

		}

	}//Fin del if SERVER

?>