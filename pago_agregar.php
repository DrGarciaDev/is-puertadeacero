<?php
	session_start();
	ob_start();
	if( !isset($_SESSION['usuario']) ){
	header('Location: ingresar');
	exit();
	}
	$titulo = "REGISTRAR PAGO";
	include('config/conexion.php');
	include('include/header.php');
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		/*
		Filtro anti-XSS
		$usuario = htmlspecialchars(mysqli_real_escape_string($enlace, $usuario));
		$contrasena = htmlspecialchars(mysqli_real_escape_string($enlace, $contrasena));
		*/

		//###### FILTRO anti-XSS
		/////$fecha 	= trim(strtoupper(htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Fecha']) ) ) );
		$fecha 	= date('Y-m-d H:i:s');
		$monto 	= htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Monto']) );
		$casa 	= htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Casa']) );

		/*
		if ($tipo == "Administrador"){
			$tip = 1;
		}elseif($tipo == "Usuario") {
			$tip = 2;
		}
		*/
		$sql_pago = "SELECT adeudo FROM casas WHERE id = ".$casa;

		$adeudo = mysqli_query($enlace, $sql_pago);
		$encontrado = mysqli_num_rows($adeudo);

		if ($encontrado > 0) {
			$row = mysqli_fetch_assoc($adeudo);
			$adeudo_temporal = $row['adeudo'];

			$total = $adeudo_temporal - $monto;
			
			$sql_insert = "INSERT INTO pagos(fecha,monto,usuario_id,casa_id) VALUES('$fecha', $monto, ".$_SESSION['usuario'].", $casa);";
			$sql_pago_monto = "UPDATE casas SET adeudo = $total WHERE id = ".$casa;
			//DEVUELVE TRUE SI LA CONSULTA CON INSERT SE REALIZA CON EXITO
			if (mysqli_query($enlace, $sql_insert) === TRUE && mysqli_query($enlace, $sql_pago_monto) === TRUE) {
				echo ' 	<script>
							alert("Pago registrado con éxito");
							location.href="ver_pagos";
						</script>';
			}
			else {
				echo ' 	<script>
							alert("Pago No registrado, intentalo nuevamente");
						</script>';
			}
		}

   }//Fin del if SERVER
?>
<script>
	function habilita_boton() {
		//alert('Elige un usuario valido...');
		document.getElementById('actualizador').disabled = false;
	}
</script>

    <div class="container">

	    <div class="row">
	    	
        <?php if(isset($_SESSION['usuario'])) { 
					if($_SESSION['tipo'] === "Administrador" ||
						$_SESSION['tipo'] === "Empleado") { ?>

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
					  <input type="text" name="Monto" id="Monto" class="validate" required>
					  <label for="Monto" data-error="Error" data-success="Correcto">Monto</label>
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
					<select class="browser-default" name="Casa" id="Casa">
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
					<button class="btn waves-effect waves-light" type="submit" disabled id="actualizador" name="actualizador">Agregar
						<i class="material-icons right">send</i>
					</button>
					<a href="ver_pagos" class="btn waves-effect waves-light red" role="button">Cancelar</a>
					<br>
				</form>
			</div>
			<div class="col s3">
			  
			</div>

		<?php 	}else{
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
		} ?>

      </div>

    </div>
<?php include('include/footer.php') ?>