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
	$titulo = "USUARIOS";

	include ('../modelos/modelo_usuarios.php');
	include ('../include/header.php');
?>

<script type="text/javascript">
  
    function limpiar_inputs() {

		$("#busqueda_usuarios").val("");     
		$("#contenido_usuarios_encontrados").html("");       

    }

    function buscar_usuario() {

        var buscar = $("#busqueda_usuarios").val().trim();

        if (buscar == "") {
            alert('Introduce tu búsqueda...');
        }
        else{

            $.ajax({
                url: '../controladores/controlador_usuarios.php',
                type: 'POST',
                async: true,
                data: 'Busqueda=' + buscar,
                success: function(data){
                    $("#contenido_usuarios_encontrados").html(data); 
                },
                error: function(){              
                    alert("Error...");
                }
            });
        }
    }

    function eliminar_usuario(nomb, apee, idd) {
		
		if(confirm("Realmente deseas eliminar al usuario " + nomb + " " + apee + " Con el Id: " + idd + " ?"))
		{
			$.ajax({
                url: '../controladores/controlador_usuarios.php',
                type: 'POST',
                async: true,
                data: 'ID=' + idd,
                success: function(data){           
                    alert(data);
                    location.reload()
                },
                error: function(){              
                    alert("Error...");
                }
            });		
		}
	}

	//<!--A CONTINUACION SCRIPT PARA INICIALIZAR EL MODAL-->
	$(document).ready(function(){
		// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
		$('.modal').modal();
	});

</script>

    <div class="container z-depth-5">
      <?php
      if(isset($_SESSION['flash'])){
        if($_SESSION['flash']=='UsE'){
			echo '<div class="card red lighten-5 center">
					<div class="card-content red-text">
    					<p>Usuario Eliminado Correctamente...</p>
  					</div>
				</div>';
		}elseif($_SESSION['flash']=='UsEd'){
			echo '<div class="card amber lighten-5 center">
					<div class="card-content orange-text">
    					<p>Usuario Editado Correctamente...</p>
  					</div>
				</div>';
        }elseif($_SESSION['flash']=='UsA'){
			echo '<div class="card green lighten-5 center">
					<div class="card-content green-text">
    					<p>Usuario Agregado Correctamente...</p>
  					</div>
				</div>';
        }
        unset($_SESSION['flash']);
      }
      ?>


		<div class="row center">
	        <div class="col s12">
				<h2 class="z-depth-3 deep-orange accent-2">Administración de Usuarios</h2>

				<br>
				<br>
				<?php if(isset($_SESSION['usuario'])) { 
					if($_SESSION['tipo'] === "Administrador") { ?>
				
					<a href="../vistas/vista_usuarios_agregar" class="waves-effect orange lighten-2 btn"><i class="material-icons left">input</i>Agregar usuario</a>

					<!-- Modal Trigger -->
					<a class="waves-effect waves-light btn modal-trigger" href="#modal1"><i class="material-icons left">search</i>Todos los usuarios</a>

					<br>
					<br>

					<!-- Modal Structure -->
					<div id="modal1" class="modal bottom-sheet">
						<div class="modal-content">
						<?php 
							$obj_usuarios = New Usuarios(); 

							$obj_usuarios->Ver_todos();
						?>
						</div>
						<div class="modal-footer">
							<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
						</div>
					</div>

					<form action="" method="POST">

						<div class="input-field">
						  <i class="material-icons prefix">perm_identity</i>
						  <input type="text" name="busqueda_usuarios" id="busqueda_usuarios">
						  <label for="busqueda_usuarios" data-error="Error" data-success="Correcto">Buscar usuario</label>
						</div>

						<br>
						<br>
						<div class="form-group">
                            <input type="button" class="btn  waves-effect brown" value="BUSCAR USUARIOS" onclick="buscar_usuario()"/>
                        </div>
						
                        <br>
                        <br>
                        <div class="form-group">
                            <input type="button" class="btn  waves-effect green" value="LIMPIAR FORMULARIO" onclick="limpiar_inputs()"/>
                        </div>
					</form>
					<br>
					<br>
					
					<div id="contenido_usuarios_encontrados" name="contenido_usuarios_encontrados"></div>
					
					<br>
					<br>
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
    </div><!-- CONTAINER -->

<?php
	include ('../include/footer.php');
?>
