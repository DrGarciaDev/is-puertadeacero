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
	Class Casas
    {
        private $id;
        private $dueno;
        private $adeudo;
        private $usuario_id;
       
        /**
         * Constructor de la Clase
         */
        function __construct($id = "", $dueno = "",
                            $adeudo = "", $usuario_id = "") 
        {
            $this->id           = $id;
            $this->dueno        = $dueno;
            $this->adeudo       = $adeudo;
            $this->usuario_id   = $usuario_id;
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
         * Gets the value of dueno
         */
        public function get_dueno()
        {
            return $this->dueno;
        }
        
        /**
         * Sets the value of dueno
         */
        public function set_dueno($dueno)
        {
            $this->dueno = $dueno;
        }
        
        /**
         * Gets the value of adeudo
         */
        public function get_adeudo()
        {
            return $this->adeudo;
        }
        
        /**
         * Sets the value of adeudo
         */
        public function set_adeudo($adeudo)
        {
            $this->adeudo = $adeudo;
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


        public function Buscar_casa($buscar = '')
        {
        	include('../config/conexion.php');

	        if (!empty($buscar) ) {

	        	$busqueda = htmlspecialchars( mysqli_real_escape_string($enlace, $buscar) );

                $sql = "SELECT 
                            casas.id,
                            casas.dueno,
                            casas.adeudo,
                            CONCAT(usuarios.nombres,' ',usuarios.ape_paterno,' ',usuarios.ape_materno) AS nom_usr 
                        
                        FROM casas
                        INNER JOIN usuarios
                        ON casas.usuario_id = usuarios.id
                        WHERE 
                        casas.id LIKE '%".$busqueda."%' OR 
                        casas.dueno LIKE '%".$busqueda."%' OR  
                        casas.adeudo LIKE '%".$busqueda."%' ";      
                        
                $resultadoEsp = mysqli_query($enlace, $sql);
                $count = mysqli_num_rows($resultadoEsp);
				
				if(isset($count)) { 
					if($count > 0) { 
						$contenido = '
							<table class="bordered highlight striped centered responsive-table">
                                <thead>
                                    <tr>
                                        <th>Id Casa</th>
                                        <th>Dueño(s)</th>
                                        <th>Adeudo</th>
                                        <th>Usuario asignado</th>                                        
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';
						while ($row = $resultadoEsp->fetch_object()){ 
							$contenido .= '
									<tr>
                                        <td>'.$row->id.'</td>
                                        <td>'.$row->dueno.'</td>
                                        <td>'.$row->adeudo.'</td>
                                        <td>'.$row->nom_usr.'</td>
                                        <td>
                                            <a href="../vistas/vista_casas_editar?Id_casa='.$row->id.'" class="btn orange darken-1" title="Editar casa">Editar</a>
                                            <button type="button" class="btn red" onclick="eliminar_casa(\''.$row->dueno.'\', \''.$row->adeudo.'\', '.$row->id.')" title="Eliminar casa">Borrar</button>
                                        </td>
                                    </tr>';
						} 
						$contenido .= '
								</tbody>
                            </table>';
					}else{
						$contenido = '<div class="card amber lighten-4 center">
                                        <div class="card-content red-text">
                                        <p>Busca de nuevo; casa inexistente...</p>
                                    </div>
                                </div>';
					} 
				}
			}

			echo $contenido;
        }

        public function Ver_todas_casas()
        {
        	include('../config/conexion.php');
			
			$contenido = '<h4>Todas las casas</h4>';
            
            $query="SELECT casas.id,
                            casas.dueno,
                            casas.adeudo,
                            CONCAT(usuarios.nombres,' ',usuarios.ape_paterno,' ',usuarios.ape_materno) AS nom_usr 
                        
                    FROM casas
                    INNER JOIN usuarios
                    ON casas.usuario_id = usuarios.id";
            $resultado = mysqli_query($enlace, $query);
        
            $contenido .= '
                <table class="bordered highlight striped centered responsive-table">
                    <thead>
                        <tr>
                            <th>Id Casa</th>
                            <th>Dueño(s)</th>
                            <th>Adeudo</th>
                            <th>Usuario asignado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
            while ($row = $resultado->fetch_object()) { 
                $contenido .= '
                        <tr>
                            <td>'.$row->id.'</td>
                            <td>'.$row->dueno.'</td>
                            <td>'.$row->adeudo.'</td>
                            <td>'.$row->nom_usr.'</td>
                            <td>
                                <a href="../vistas/vista_casas_editar?Id_casa='.$row->id.'" class="btn orange darken-1" title="Editar casa">editar</a>
                                <button type="button" class="btn red" onclick="eliminar_casa(\''.$row->dueno.'\', \''.$row->adeudo.'\', '.$row->id.')" title="Eliminar casa">Borrar</button>
                            </td>
                        </tr>';
                } 
                $contenido .= '
                    </tbody>
                </table>';

			echo $contenido;
        }

        public function Eliminar_casa($value)
        {
        	include('../config/conexion.php');

            $id = htmlspecialchars( mysqli_real_escape_string($enlace, $value) );

            $query = "DELETE FROM casas WHERE id = ".$id;
            $resultado = mysqli_query($enlace,$query);

            if($resultado){
                $_SESSION['flash'] = "CaE";
                $contenido = "Casa eliminada";
            }
            else {
                $contenido = "Casa no eliminada";
            }

			echo $contenido;
        }

        public function Agregar_casa()
        {
        	include('../config/conexion.php');

        	//###### FILTRO anti-XSS
			$dueno = trim(strtoupper(htmlspecialchars( mysqli_real_escape_string($enlace, $this->dueno) ) ) );
            $adeudo = htmlspecialchars( mysqli_real_escape_string($enlace, $this->adeudo) );
            $usuario = htmlspecialchars( mysqli_real_escape_string($enlace, $this->usuario_id) );

            $sql_insert = "INSERT INTO casas(dueno,adeudo,usuario_id) VALUES('$dueno', $adeudo, $usuario);";

            //DEVUELVE TRUE SI LA CONSULTA CON INSERT SE REALIZA CON EXITO
            if (mysqli_query($enlace, $sql_insert) === TRUE) {
                $contenido = 'Casa registrada con éxito';
            }
            else {
                $contenido = 'Casa No registrada, intentalo nuevamente';
            }
            echo $contenido;
        }

        public function Editar_casa()
        {
            include('../config/conexion.php');

            $id         = htmlspecialchars( mysqli_real_escape_string($enlace, $this->id ) );
            $dueno      = trim(strtoupper(htmlspecialchars( mysqli_real_escape_string($enlace, $this->dueno) ) ) );
            $adeudo     = htmlspecialchars( mysqli_real_escape_string($enlace, $this->adeudo ) );
            $usuario    = htmlspecialchars( mysqli_real_escape_string($enlace, $this->usuario_id ) );

            $query = "UPDATE casas SET dueno = '".$dueno."', adeudo = ".$adeudo.", usuario_id = ".$usuario." WHERE id = ".$id ;
            
            $resultado = mysqli_query($enlace, $query);
            
            if ($resultado) {
                $contenido = 'Casa editada con éxito';
            }
            else {
                $contenido = 'Casa No editada, intentalo nuevamente';
            }

            echo $contenido;
        }

    }//FIN DE LA CLASE USUARIOS

?>