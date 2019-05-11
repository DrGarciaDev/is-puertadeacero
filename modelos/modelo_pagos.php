<?php
	if(session_id() == '' || !isset($_SESSION)) { 
         session_start();
        ob_start();
    }
	if( !isset($_SESSION['usuario']) ){
		header('Location: ../vistas/vista_ingresar');
		exit();
	}
	/**
	* Autores: 	Luis Alberto García Rodríguez
	*          	Carlos Ávila Gómez
	*			Saúl
	*/
	Class Pagos
    {
        private $folio;
        private $fecha;
        private $monto;
        private $usuario_id;
        private $casa_id;
       
        /**
         * Constructor de la Clase
         */
        function __construct($folio = "", $fecha = "",
                            $monto = "", $usuario_id = "", 
                            $casa_id = "") 
        {
            $this->folio        = $folio;
            $this->fecha        = $fecha;
            $this->monto       	= $monto;
            $this->usuario_id 	= $usuario_id;
            $this->casa_id   	= $casa_id;
        }

        /**
         * Gets the value of id
         */
        public function get_folio()
        {
            return $this->folio;
        }
        
        /**
         * Sets the value of folio
         */
        public function set_folio($folio)
        {
            $this->folio = $folio;
        }

        /**
         * Gets the value of fecha
         */
        public function get_fecha()
        {
            return $this->fecha;
        }
        
        /**
         * Sets the value of fecha
         */
        public function set_fecha($fecha)
        {
            $this->fecha = $fecha;
        }
        
        /**
         * Gets the value of monto
         */
        public function get_monto()
        {
            return $this->monto;
        }
        
        /**
         * Sets the value of monto
         */
        public function set_monto($monto)
        {
            $this->monto = $monto;
        }

        /**
         * Gets the value of usuario_id
         */
        public function get_usuario_id()
        {
            return $this->usuario_id;
        }
        
        /**
         * Sets the value of usuario_id
         */
        public function set_usuario_id($usuario_id)
        {
            $this->usuario_id = $usuario_id;
        }

        /**
         * Gets the value of usuario_id
         */
        public function get_casa_id()
        {
            return $this->casa_id;
        }
        
        /**
         * Sets the value of casa_id
         */
        public function set_casa_id($casa_id)
        {
            $this->casa_id = $casa_id;
        }

		public function Buscar_pago($buscar = '')
		{
			include('../config/conexion.php');

			$contenido = '';

	        if (!empty($buscar) ) {			

				//###### FILTRO anti-XSS
				$busqueda = htmlspecialchars( mysqli_real_escape_string($enlace, $buscar) );

				$sql = "SELECT 
						pagos.folio,
						pagos.fecha,
						pagos.monto,
						CONCAT(usuarios.nombres,' ',usuarios.ape_paterno,' ',usuarios.ape_materno) AS nombre,
						casas.dueno
						FROM pagos
						INNER JOIN usuarios 
						ON usuarios.id = pagos.usuario_id
						INNER JOIN casas
						ON casas.id = pagos.casa_id 

						WHERE pagos.folio LIKE '%".$busqueda."%' OR 
					    pagos.fecha LIKE '%".$busqueda."%' OR  
					    pagos.monto LIKE '%".$busqueda."%' OR
					    usuarios.nombres LIKE '%".$busqueda."%' OR
					    casas.dueno LIKE '%".$busqueda."%'
					    ORDER BY pagos.folio DESC";	  
				
				if (!$enlace->query($sql)) {
			        printf("Error: %s\n", $enlace->error);
			        die();
			    }
				
				$resultadoEsp = mysqli_query($enlace, $sql);
				$count = mysqli_num_rows($resultadoEsp);

				if(isset($count)) { 
					if($count > 0) { 
						$contenido .= '
							<table class="bordered highlight striped centered responsive-table">
								<thead>
									<tr>
										<th>FOLIO</th>
										<th>FECHA</th>
										<th>MONTO ABONADO</th>
										<th>NOMBRE DE COBRADOR</th>
										<th>DUEÑO CASA</th>
									</tr>
								</thead>
								<tbody>';

						while ($row = $resultadoEsp->fetch_object()){ 
							$contenido .= '
									<tr>
										<td>'.$row->folio.'</td>
										<td>'.$row->fecha.'</td>
										<td>'.$row->monto.'</td>
										<td>'.$row->nombre.'</td>
										<td>'.$row->dueno.'</td>
									</tr>';
							}

						$contenido .= '
								</tbody>
							</table>';
					}else{
						$contenido .= '
							<div class="card amber lighten-4 center">
	         					<div class="card-content red-text">
	                				<p>Busca de nuevo; pago inexistente...</p>
	              				</div>
	            			</div>';
					}
					echo $contenido;
				}
			}//Fin del if (!empty($buscar) )
			else{
				$contenido .= 'Introduce el campo de búsqueda...';
				echo $contenido;
			}
		
		}//Fin de la funcion Buscar_pago

		public function Ver_todos_pagos()
		{
			include('../config/conexion.php');

			$contenido = '';

			$query = "SELECT 
					pagos.folio,
					pagos.fecha,
					pagos.monto,
					CONCAT(usuarios.nombres,' ',usuarios.ape_paterno,' ',usuarios.ape_materno) AS nombre,
					casas.dueno
					FROM pagos
					INNER JOIN usuarios 
					ON usuarios.id = pagos.usuario_id
					INNER JOIN casas
					ON casas.id = pagos.casa_id
					ORDER BY pagos.folio DESC;";

			$resultado 	= mysqli_query($enlace, $query);
			$count 		= mysqli_num_rows($resultado);

			if(isset($count)) { 
				if($count > 0) { 

					$contenido .= '
						<h4>Todas los pagos</h4>
						<table class="bordered highlight striped centered responsive-table">
							<thead>
								<tr>
									<th>FOLIO</th>
									<th>FECHA</th>
									<th>MONTO ABONADO</th>
									<th>NOMBRE DE COBRADOR</th>
									<th>DUEÑO CASA</th>
								</tr>
							</thead>
							<tbody>';
					while ($row = $resultado->fetch_object()) { 
						$contenido .= '	
								<tr>
									<td>'.$row->folio.'</td>
									<td>'.$row->fecha.'</td>
									<td>'.$row->monto.'</td>
									<td>'.$row->nombre.'</td>
									<td>'.$row->dueno.'</td>
								</tr>';
					 }

					$contenido .= ' 
							</tbody>
						</table>';

					echo $contenido;
				}
			}

		}//fin de la función Ver_todos_pagos

		public function Agregar_pago()
		{

			include('../config/conexion.php');

			$contenido = '';

			//###### FILTRO anti-XSS
			$fecha 	= date('Y-m-d H:i:s');
			$monto 	= htmlspecialchars( mysqli_real_escape_string($enlace, $this->monto) );
			$casa 	= htmlspecialchars( mysqli_real_escape_string($enlace, $this->casa_id) );

			$sql_pago = "SELECT adeudo FROM casas WHERE id = ".$casa;

			$adeudo = mysqli_query($enlace, $sql_pago);
			$encontrado = mysqli_num_rows($adeudo);

			if ($encontrado > 0) {
				$row = mysqli_fetch_assoc($adeudo);
				$adeudo_temporal = $row['adeudo'];

				$total = $adeudo_temporal - $monto;
				
				$sql_insert = "INSERT INTO pagos(fecha,monto,usuario_id,casa_id) 
									VALUES('$fecha', $monto, ".$_SESSION['usuario'].", $casa);";
				$sql_pago_monto = "UPDATE casas SET adeudo = $total WHERE id = ".$casa;

				//DEVUELVE TRUE SI LA CONSULTA CON INSERT y UPDATE SE REALIZAN CON EXITO
				if (mysqli_query($enlace, $sql_insert) === TRUE && 
					mysqli_query($enlace, $sql_pago_monto) === TRUE) {
					$contenido .= 'Pago registrado con éxito...';
				}
				else {
					$contenido .= 'Pago No registrado, intentalo nuevamente...';
				}
				echo $contenido;
			}
			else{
				$contenido .= 'No se encontró la casa para realizar el pago...';
				echo $contenido;
			}

		}//Fin de la función Agregar_pago

	}
?>