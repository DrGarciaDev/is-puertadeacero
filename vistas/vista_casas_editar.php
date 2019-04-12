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
	$titulo = "CASAS - EDITAR";

	include ('../modelos/modelo_casas.php');
	include ('../include/header.php');
	if ( array_key_exists('Id_casa', $_GET) ) {
		include ('../config/conexion.php');
		$query = "SELECT * FROM casas WHERE id =" .$_GET['Id_casa'];
		$resultado = mysqli_query($enlace, $query);
		$casa = $resultado->fetch_object();
		if (empty($casa)) {
			echo "<script>
					alert('No existe la casa');
					window.location.replace('../vistas/vista_casas_ver_todas');
				</script>";
		}
	}
?>

<script>
	function editar_casa() {

		var id 			= $("#Id").val().trim();
        var dueno 		= $("#Dueno").val().trim();
        var adeudo 		= $("#Adeudo").val().trim();
        var usuario 	= $("#Usuario").val().trim();

        if (id == "" || dueno == "" || 
        	adeudo == "" || usuario == "" ) {
            alert('Todos los campos son obligatrorios...');
        }
        else{

            $.ajax({
                url: '../controladores/controlador_casas.php',
                type: 'POST',
                async: true,
                data:
                	'Id_editar='+id+ 	
            		'&Dueno_editar='+dueno+
            		'&Adeudo_editar='+adeudo+
            		'&Usuario_editar='+usuario,
                success: function(data){           
                    alert(data);  
                    window.location.replace("../vistas/vista_casas_ver_todas");             
                },
                error: function(){              
                    alert("Error en la consulta... ");
                }
            });
        }
    }

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

					<div class="form-group">
	                    <button class="btn waves-effect waves-light" type="button" disabled id="actualizador" name="actualizador" onclick="editar_casa()">Actualizar
							<i class="material-icons right">send</i>
						</button>
						&nbsp;
						<a href="../vistas/vista_casas_ver_todas" class="btn waves-effect waves-light red" role="button">Cancelar</a>
	                </div>
					
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
<?php include('../include/footer.php') ?>