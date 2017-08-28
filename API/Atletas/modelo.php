<?php
/**
* Clase Connect
*/
class Conexion
{
	public $connection;
	function __construct()
	{
		$this->connection = new mysqli("localhost","root", "Jesus8", "carreraAtanacioTzul");
		if (!$this->connection){
			printf("Error %s\n",$this->connection->error);
			$this->connection->close();
			return false;			
		}
		else
			return true;
	}
}

/**
* Clase Empleado
*/
class Persona extends Conexion
{
	public $data;
	public $response = false;
	function __construct($data)
	{
		$this->data = $data;
	}
	public function save(){	
		$name = $this->data['nombre_Personal'];
		$dpi = $this->data['dpi_Personal'];
		$dir = $this->data['direccion'];
		$tel = $this->data['telefono'];
		$pin = $this->data['pin'];
		$query = "INSERT into personal(nombre_Personal,dpi_Personal,direccion, telefono, pin, status) values ('$name','$dpi','$dir','$tel','$pin','false')";
		parent:: __construct();
		if($this->connection->query($query)){
			$this->connection->close();
			return true;
		}
		else{
			$this->connection->close();
			return $dataInsert;
		}
	}
	public function verifiCode(){
		$pin = $this->data['pinIngreso'];
		$query = "SELECT * from personal where pin = '$pin'";
		parent:: __construct();
		if($persona = $this->connection->query($query)){
			$this->connection->close();
			if ($persona->num_rows > 0) {
				$user = array();
				foreach ($persona->fetch_assoc() as $key => $value) {
					$user[$key] = $value;
				}
				$idPersona = $user['id_Personal'];
				$fecha_hora_actual = date('Y-m-d H:i:s');
				$query = "INSERT into registrohorario(id_Personal, fecha_y_hora) values ($idPersona, '$fecha_hora_actual')";	
				parent:: __construct();
				if ($this->connection->query($query)) {
					$this->connection->close();
					return true;
				}else{
					$this->connection->close();
					return false;
				}
			}else{
				return false;
			}
		}
		else{
			$this->connection->close();
			return false;
		}
	}
	public function getRegisterTimer(){
		$idPersona = $this->data['id_Personal'];
		$query = "SELECT * from registrohorario where id_Personal = $idPersona group by fecha_y_hora";
		parent:: __construct();
		if($usuario = $this->connection->query($query)){
			$this->connection->close();
			$registros = array();
			while($personal = $usuario->fetch_assoc()){
				$registro = array();
				foreach ($personal as $key => $value) {
					$registro[$key] = $value;
				}
				array_push($registros, $registro);
			}
			return $registros;

		}
		else
			return false;
	} 
	public function getStatusPersona(){
		$idPersona = $this->data['id_Personal'];
		$query = "SELECT status from personal where id_Personal = $idPersona";
		parent:: __construct();
		if($usuario = $this->connection->query($query)){
			$this->connection->close();
			$registro = array();
			foreach ($usuario->fetch_assoc() as $key => $value) {
				$registro[$key] = $value;
			}
			return $registro;
		}
		else
			return false;
	} 
	public function updateStatus(){
		$idPersona = $this->data['id_Personal'];
		$monto = (float)$this->data['monto'];
		$passAsistente = $this->data['pass'];
		$query = "SELECT * from asistente where password = $passAsistente";
		parent:: __construct();
		if($asistente = $this->connection->query($query)){
			if ($asistente->num_rows > 0) {
				$this->connection->close();
				$registro = array();
				foreach ($asistente->fetch_assoc() as $key => $value) {
					$registro[$key] = $value;
				}
				$fecha_hora_actual = date('Y-m-d H:i:s');
				$idAsis = $registro['id_asistente'];
				$query = "INSERT into multa(monto, fecha_y_hora, id_personal, id_asistente) values($monto,'$fecha_hora_actual',$idPersona, $idAsis)";
				parent:: __construct();
				if ($this->connection->query($query)) {
					$query = "UPDATE personal SET status = 'true' where id_Personal = $idPersona";
					if ($this->connection->query($query)) {
						parent:: __construct();
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
			$this->connection->close();
			return true;
		}
		else
			return false;
	} 
}

/**
* Clase Usuario
*/
class Asistente extends Conexion
{
	
	function __construct()
	{
		# code...
	}
	public function getPersonal(){
		$query = "select * from personal where pin <> ''";
		$ConexionUsuario = parent:: __construct();
		$this->connection->query("SET CHARACTER SET utf8");
		if($usuario = $this->connection->query($query)){
			$this->connection->close();
			$usuarioA = array();
			while($personal = $usuario->fetch_assoc()){
				$persona = array();
				foreach ($personal as $key => $value) {
					$persona[$key] = $value;
				}
				array_push($usuarioA, $persona);
			}
			return $usuarioA;

		}
		else
			return false;
	} 
	public function getReportMoney(){
		$query = "SELECT P.nombre_Personal, M.monto, M.fecha_y_hora from personal P inner join multa M on P.id_Personal = M.id_personal";
		parent:: __construct();
		$this->connection->query("SET CHARACTER SET utf8");
		if($usuario = $this->connection->query($query)){
			$this->connection->close();
			$usuarioA = array();
			while($personal = $usuario->fetch_assoc()){
				$persona = array();
				foreach ($personal as $key => $value) {
					$persona[$key] = $value;
				}
				array_push($usuarioA, $persona);
			}
			return $usuarioA;

		}
		else
			return false;
	}
}


	/**
	*		init model system carrera
	*/
/**
* 		Class Atleta
*/
class Atleta extends Conexion
{	
	function __construct()
	{
		
	}
	public function getAtletas(){
		$query = "SELECT * from Atletas";
		parent:: __construct();
		if($atletasTemp = $this->connection->query($query)){
			$this->connection->close();
			$atletas = array();
			while($atletaTemp = $atletasTemp->fetch_assoc()){
				$atleta = array();
				foreach ($atletaTemp as $key => $value) {
					$atleta[$key] = $value;
				}
				array_push($atletas, $atleta);
			}
			return $atletas;
		}
		else
			return false;
	}
}

?>