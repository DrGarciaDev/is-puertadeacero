<?php
	if(session_id() == '' || !isset($_SESSION)) { 
        //session_set_cookie_params(constant('timeC'), constant('path'), $domain, true, true);
        session_start();
        ob_start();
    }
	if( !isset($_SESSION['usuario']) ){
		header('Location: ../vistas/vista_ingresar');
		exit();
	}
	$titulo = "PAGOS - AGREGAR";

	include ('../modelos/modelo_pagos.php');
	include ('../include/header.php');
	include ('../config/conexion.php');

?>
<script>
	
	function agregar_pago() {

        var monto 			= $("#Monto_abonar").val().trim();
        var casa_agregar 	= $("#Casa_abonar").val().trim();

        if (monto == "" || casa_agregar == "") {
            alert('Todos los campos son obligatrorios...');
        }
        else{

            $.ajax({
                url: '../controladores/controlador_pagos.php',
                type: 'POST',
                async: true,
                data: 	'Monto_agregar='+monto+
                		'&Casa_agregar='+casa_agregar,
                success: function(data){           
                    alert(data);  
                    window.location.replace("../vistas/vista_pagos_ver_todos");             
                },
                error: function(){              
                    alert("Error...");
                }
            });
        }
    }//Fin de la función agregar pagos

	function habilita_boton() {
		document.getElementById('actualizador').disabled = false;
	}
</script>

    <div class="container">

	    <div class="row">
	    	
<?php 
if(isset($_SESSION['usuario'])) { 
	if($_SESSION['tipo'] === "Administrador" ||
		$_SESSION['tipo'] === "Empleado") { 
?>

			<div class="col s3">
			  
			</div>
			<div class="col 16 s6 center">
				<h2 class="header orange-text">Registrar Pago</h2>

				<form action="" method="POST">

					<ul class="collection">
						<li class="collection-item active">
							<h5>Fecha de pago: <?php echo date('Y-m-d'); ?></h5>
						</li>
					</ul>

					<div class="input-field">
					  <i class="material-icons prefix">attach_money</i>
					  <input type="text" name="Monto_abonar" id="Monto_abonar" class="validate" required>
					  <label for="Monto_abonar" data-error="Error" data-success="Correcto">Monto</label>
					</div>

					<?php 
						$sql_find_casas = "SELECT 
											id, 
											CONCAT('Dueño: ',dueno,' Adeudo: ',adeudo) AS dueno_casa 
										FROM casas ";
						
						$resultado = mysqli_query($enlace, $sql_find_casas);
				      //la siguiente linea funciona igual a la que continúa después
				      //$count = $resultado->num_rows;
						$count = mysqli_num_rows($resultado);
					?>
					<select class="browser-default" name="Casa_abonar" id="Casa_abonar">
						<option value="0" disabled selected>Elige una casa</option>
						<?php 
							if ($count > 0) {
								while ($fila = mysqli_fetch_assoc($resultado) ) {
						?>
									<option onclick="habilita_boton();" value="<?php echo $fila['id']; ?>"><?php echo $fila['dueno_casa']; ?></option>
						<?php
								}//FIN DEL WHILE
							}//FIN DEL IF COUNT
						?>
				    </select>
				    <label>Casa a abonar pago</label>

					<br>
					<br>
					<div class="form-group">
                        <input type="button" class="btn waves-effect green" value="AGREGAR" onclick="agregar_pago()"/>
						&nbsp;
						<a href="../vistas/vista_pagos_ver_todos" class="btn waves-effect waves-light red" role="button">Cancelar</a>
                    </div>
					<br>
				</form>
			</div>
			<div class="col s3">
			  
			</div>

<?php 
	}
	else{
		echo '<div class="card red center">
				<div class="card-content white-text">
					<p>ERROR NO tienes los permisos necesarios...</p>
					</div>
			</div>';
	}
}else{
	echo '<div class="card red lighten-5 center">
			<div class="card-content red-text">
				<p>ERROR...</p>
				</div>
		</div>';
} 
?>

      </div>

    </div>
<?php include('../include/footer.php') ?>