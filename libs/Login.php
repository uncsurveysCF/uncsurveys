<?php
/**
 * Clase Login
 * Abstrae el manejo de sesiones y validación de usuario.
 *
 */
class Login {

    /**
     * Referencia a Base de Datos
     *
     * @var PDOConfig
     */
    private $BASEDATOS;

    /**
     * Variable para guardar los mensajes de error
     *
     * @var unknown_type
     */
    private $ERROR;

    public function __construct() {
        if (!session_start()) {
            $this->ERROR = 'No se puede iniciar la sesion';
            return false;
        } else {
            return true;
        }
    }    
    
    /**
     * Inicia una nueva sesion de usuario si el usuario y el Clave son correctos
     *
     * @param string $nombreUsuario
     * @param string $Clave
     */
    public function iniciar($nombreUsuario, $Clave) {
        $_SESSION['s_nombreUsuario'] = $nombreUsuario;
        $_SESSION['s_Clave'] = sha1($nombreUsuario.$Clave);
        $_SESSION['s_activa'] = false;
    }

    /**
     * Valida que hay una sesion iniciada y es correcta
     *
     */
    public function validar() {
        if (isset($_SESSION['s_nombreUsuario'])) {
            $nombreUsuario = $_SESSION['s_nombreUsuario'];
        } else {
            $this->ERROR = 'no esta seteado el nombre de usuario';
            return false;
        }
        if (isset($_SESSION['s_Clave'])) {
            $Clave = $_SESSION['s_Clave'];
        } else {
            $this->ERROR = 'no esta seteada la clave';
            return false;
        }
        try {
            $this->BASEDATOS = new PDOConfig();
            
            $nombreUsuario=$this->BASEDATOS->filtrar($nombreUsuario);
            
            $sql = "select *
           			FROM usuarios U
					WHERE U.Activo = 1 AND U.Usuario='$nombreUsuario'";
            //echo $sql;
            if (!$resultado = $this->BASEDATOS->query($sql)) {
                $this->ERROR = 'Error Consulta Base de datos';
                return false;
            } else {
                if (!($row = $resultado->fetch(PDO::FETCH_ASSOC))) {
                    $this->ERROR = 'Usuario o clave erronea';
                    return false;
                } else {                	
                    if ($row['Password'] != $Clave) {
                        $this->ERROR = 'Usuario o clave erronea';
                        return false;
                    } else {
                        $_SESSION['s_activa'] = true;
                        $_SESSION['s_ApeyNom'] = $row['Apellido'].', '.$row['Nombre'];
                        $_SESSION['s_idUsuario'] = $row['idUsuario'];
                        return true;
                    }
                }
            }
        } catch (Exception $e) {
            $this->ERROR = 'Error de Base de Datos ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Devuelve el verdadero si hay una sesion activa y falso en caso contrario
     * 
     * @return boolean activa y false si no esta activa o no se encuetra seteado
     */
    public function activa() {
        if (isset($_SESSION['s_activa'])) {
            return $_SESSION['s_activa'];
        } else {
            $this->ERROR = 'No tiene sesion activa';
            return false;
        }
    }

    /**
     * Cierra la session actual
     *
     * @return boolean
     */
    public function cerrar() {
        if (!session_destroy()) {
            $this->ERROR = 'No se puede cerrar la sesion';
            return false;
        } else {
            return true;
        }
    }

    /**
     * Devuelve el mensaje de error
     *
     * @return string
     */
    public function getError() {
        return $this->ERROR;
    }

    /**
     * Devuelve el nombre de usuario de la sesion
     * 
     * @return string Nombre de usuario y false si no esta activa o no se encuetra seteado
     */
    public function getNombreUsuario() {
        if ($this->activa()) {
            if (isset($_SESSION['s_nombreUsuario'])) {
                return $_SESSION['s_nombreUsuario'];
            } else {
                $this->ERROR = 'No esta seteado el nombre de usuario';
                return false;
            }
        } else {
            $this->ERROR = 'No tiene una session activa';
            return false;
        }
    }
    
    /**
     * Devuelve el nombre y apellido del usuario de la sesion
     *
     * @return string Nombre de usuario y false si no esta activa o no se encuetra seteado
     */
    public function getApeNom() {
    	if ($this->activa()) {
    		if (isset($_SESSION['s_ApeyNom'])) {
    			return $_SESSION['s_ApeyNom'];
    		} else {
    			$this->ERROR = 'No esta seteado el nombre del usuario';
    			return false;
    		}
    	} else {
    		$this->ERROR = 'No tiene una session activa';
    		return false;
    	}
    }
    
    /**
     * Devuelve el verdadero si hay una sesion activa y falso en caso contrario
     *
     * @return boolean activa y false si no esta activa o no se encuetra seteado
     */
    public function getIdUsuario() {
    	if (isset($_SESSION['s_idUsuario'])) {
    		return $_SESSION['s_idUsuario'];
    	} else {
    		$this->ERROR = 'No tiene sesion activa';
    		return false;
    	}
    }
    
    
    
}/******************* cierre de clase **************/