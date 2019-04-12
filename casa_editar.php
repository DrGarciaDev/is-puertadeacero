<?php
session_start();
ob_start();
if( !isset($_SESSION['usuario']) ){
  header('Location: ingresar');
  exit();
}

$titulo = "EDITAR CASA";

include('config/conexion.php');
include ('include/header.php');

$id_recibido = htmlspecialchars( mysqli_real_escape_string($enlace, $_GET['id']) );

$query = "SELECT * FROM casas WHERE id = ".$id_recibido;

$resultado = mysqli_query($enlace, $query);

$casa = $resultado->fetch_object();

if (empty($casa)) {
	exit();
}

if (!empty($_POST)) {

	$id 		= htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Id']) );
	$dueno 		= trim(strtoupper(htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Dueno']) ) ) );
	$adeudo 	= htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Adeudo']) );
	$usuario 	= htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Usuario']) );

		$query = "UPDATE casas SET dueno = '".$dueno."', adeudo = ".$adeudo.", usuario_id = ".$usuario." WHERE id = ".$id ;
		
		$resultado = mysqli_query($enlace, $query);
		
		if ($resultado) {
			echo ' 	<script>
						alert("Casa editada con éxito");
						location.href="ver_casas";
					</script>';
		}
		else {
			echo ' 	<script>
						alert("Casa No editada, intentalo nuevamente");
					</script>';
		}
}
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
					if($_SESSION['tipo'] === "Administrador") { ?>

			<div class="col s3">
			  
			</div>
			<div class="col 16 s6 center">
				<h2 class="header orange-text">Editar casa del dueño: <?php if(isset($casa->dueno)) echo $casa->dueno; ?></h2>

				<p class="teal-text">Puedes modificar cualquier campo...</p>
				<form action="" method="POST">

					<input type="hidden" name="Id" id="Id" value="<?php if(isset($casa->id)) echo $casa->id; ?>">

					<div class="input-field">
					  <i class="material-icons prefix">perm_identity</i>
					  <input type="text" name="Dueno" id="Dueno" class="validate" value="<?php if(isset($casa->dueno)) echo $casa->dueno; ?>" required>
					  <label for="Dueno" data-error="Error" data-success="Correcto">Dueño</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">perm_identity</i>
					  <input type="text" name="Adeudo" id="Adeudo" class="validate" value="<?php if(isset($casa->adeudo)) echo $casa->adeudo; ?>" required>
					  <label for="Adeudo" data-error="Error" data-success="Correcto">Apellido paterno</label>
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
								<option onclick="habilita_boton();" value="<?php echo $fila['id']; ?>"><?php echo $fila['nombre_usuario']; ?></option>
						<?php
								}//FIN DEL WHILE
							}//FIN DEL IF COUNT
						?>
				    </select>
				    <label>Asignar Otro Usuario</label>


					<br>
					<br>
					<button class="btn waves-effect waves-light" type="submit" disabled id="actualizador" name="actualizador">Actualizar
						<i class="material-icons right">send</i>
					</button>
					<a href="ver_casas" class="btn waves-effect waves-light red" role="button">Cancelar</a>
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
    					<p>Error, inicia session...</p>
  					</div>
				</div>';
		} ?>

      </div>

    </div>
<?php include('include/footer.php') ?>