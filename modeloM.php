<?php

/**
* Conexion
*/
class Conexion
{
	public $enlace;

	function __construct()
	{
		$this->enlace = new mysqli("localhost", "root", "Jesus8", "carreraAtanacioTzul");
		if (!$this->enlace)
			echo "Error al conectar a la base de datos";
	}
}
/**
* Clase login
*/
class Login extends Conexion
{
	private $usuario;
	private $password;

	function __construct($usuario, $password)
	{
		$this->usuario = $usuario;
		$this->password = $password;
	}
	public function verificarUser(){
		$query = "call verificaDigitador('$this->usuario','$this->password')";
		parent:: __construct();
		if ($usuarioDigitador = $this->enlace->query($query)) {
			$this->enlace->close();
			$usuariosObtenidos = $usuarioDigitador;
			$numero = $usuariosObtenidos->num_rows;
			if ($numero > 0){
				$datosDigitador = $usuarioDigitador->fetch_assoc();
				$idD = $datosDigitador['idUsuario'];
				$nombreD = $datosDigitador['nombre'];
				$_SESSION["digitadorActivo"] = new Digitador($idD, $nombreD);
				return 2; 
			}
			else{
				$query = "call verificaAdmin('$this->usuario','$this->password')";
				parent:: __construct();
				if ($uduarioAdmin = $this->enlace->query($query)) {
					$this->enlace->close();
					$usuariosObtenidos = $uduarioAdmin;
					$numero = $usuariosObtenidos->num_rows;
					if ($numero > 0){
						$datosColaborador = $uduarioAdmin->fetch_assoc();
						$idD = $datosColaborador['idUsuario'];
						$nombreD = $datosColaborador['nombre'];
						$_SESSION["colaboradorActivo"] = new Colaborador($idD, $nombreD);
						return 1;
					}
					else
						return 0;
				}
			}
		}
	}
	public function verificarAdmin(){

	} 
}

	
/**
* Clase Usuario
*/
class Digitador extends Conexion
{	
	public $id;
	public $nombre;
	private $atletas = array();
	private $atletasLF = array();
	private $atletasLM = array();
	private $atletasMM = array();
	private $atletasE = array();

	function __construct($id, $nombre)
	{
		$this->id = $id;
		$this->nombre = $nombre;
	}

	public function idDigitador(){
		return $this->id;
	}

	public function getAtletasDLF(){
		return $this->atletasLF;
	}

	public function getAtletasDLM(){
		return $this->atletasLM;
	}

	public function getAtletasDMM(){
		return $this->atletasMM;
	}
	public function getAtletaDE(){
		return $this->atletasE;
	}

	public function obtenerDatos(){
		return $this->nombre;
	}

	public function getAtletasLF(){
		$this->atletasLF = array();
		$query = "call getAtletasDLF($this->id)";
		parent:: __construct();
		if ($atletasDLF = $this->enlace->query($query)) {
			while($atletaLF = $atletasDLF->fetch_assoc()){
				$atletaLFA = array();
				foreach ($atletaLF as $key => $value) {
					$atletaLFA[$key] = $value;
				}
				array_push($this->atletasLF, $atletaLFA);
			}
		}
	}

	public function getAtletasLM(){
		$this->atletasLM = array();
		$query = "call getAtletasDLM($this->id)";
		parent:: __construct();
		if ($atletasDLM = $this->enlace->query($query)) {
			while($atletaLM = $atletasDLM->fetch_assoc()){
				$atletaLMA = array();
				foreach ($atletaLM as $key => $value) {
					$atletaLMA[$key] = $value;
				}
				array_push($this->atletasLM, $atletaLMA);
			}
		}
	}
	public function getAtletasMM(){
		$this->atletasMM = array();
		$query = "call getAtletasDMM($this->id)";
		parent:: __construct();
		if ($atletasDMM = $this->enlace->query($query)) {
			while($atletaMM = $atletasDMM->fetch_assoc()){
				$atletaMMA = array();
				foreach ($atletaMM as $key => $value) {
					$atletaMMA[$key] = $value;
				}
				array_push($this->atletasMM, $atletaMMA);
			}
		}
	}
	public function getAtletasE(){
		$this->atletasE = array();
		$query = "call getAtletasE($this->id)";
		parent:: __construct();
		if ($atletasE = $this->enlace->query($query)) {
			while($atletE = $atletasE->fetch_assoc()){
				$atletaEA = array();
				foreach ($atletE as $key => $value) {
					$atletaEA[$key] = $value;
				}
				array_push($this->atletasE, $atletaEA);
			}
		}
	}

