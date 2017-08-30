<?php
	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE');
	date_default_timezone_set('America/Guatemala');
	include 'modelo.php';
	session_start();
	
	/*if (!isset($_SESSION['connection'])) {
		$_SESSION['connection'] = new mysqli("localhost","root", "Jesus8", "control_biometrico");
	}
	if (!isset($_SESSION["ASISTENTE"])) {
		$_SESSION["PERSONAL"] = new Asistente();
	}*/


	/*if ($_GET["solicitud"] == "personal") {
		$usuarios = $_SESSION["PERSONAL"]->getPersonal();	
		echo json_encode($usuarios);
	}

	if ($_GET["solicitud"] == "newEmploye") {
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		$_SESSION['persona'] = new Persona($data);
		if ($_SESSION['persona']->save()) {
			$response = "Excelente";
			echo json_encode($response);
		}else{
			$response = "Error";
			echo json_encode($response);
		}
	}
	if ($_GET["solicitud"] == "setHorario") {
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		$_SESSION['persona'] = new Persona($data);
		if($response = $_SESSION['persona']->verifiCode()){
			echo json_encode($response);
		}else{
			echo json_encode($response);
		}
	}
	if ($_GET["solicitud"] == "getRegistroHorario") {
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		$_SESSION['persona'] = new Persona($data);
		if($response = $_SESSION['persona']->getRegisterTimer()){
			echo json_encode($response);
		}else{
			echo json_encode($response);
		}
	}
	if ($_GET["solicitud"] == "getStatusPersona") {
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		$_SESSION['persona'] = new Persona($data);
		if($response = $_SESSION['persona']->getStatusPersona()){
			echo json_encode($response);
		}else{
			echo json_encode($response);
		}
	}
	if ($_GET["solicitud"] == "updateStatus") {
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		$_SESSION['persona'] = new Persona($data);
		if($response = $_SESSION['persona']->updateStatus()){
			echo json_encode($response);
		}else{
			echo json_encode($response);
		}
	}
	if ($_GET["solicitud"] == "getRegistroMoney") {
		$_SESSION["PERSONAL"] = new Asistente();
		$usuarios = $_SESSION["PERSONAL"]->getReportMoney();	
		echo json_encode($usuarios);
	}*/
	


	/**
	*		init controller system carrera
	*/

	if ($_GET["solicitud"] == "getAtletas") {
		$_SESSION["Atleta"] = new Atleta();
		$atletas = $_SESSION["Atleta"]->getAtletas();	
		echo json_encode($atletas);
	}
	/*if ($_GET["solicitud"] == "newEmploye") {
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		$_SESSION['persona'] = new Persona($data);
		if ($_SESSION['persona']->save()) {
			$response = "Excelente";
			echo json_encode($response);
		}else{
			$response = "Error";
			echo json_encode($response);
		}
	}*/


?>