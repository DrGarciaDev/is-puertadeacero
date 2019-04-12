<?php
	session_start();
	ob_start();
	if( !isset($_SESSION['usuario']) ){
	header('Location: ingresar');
	exit();
	}
	$titulo = "REGISTRAR CASA";
	include('../config/conexion.php');
	include('../include/header.php');
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		/*
		Filtro anti-XSS
		$usuario = htmlspecialchars(mysqli_real_escape_string($enlace, $usuario));
		$contrasena = htmlspecialchars(mysqli_real_escape_string($enlace, $contrasena));
		*/

		//###### FILTRO anti-XSS
		$dueno = trim(strtoupper(htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Dueno']) ) ) );
		$adeudo = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Adeudo']) );
		$usuario = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Usuario']) );

		/*
		if ($tipo == "Administrador"){
			$tip = 1;
		}elseif($tipo == "Usuario") {
			$tip = 2;
		}
		*/
		$sql_insert = "INSERT INTO casas(dueno,adeudo,usuario_id) VALUES('$dueno', $adeudo, $usuario);";

		//DEVUELVE TRUE SI LA CONSULTA CON INSERT SE REALIZA CON EXITO
		if (mysqli_query($enlace, $sql_insert) === TRUE) {
			echo ' 	<script>
						alert("Casa registrada con éxito");
						location.href="ver_casas";
					</script>';
		}
		else {
			echo ' 	<script>
						alert("Casa No registrada, intentalo nuevamente");
					</script>';
		}

   }//Fin del if SERVER
?>

    <div class="container">
	    <?php
	    	if(isset($_SESSION['flash'])){
	    	if($_SESSION['flash']=='Error'){
	        	echo '<span class="new badge red" data-badge-caption="custom caption">4</span>';
	        }
	        unset($_SESSION['flash']);
	    }
	    ?>
	    <div class="row">
	    	
        <?php if(isset($_SESSION['usuario'])) { 
					if($_SESSION['tipo'] === "Administrador") { ?>

			<div class="col s3">
			  
			</div>
			<div class="col 16 s6 center">
				<h2 class="header orange-text">Registrar Nueva Casa</h2>

				<form action="" method="POST">
					<div class="input-field">
					  <i class="material-icons prefix">perm_identity</i>
					  <input type="text" name="Dueno" id="Dueno" class="validate" required>
					  <label for="Dueno" data-error="Error" data-success="Correcto">Dueño</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">perm_identity</i>
					  <input type="text" name="Adeudo" id="Adeudo" class="validate" required>
					  <label for="Adeudo" data-error="Error" data-success="Correcto">Adeudo</label>
					</div>

					<?php 
						$sql_find_usuarios = "SELECT 
													id, 
													CONCAT(nombres,' ',ape_paterno,' ',ape_materno) AS nombre_usuario 
												FROM usuarios ";
						
						$resultado = mysqli_query($enlace, $sql_find_usuarios);
				      //la siguiente linea funciona igual a la que continúa después
				      //$count = $resultado->num_rows;
						$count = mysqli_num_rows($resultado);
					?>
					<select class="browser-default" name="Usuario" id="Usuario">
						<option value="0" disabled selected>Elige un usuario</option>
						<?php 
							if ($count > 0) {
								while ($fila = mysqli_fetch_assoc($resultado) ) {
						?>
								<option value="<?php echo $fila['id']; ?>"><?php echo $fila['nombre_usuario']; ?></option>
						<?php
								}//FIN DEL WHILE
							}//FIN DEL IF COUNT
						?>
				    </select>
				    <label>Asignar Usuario</label>

					<br>
					<br>
					<button class="btn waves-effect waves-light" type="submit">Agregar
						<i class="material-icons right">send</i>
					</button>
					<a href="ver_proveedores" class="btn waves-effect waves-light red" role="button">Cancelar</a>
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
<?php include('../include/footer.php') ?>