	public function inscribirAtletaLF($atleta){
		$nombre = $atleta['nombre'];
		$dpi = $atleta['dpi'];
		$direccion = $atleta['direccion'];
		$genero = $atleta['genero'];
		$cme = '0';
		$usuario = $_SESSION['digitadorActivo']->idDigitador();
		$fechaNacimiento = $atleta['anioNacimiento'].'-'.$atleta['mesNacimiento'].'-'.$atleta['diaNacimiento'];
		$query = "call createAtleta('$nombre', '$fechaNacimiento', '$direccion', '$cme', $usuario, '$dpi', '$genero')";
		parent:: __construct();
		if($inscribirAtleta = $this->enlace->query($query)){
			$this->enlace->close();
			$atletaInscritoA = array();
			$atletaInscrito = $inscribirAtleta->fetch_assoc();
			$atletaInscritoA['idAtleta'] = $atletaInscrito['idAtletas'];
			$atletaInscritoA['nombre'] = $atletaInscrito['nombre'];
			$atletaInscritoA['dpi'] = $atletaInscrito['dpi'];
			$atletaInscritoA['procedencia'] = $atletaInscrito['procedencia'];
			$atletaInscritoA['genero'] = $atletaInscrito['genero'];
			$atletaInscritoA['idNumerosLF'] = $atletaInscrito['idNumerosLF'];
			array_push($this->atletasLF, $atletaInscritoA);
			return $atletaInscritoA;
			
		}
		else{
			printf("Error %s\n",$this->enlace->error);
			$this->enlace->close();
			return false;			
		}
	}
	public function inscribirAtletaLM($atleta){
		$nombre = $atleta['nombre'];
		$dpi = $atleta['dpi'];
		$direccion = $atleta['direccion'];
		$genero = $atleta['genero'];
		$cme = '0';
		$usuario = $_SESSION['digitadorActivo']->idDigitador();
		$fechaNacimiento = $atleta['anioNacimiento'].'-'.$atleta['mesNacimiento'].'-'.$atleta['diaNacimiento'];
		$query = "call createAtletaLM('$nombre', '$fechaNacimiento', '$direccion', '$cme', $usuario, '$dpi', '$genero')";
		parent:: __construct();
		if($inscribirAtleta = $this->enlace->query($query)){
			$this->enlace->close();
			$atletaInscritoA = array();
			$atletaInscrito = $inscribirAtleta->fetch_assoc();
			$atletaInscritoA['idAtleta'] = $atletaInscrito['idAtletas'];
			$atletaInscritoA['nombre'] = $atletaInscrito['nombre'];
			$atletaInscritoA['dpi'] = $atletaInscrito['dpi'];
			$atletaInscritoA['procedencia'] = $atletaInscrito['procedencia'];
			$atletaInscritoA['genero'] = $atletaInscrito['genero'];
			$atletaInscritoA['idNumerosLF'] = $atletaInscrito['idNumerosLM'];
			array_push($this->atletasLM, $atletaInscritoA);
			return $atletaInscritoA;
		}
		else{
			printf("Error %s\n",$this->enlace->error);
			$this->enlace->close();
			return false;			
		}
	}
	public function inscribirAtletaE($atleta){
		$nombre = $atleta['nombre'];
		$dpi = $atleta['dpi'];
		$direccion = $atleta['direccion'];
		$genero = $atleta['genero'];
		$cme = '0';
		$usuario = $_SESSION['digitadorActivo']->idDigitador();
		$fechaNacimiento = $atleta['anioNacimiento'].'-'.$atleta['mesNacimiento'].'-'.$atleta['diaNacimiento'];
		$query = "call createAtletaE('$nombre', '$fechaNacimiento', '$direccion', '$cme', $usuario, '$dpi', '$genero')";
		parent:: __construct();
		if($inscribirAtleta = $this->enlace->query($query)){
			$this->enlace->close();
			$atletaInscritoA = array();
			$atletaInscrito = $inscribirAtleta->fetch_assoc();
			$atletaInscritoA['idAtleta'] = $atletaInscrito['idAtletas'];
			$atletaInscritoA['nombre'] = $atletaInscrito['nombre'];
			$atletaInscritoA['dpi'] = $atletaInscrito['dpi'];
			$atletaInscritoA['procedencia'] = $atletaInscrito['procedencia'];
			$atletaInscritoA['genero'] = $atletaInscrito['genero'];
			$atletaInscritoA['idNumerosLF'] = $atletaInscrito['idElite'];
			array_push($this->atletasE, $atletaInscritoA);
			return $atletaInscritoA;
		}
		else{
			printf("Error %s\n",$this->enlace->error);
			$this->enlace->close();
			return false;			
		}
	}
	public function inscribirAtletaMM($atleta){
		$nombre = $atleta['nombre'];
		$dpi = $atleta['dpi'];
		$direccion = $atleta['direccion'];
		$genero = $atleta['genero'];
		$cme = '0';
		$usuario = $_SESSION['digitadorActivo']->idDigitador();
		$fechaNacimiento = $atleta['anioNacimiento'].'-'.$atleta['mesNacimiento'].'-'.$atleta['diaNacimiento'];
		$query = "call createAtletaMM('$nombre', '$fechaNacimiento', '$direccion', '$cme', $usuario, '$dpi', '$genero')";
		parent:: __construct();
		if($inscribirAtleta = $this->enlace->query($query)){
			$this->enlace->close();
			$atletaInscritoA = array();
			$atletaInscrito = $inscribirAtleta->fetch_assoc();
			$atletaInscritoA['idAtleta'] = $atletaInscrito['idAtletas'];
			$atletaInscritoA['nombre'] = $atletaInscrito['nombre'];
			$atletaInscritoA['dpi'] = $atletaInscrito['dpi'];
			$atletaInscritoA['direccion'] = $atletaInscrito['procedencia'];
			$atletaInscritoA['genero'] = $atletaInscrito['genero'];
			$atletaInscritoA['numeroAsignado'] = $atletaInscrito['idNumerosMM'];
			array_push($this->atletasMM, $atletaInscritoA);
			return $atletaInscritoA;
		}
		else{
			printf("Error %s\n",$this->enlace->error);
			$this->enlace->close();
			return false;			
		}
	}
}

