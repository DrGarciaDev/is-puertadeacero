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
	$titulo = "PAGOS";

	include ('../modelos/modelo_pagos.php');
	include ('../include/header.php');

?>
<script>
	
	function limpiar_inputs_pagos() {

		$("#Busqueda_pagos").val("");     
		$("#contenido_pagos_encontrados").html("");       

    }

    function buscar_pagos() {

        var buscar = $("#Busqueda_pagos").val().trim();

        if (buscar == "") {
            alert('Introduce tu búsqueda...');
        }
        else{

            $.ajax({
                url: '../controladores/controlador_pagos.php',
                type: 'POST',
                async: true,
                data: 'Busqueda_pago=' + buscar,
                success: function(data){
                    $("#contenido_pagos_encontrados").html(data); 
                },
                error: function(){              
                    alert("Error...");
                }
            });
        }
    }

	//<!--A CONTINUACION SCRIPT PARA INICIALIZAR ELMODAL-->
	$(document).ready(function(){
		// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
		$('.modal').modal();
	});

</script>

    <div class="container z-depth-5">

		<div class="row center">
	        <div class="col s12">
				<h2 class="z-depth-3 teal darken-2">Administración de Pagos</h2>

				<br>
				<br>
				<?php if(isset($_SESSION['usuario'])) { 
					if($_SESSION['tipo'] === "Administrador" ||
						$_SESSION['tipo'] === "Empleado") { ?>
				
					<a href="../vistas/vista_pagos_agregar" class="waves-effect blue lighten-2 btn"><i class="material-icons left">input</i>Realizar pago</a>

					<!-- Modal Trigger -->
					<a class="waves-effect orange btn modal-trigger" href="#modal1"><i class="material-icons left">search</i>Todas los pagos</a>

					<br>
					<br>

					<!-- Modal Structure -->
					<div id="modal1" class="modal bottom-sheet">
						<div class="modal-content">
							<?php 
								$obj_pagos = New Pagos(); 

								$obj_pagos->Ver_todos_pagos();
							?>
						</div>
						<div class="modal-footer">
							<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
						</div>
					</div>

					<form action="" method="POST">

						<div class="input-field">
						  <i class="material-icons prefix">perm_identity</i>
						  <input type="text" name="Busqueda_pagos" id="Busqueda_pagos" class="validate" required>
						  <label for="Busqueda_pagos" data-error="Error" data-success="Correcto">Buscar pago</label>
						</div>

						<br>
						<br>
						<div class="form-group">
                            <input type="button" class="btn  waves-effect brown" value="BUSCAR PAGOS" onclick="buscar_pagos()"/>
                        </div>
						
                        <br>
                        <br>
                        <div class="form-group">
                            <input type="button" class="btn  waves-effect green" value="LIMPIAR FORMULARIOS" onclick="limpiar_inputs_pagos()"/>
                        </div>
						<!--<a href="ver_casas" class="btn waves-effect waves-light red" role="button">Cancelar</a>-->
					</form>
					<!--<button type="button" class="btn btn-primary btn-sm" onclick="location.href='clientes_agregar'">Agregar Nueva</button><br><br>
					-->
					<br>
					<br>

					<div id="contenido_pagos_encontrados" name="contenido_pagos_encontrados"></div>

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

<?php include('../include/footer.php') ?>
