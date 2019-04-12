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
	$titulo = "USUARIOS - AGREGAR";

	include ('../modelos/modelo_usuarios.php');
	include ('../include/header.php');

?>
	<script type="text/javascript">

		function agregar_usuarios() {

	        var tipo 			= $("#Tipo").val().trim();
	        var nombres 		= $("#Nombres").val().trim();
	        var ape_pat 		= $("#Ape_pat").val().trim();
	        var ape_mat 		= $("#Ape_mat").val().trim();
	        var telefono 		= $("#Telefono").val().trim();
	        var correo 			= $("#Correo").val().trim();
	        var contrasena 		= $("#Contrasena").val().trim();
	        var contrasena2 	= $("#Contrasena2").val().trim();

	        if (tipo == "" || nombres == "" || 
	        	ape_pat == "" || ape_mat == "" || 
	        	telefono == "" || correo == "" || 
	        	contrasena == "" || contrasena2 == "") {
	            alert('Todos los campos son obligatrorios...');
	        }
	        else{

	            $.ajax({
	                url: '../controladores/controlador_usuarios.php',
	                type: 'POST',
	                async: true,
	                data: 	'Tipo='+tipo+
	                		'&Nombres='+nombres+
	                		'&Ape_pat='+ape_pat+
	                		'&Ape_mat='+ape_mat+
	                		'&Telefono='+telefono+
	                		'&Correo='+correo+
	                		'&Contrasena='+contrasena+
	                		'&Contrasena2='+contrasena2,
	                success: function(data){           
	                    alert(data);  
	                    window.location.replace("../vistas/vista_usuarios_ver_todos");             
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
				<h2 class="header orange-text">Registrar Nuevo Usuario</h2>

				<form action="" method="POST">

					<select class="browser-default" id="Tipo" name="Tipo">
						<option disabled>Elige el tipo de usuario</option>
						<option >Administrador</option>
						<option selected >Empleado</option>
					</select>

					<div class="input-field">
					  <i class="material-icons prefix">perm_identity</i>
					  <input type="text" name="Nombres" id="Nombres" class="validate" required>
					  <label for="Nombres" data-error="Error" data-success="Correcto">Nombre(s)</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">perm_identity</i>
					  <input type="text" name="Ape_pat" id="Ape_pat" class="validate" required>
					  <label for="Ape_pat" data-error="Error" data-success="Correcto">Apellido Paterno</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">perm_identity</i>
					  <input type="text" name="Ape_mat" id="Ape_mat" class="validate" required>
					  <label for="Ape_mat" data-error="Error" data-success="Correcto">Apellido Materno</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">email</i>
					  <input type="text" name="Telefono" id="Telefono" class="validate" required>
					  <label for="Telefono">Teléfono</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">email</i>
					  <input type="email" name="Correo" id="Correo" class="validate" required>
					  <label for="Correo" data-error="Error" data-success="Correcto">Correo</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">https</i>
					  <input type="password" name="Contrasena" id="Contrasena" class="validate" required>
					  <label for="Contrasena">Contraseña</label>
					</div>

					<div class="input-field">
					  <i class="material-icons prefix">https</i>
					  <input type="password" name="Contrasena2" id="Contrasena2" class="validate" required>
					  <label for="Contrasena2">Repite la contraseña</label>
					</div>					

					<div class="form-group">
                        <input type="button" class="btn  waves-effect green" value="AGREGAR" onclick="agregar_usuarios()"/>
						&nbsp;
						<a href="../vistas/vista_usuarios_ver_todos" class="btn waves-effect waves-light red" role="button">Cancelar</a>
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