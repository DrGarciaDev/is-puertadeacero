<?php
	include ('../modelos/modelo_pagos.php');

	$obj_pagos = new Pagos();

	if($_SERVER["REQUEST_METHOD"] == "POST") {
				
		if (isset($_POST['Busqueda_pago']) && $_POST['Busqueda_pago'] != "") {
			
			$obj_pagos->Buscar_pago($_POST['Busqueda_pago']);
		
		}
		
		if (array_key_exists('Monto_agregar', $_POST) &&
			array_key_exists('Casa_agregar', $_POST) ) {

			$obj_pagos->set_monto($_POST['Monto_agregar']);
			$obj_pagos->set_casa_id($_POST['Casa_agregar']);

			$obj_pagos->Agregar_pago();

		}

	}//Fin del if SERVER
	else{
		echo "No es un método de envío de datos válido...";
	}

?>