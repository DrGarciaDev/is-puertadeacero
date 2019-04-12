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
	$titulo = "CASAS";

	include ('../modelos/modelo_casas.php');
	include ('../include/header.php');
?>

<script type="text/javascript">
  
    function limpiar_inputs() {

		$("#busqueda_casas").val("");     
		$("#contenido_casas_encontradas").html("");       

    }

    function buscar_casas() {

        var buscar = $("#busqueda_casas").val().trim();

        if (buscar == "") {
            alert('Introduce tu búsqueda...');
        }
        else{

            $.ajax({
                url: '../controladores/controlador_casas.php',
                type: 'POST',
                async: true,
                data: 'Busqueda_casa=' + buscar,
                success: function(data){
                    $("#contenido_casas_encontradas").html(data); 
                },
                error: function(){              
                    alert("Error...");
                }
            });
        }
    }

    function eliminar_casa(nomb, apee, idd) {
		if(confirm("Realmente deseas eliminar la casa-> " + nomb + " con el adeudo-> " + apee + " ?"))
		{
			$.ajax({
                url: '../controladores/controlador_casas.php',
                type: 'POST',
                async: true,
                data: 'ID_casa=' + idd,
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
        if($_SESSION['flash']=='CaE'){
			echo '<div class="card red lighten-5 center">
					<div class="card-content red-text">
    					<p>Casa Eliminada Correctamente...</p>
  					</div>
				</div>';
		}
        unset($_SESSION['flash']);
      }
      ?>


		<div class="row center">
	        <div class="col s12">
				<h2 class="z-depth-3 green lighten-2">Administración de Casas</h2>

				<br>
				<br>
				<?php if(isset($_SESSION['usuario'])) { 
					if($_SESSION['tipo'] === "Administrador") { ?>
				
					<a href="../vistas/vista_casas_agregar" class="waves-effect blue lighten-2 btn"><i class="material-icons left">input</i>Agregar casa</a>

					<!-- Modal Trigger -->
					<a class="waves-effect orange btn modal-trigger" href="#modal1"><i class="material-icons left">search</i>Todas las casas</a>

					<br>
					<br>

					<!-- Modal Structure -->
					<div id="modal1" class="modal bottom-sheet">
						<div class="modal-content">
							<?php 
								$obj_casas = New Casas(); 

								$obj_casas->Ver_todas_casas();
							?>
						</div>
						<div class="modal-footer">
							<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
						</div>
					</div>

					<form action="" method="POST">

						<div class="input-field">
						  <i class="material-icons prefix">perm_identity</i>
						  <input type="text" name="busqueda_casas" id="busqueda_casas" class="validate" required>
						  <label for="busqueda_casas" data-error="Error" data-success="Correcto">Buscar casa</label>
						</div>

						<br>
						<br>
						<div class="form-group">
                            <input type="button" class="btn  waves-effect brown" value="BUSCAR CASAS" onclick="buscar_casas()"/>
                        </div>
						
                        <br>
                        <br>
                        <div class="form-group">
                            <input type="button" class="btn  waves-effect green" value="LIMPIAR FORMULARIO" onclick="limpiar_inputs()"/>
                        </div>
					</form>
					<br>
					<br>
					
					<div id="contenido_casas_encontradas" name="contenido_casas_encontradas"></div>

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
		    					<p>Error, inicia session...</p>
		  					</div>
						</div>';
				} ?>
			</div>
	  	</div>
    </div><!-- CONTAINER -->
<?php include('../include/footer.php');