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
	/**
	* Autores: Luis Alberto García Rodríguez
	*          Carlos 
	*/
	Class Usuarios
    {
        private $id;
        private $nombres;
        private $ape_paterno;
        private $ape_materno;
        private $pass;
        private $pass2;
        private $telefono;
        private $email;
        private $tipo;

        /**
         * Constructor de la Clase
         */
        function __construct($id = "", $tipo = "", $pass2 = "",
                            $ap_paterno = "", $ap_materno = "", 
                            $nombres = "", $pass = "", 
                            $telefono = "", $email = "" ) 
        {
            $this->id               = $id;
            $this->nombres          = $nombres;
            $this->ape_paterno      = $ap_paterno;
            $this->ape_materno      = $ap_materno;
            $this->pass             = $pass;
            $this->pass2            = $pass2;
            $this->telefono         = $telefono;
            $this->email            = $email;
            $this->tipo             = $tipo;
        }

        /**
         * Gets the value of id
         */
        public function get_id()
        {
            return $this->id;
        }
        
        /**
         * Sets the value of id
         */
        public function set_id($id)
        {
            $this->id = $id;
        }

        /**
         * Gets the value of tipo
         */
        public function get_tipo()
        {
            return $this->tipo;
        }
        
        /**
         * Sets the value of tipo
         */
        public function set_tipo($tipo)
        {
            $this->tipo = $tipo;
        }

        /**
         * Gets the value of ape_paterno
         */
        public function get_ape_paterno()
        {
            return $this->ape_paterno;
        }
        
        /**
         * Sets the value of ape_paterno
         */
        public function set_ape_paterno($ape_paterno)
        {
            $this->ape_paterno = $ape_paterno;
        }

        /**
         * Gets the value of ape_materno
         */
        public function get_ape_materno()
        {
            return $this->ape_materno;
        }
        
        /**
         * Sets the value of ape_materno
         */
        public function set_ape_materno($ape_materno)
        {
            $this->ape_materno = $ape_materno;
        }

        /**
         * Gets the value of nombres
         */
        public function get_nombres()
        {
            return $this->nombres;
        }
        
        /**
         * Sets the value of nombres
         */
        public function set_nombres($nombres)
        {
            $this->nombres = $nombres;
        }

        /**
         * Gets the value of pass
         */
        public function get_pass()
        {
            return $this->pass;
        }
        
        /**
         * Sets the value of pass
         */
        public function set_pass($pass)
        {
            $this->pass = $pass;
        }

        /**
         * Gets the value of pass
         */
        public function get_pass2()
        {
            return $this->pass2;
        }
        
        /**
         * Sets the value of pass
         */
        public function set_pass2($pass2)
        {
            $this->pass2 = $pass2;
        }

        /**
         * Gets the value of telefono
         */
        public function get_telefono()
        {
            return $this->telefono;
        }
        
        /**
         * Sets the value of telefono
         */
        public function set_telefono($telefono)
        {
            $this->telefono = $telefono;
        }

        /**
         * Gets the value of email
         */
        public function get_email()
        {
            return $this->email;
        }
        
        /**
         * Sets the value of email
         */
        public function set_email($email)
        {
            $this->email = $email;
        }

        public function Buscar($buscar = '')
        {
        	include('../config/conexion.php');

	        if (!empty($buscar) ) {

	        	$busqueda = htmlspecialchars( mysqli_real_escape_string($enlace, $buscar) );

				$sql = "SELECT * FROM usuarios WHERE 
			    id LIKE '%".$busqueda."%' OR 
			    tipo LIKE '%".$busqueda."%' OR 
			    correo LIKE '%".$busqueda."%' OR
			    nombres LIKE '%".$busqueda."%' OR  
			    ape_materno LIKE '%".$busqueda."%' OR  
			    ape_paterno LIKE '%".$busqueda."%' ";
				
				$resultadoEsp = mysqli_query($enlace, $sql);
				$count = mysqli_num_rows($resultadoEsp);
				
				if(isset($count)) { 
					if($count > 0) { 
						$contenido = '
							<table class="bordered highlight striped centered responsive-table">
								<thead>
									<tr>
										<th>Id usuario</th>
										<th>Tipo de Usuario</th>
										<th>Correo</th>
										<th>Nombre(s)</th>
										<th>Apellido Paterno</th>
										<th>Apellido Materno</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>';
						while ($row = $resultadoEsp->fetch_object()){ 
							$contenido .= '
									<tr>
										<td>'.$row->id.'</td>
										<td>'.$row->tipo.'</td>
										<td>'.$row->correo.'</td>
										<td>'.$row->nombres.'</td>
										<td>'.$row->ape_paterno.'</td>
										<td>'.$row->ape_materno.'</td>
										<td>
											<a href="../vistas/vista_usuarios_editar?id='.$row->id.'" class="btn yellow darken-1" title="Editar usuario">Editar</a>
											<button type="button" class="btn red" onclick="eliminar_usuario(\''.$row->nombres.'\', \''.$row->ape_paterno.'\', '.$row->id.')" title="Eliminar usuario">Borrar</button>
										</td>
									</tr>';
						} 
						$contenido .= '
								</tbody>
							</table>';
					}else{
						$contenido = '<div class="card amber lighten-4 center">
             						<div class="card-content red-text">
                    				<p>Busca de nuevo; Usuario inexistente...</p>
                  				</div>
                			</div>';
					} 
				}
			}

			echo $contenido;
        }

        public function Ver_todos()
        {
        	include('../config/conexion.php');
			
			$query = "SELECT * FROM usuarios;";
			$resultado = mysqli_query($enlace, $query);
			
			$contenido = '
				<table class="bordered highlight striped centered responsive-table">
					<thead>
						<tr>
							<th>Id usuario</th>
							<th>Tipo de Usuario</th>
							<th>Correo</th>
							<th>Nombre(s)</th>
							<th>Apellido Paterno</th>
							<th>Apellido Materno</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>';
			while ($row = $resultado->fetch_object()){
				$contenido .= '
						<tr>
							<td>'.$row->id.'</td>
							<td>'.$row->tipo.'</td>
							<td>'.$row->correo.'</td>
							<td>'.$row->nombres.'</td>
							<td>'.$row->ape_paterno.'</td>
							<td>'.$row->ape_materno.'</td>
							<td>
								<a href="../vistas/vista_usuarios_editar?id='.$row->id.'" class="btn yellow darken-1" title="Editar usuario">Editar</a>
								<button type="button" class="btn red" onclick="eliminar_usuario(\''.$row->nombres.'\', \''.$row->ape_paterno.'\', '.$row->id.');" title="Eliminar usuario">Borrar</button>
							</td>
						</tr>';
			}
			$contenido .= '
					</tbody>
				</table>';

			echo $contenido;
        }

        public function Eliminar($value)
        {
        	include('../config/conexion.php');

        	$query = "DELETE FROM usuarios WHERE id = ".$value;
			$resultado = mysqli_query($enlace,$query);

			if($resultado){
				$_SESSION['flash'] = "UsE";
				$contenido = "Usuario eliminado";
			}
			else{
				$contenido = "Usuario no eliminado";
			}

			echo $contenido;
        }

        public function Agregar()
        {
        	include('../config/conexion.php');

        	//###### FILTRO anti-XSS
			$nombre = htmlspecialchars(mysqli_real_escape_string($enlace, $this->nombres ) );
			$ape_pat = htmlspecialchars(mysqli_real_escape_string($enlace, $this->ape_paterno ) );
			$ape_mat = htmlspecialchars(mysqli_real_escape_string($enlace, $this->ape_materno ) );
			$telefono = htmlspecialchars(mysqli_real_escape_string($enlace, $this->telefono ) );
			$correo = htmlspecialchars(mysqli_real_escape_string($enlace, $this->email ) );
			$contrasena = htmlspecialchars(mysqli_real_escape_string($enlace, $this->pass ) );
			$contrasena2 = htmlspecialchars(mysqli_real_escape_string($enlace, $this->pass2 ) );
	      	$tipo = htmlspecialchars(mysqli_real_escape_string($enlace, $this->tipo ) );
	      	
			$sql_Check_Mail = "SELECT * FROM usuarios WHERE correo = 'htmlentities($correo)'; ";
			
			$result = mysqli_query($enlace, $sql_Check_Mail);

			$count = mysqli_num_rows($result);

			if($contrasena == $contrasena2){
				if($count > 0){
					$_SESSION['flash'] = "Error";
				}else {
					if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
						$passCifrado = password_hash($contrasena, PASSWORD_DEFAULT);
						//var_dump($nombre, $ape_pat, $ape_mat, $curp, $correo, $contrasena, $tipo, $passCifrado);
						$sql_insert = "INSERT INTO usuarios(nombres, ape_paterno, ape_materno, telefono, correo, contrasena, tipo) 
                                                    VALUES('$nombre','$ape_pat','$ape_mat','$telefono','$correo','$passCifrado','$tipo');";
						mysqli_query($enlace,$sql_insert)
							or die("Error en la consulta insert usuario: $sql_insert");
						//echo 'Se ha registrado con exito';
						$contenido = 'Usuario registrado con éxito';
						$_SESSION['flash'] = "UsA";
					}else{
						$contenido = 'Error! No es un correo...';
					}
					
				}// fin del if count
			}else{
				$contenido = 'Error! Las contraseñas son distintas';
			}//fin total del if checa contraseña

            echo $contenido;
        }

        public function Editar()
        {
            include('../config/conexion.php');

            $id = htmlspecialchars( mysqli_real_escape_string($enlace, $this->id) );
            $nombres = htmlspecialchars(mysqli_real_escape_string($enlace, $this->nombres ) );
            $ape_pat = htmlspecialchars(mysqli_real_escape_string($enlace, $this->ape_paterno ) );
            $ape_mat = htmlspecialchars(mysqli_real_escape_string($enlace, $this->ape_materno ) );
            $telefono = htmlspecialchars(mysqli_real_escape_string($enlace, $this->telefono ) );
            $correo = htmlspecialchars(mysqli_real_escape_string($enlace, $this->email ) );
            $contrasena = htmlspecialchars(mysqli_real_escape_string($enlace, $this->pass ) );
            $contrasena2 = htmlspecialchars(mysqli_real_escape_string($enlace, $this->pass2 ) );
            $tipo = htmlspecialchars(mysqli_real_escape_string($enlace, $this->tipo ) );
            
            $contenido = "Sin movimientos";

            if($contrasena === $contrasena2){
                if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
                    $passCifrado = password_hash($contrasena, PASSWORD_DEFAULT);
                    $query = "UPDATE usuarios SET tipo = '" . $tipo . "', telefono = '" . $telefono . "', 
                        correo = '" . $correo . "', contrasena = '" . $passCifrado . "', nombres = '" . $nombres . "', 
                        ape_paterno = '" . $ape_pat . "', ape_materno = '" . $ape_mat . "' WHERE id =".$id;
                    $resultado = mysqli_query($enlace, $query);
                    if ($resultado) {
                        $_SESSION['flash'] = "UsEd";
                        $contenido = 'Usuario Actualizado con éxito';
                    }
                    else {
                        $contenido = 'Usuario No editado, intentalo nuevamente';
                    }
                }else{
                    $contenido = 'Ingrese correo valido y vuelve a intentarlo';
                }
            }else{
                $contenido = 'Las contraseñas no coinciden, vuelve a intentarlo';
            }

            echo $contenido;
        }

    }//FIN DE LA CLASE USUARIOS

?>