/**
* Clase Digitador
*/
class Colaborador extends Conexion
{	
	public $id;
	public $nombre;
	private $atletasCoincidencia = array();

	function __construct($id, $nombre)
	{
		$this->id = $id;
		$this->nombre = $nombre;
	}

	public function getAtletasCoincidenciaA(){
		return $this->atletasCoincidencia;
	}

	public function getAtletasCoincidencia($str){
		$this->atletasCoincidencia = array();
		$query = "SELECT A.idAtletas, A.dpi, A.nombre, A.procedencia, I.numeroAsignado, I.playeraEntregada from Atletas A inner join Inscripcion I on A.idAtletas = I.Atletas_idAtletas and A.dpi like '%$str%'";
		parent:: __construct();
		if ($atletasDpiCoincidencia = $this->enlace->query($query)) {
			$this->enlace->close();
			while($atletaDpiCoincidencia = $atletasDpiCoincidencia->fetch_assoc()){
				$atletaDpiCoincidenciaA = array();
				foreach ($atletaDpiCoincidencia as $key => $value) {
					$atletaDpiCoincidenciaA[$key] = $value;
				}
				array_push($this->atletasCoincidencia, $atletaDpiCoincidenciaA);
			}
		}
	}
	public function setInsumosAtletasCoincidencia($posicionAtleta){
		$idAtleta = (int)$this->atletasCoincidencia[$posicionAtleta]['idAtletas'];
		$query = "call setImplementosAtletas($idAtleta)";
		parent:: __construct();
		if ($atletaDpiCoincidencia = $this->enlace->query($query)) {
			$this->enlace->close();
			$atletaDpiCoincidenciaUpdate = $atletaDpiCoincidencia->fetch_assoc();
			$atletaDpiCoincidenciaAUpdate = array();
			foreach ($atletaDpiCoincidenciaUpdate as $key => $value) {
				$atletaDpiCoincidenciaAUpdate[$key] = $value;
			}
			$this->atletasCoincidencia[$posicionAtleta] = $atletaDpiCoincidenciaAUpdate;
		}
		else{
			printf("Error %s\n",$this->enlace->error);
			$this->enlace->close();
			return false;			
		}
	}
}

?>