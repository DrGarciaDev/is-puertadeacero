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
	$titulo = "CASAS - AGREGAR";

	include ('../modelos/modelo_casas.php');
	include ('../include/header.php');
	include('../config/conexion.php');

?>
	<script type="text/javascript">

		function agregar_casas() {

	        var dueno 		= $("#Dueno").val().trim();
	        var adeudo 		= $("#Adeudo").val().trim();
	        var usuario 	= $("#Usuario").val().trim();

	        if (dueno == "" || adeudo == "" || 
	        	usuario == "" ) {
	            alert('Todos los campos son obligatrorios...');
	        }
	        else{

	            $.ajax({
	                url: '../controladores/controlador_casas.php',
	                type: 'POST',
	                async: true,
	                data: 	'Dueno_agregar='+dueno+
	                		'&Adeudo_agregar='+adeudo+
	                		'&Usuario_agregar='+usuario,
	                success: function(data){           
	                    alert(data);  
	                    window.location.replace("../vistas/vista_casas_ver_todas");             
	                },
	                error: function(){              
	                    alert("Error...");
	                }
	            });
	        }
	    }
	</script>

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
					<div class="form-group">
                        <input type="button" class="btn  waves-effect green" value="AGREGAR" onclick="agregar_casas()"/>
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
    					<p>ERROR...</p>
  					</div>
				</div>';
		} ?>

      </div>

    </div>
<?php include('../include/footer.php') ?>