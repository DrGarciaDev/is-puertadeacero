<?php
	session_start();
	ob_start();
	if( !isset($_SESSION['usuario']) ){
	header('Location: ingresar');
	exit();
	}
	$titulo = "CASAS";
	include('config/conexion.php');
	include('include/header.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		//###### FILTRO anti-XSS
		$busqueda = htmlspecialchars( mysqli_real_escape_string($enlace, $_POST['Busqueda']) );

		$sql = "SELECT * FROM casas WHERE 
	    id LIKE '%".$busqueda."%' OR 
	    dueno LIKE '%".$busqueda."%' OR  
	    adeudo LIKE '%".$busqueda."%' ";	  
		
		$resultadoEsp = mysqli_query($enlace, $sql);
		$count = mysqli_num_rows($resultadoEsp);
	}//Fin del if SERVER


//$query = "SELECT * FROM casas;";
//$resultado = mysqli_query($enlace, $query);
?>
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
				
					<a href="casa_agregar" class="waves-effect blue lighten-2 btn"><i class="material-icons left">input</i>Agregar casa</a>

					<!-- Modal Trigger -->
					<a class="waves-effect orange btn modal-trigger" href="#modal1"><i class="material-icons left">search</i>Todas las casas</a>

					<br>
					<br>

					<!-- Modal Structure -->
					<div id="modal1" class="modal bottom-sheet">
						<div class="modal-content">
							<h4>Todas las casas</h4>
							<?php
								$query = "SELECT * FROM casas;";
								$resultado = mysqli_query($enlace, $query);
							?>
							<table class="bordered highlight striped centered responsive-table">
								<thead>
									<tr>
										<th>Id Casa</th>
										<th>Dueño(s)</th>
										<th>Adeudo</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
								<?php while ($row = $resultado->fetch_object()){ ?>
									<tr>
										<td><?php echo $row->id ?>&nbsp;</td>
										<td><?php echo $row->dueno ?>&nbsp;</td>
										<td><?php echo $row->adeudo ?>&nbsp;</td>
										<td>
											<a href="casa_editar?id=<?= $row->id ?>" class="btn orange darken-1" title="Editar casa">editar</a>
											<button type="button" class="btn red" onclick="confirmacion('<?php echo $row->dueno; ?>', '<?php echo $row->adeudo; ?>', <?php echo $row->id; ?> )" title="Eliminar casa">Borrar</button>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
						</div>
					</div>

					<form action="" method="POST">

						<div class="input-field">
						  <i class="material-icons prefix">perm_identity</i>
						  <input type="text" name="Busqueda" id="Busqueda" class="validate" required>
						  <label for="Busqueda" data-error="Error" data-success="Correcto">Buscar casa</label>
						</div>

						<br>
						<br>
						<button class="btn waves-effect brown" type="submit">Buscar
							<i class="material-icons right">send</i>
						</button>
						<!--<a href="ver_casas" class="btn waves-effect waves-light red" role="button">Cancelar</a>-->
					</form>
					<!--<button type="button" class="btn btn-primary btn-sm" onclick="location.href='clientes_agregar'">Agregar Nueva</button><br><br>
					-->
					<br>
					<br>
					<?php if(isset($count)) { 
						if($count > 0) { ?> 
							<table class="bordered highlight striped centered responsive-table">
								<thead>
									<tr>
										<th>Id Casa</th>
										<th>Dueño(s)</th>
										<th>Adeudo</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
								<?php while ($row = $resultadoEsp->fetch_object()){ ?>
									<tr>
										<td><?php echo $row->id ?>&nbsp;</td>
										<td><?php echo $row->dueno ?>&nbsp;</td>
										<td><?php echo $row->adeudo ?>&nbsp;</td>
										<td>
											<a href="casa_editar?id=<?= $row->id ?>" class="btn orange darken-1" title="Editar casa">Editar</a>
											<button type="button" class="btn red" onclick="confirmacion('<?php echo $row->dueno; ?>', '<?php echo $row->casa; ?>', <?php echo $row->id; ?> )" title="Eliminar casa">Borrar</button>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						<?php }else{
							echo '<div class="card amber lighten-4 center">
	             						<div class="card-content red-text">
	                    				<p>Busca de nuevo; casa inexistente...</p>
	                  				</div>
	                			</div>';
						} 
					}?>

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

     <script>
		function confirmacion(nomb, apee, idd) {
			if(confirm("Realmente deseas eliminar la casa-> " + nomb + " con el adeudo-> " + apee + " ?"))
			{
				window.location.href="casa_eliminar?id=" + idd;
			}
		}

		//<!--A CONTINUACION SCRIPT PARA INICIALIZAR ELMODAL-->
		$(document).ready(function(){
			// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
			$('.modal').modal();
		});
    </script>

<?php include('include/footer.php') ?>
