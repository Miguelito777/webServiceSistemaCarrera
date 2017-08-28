<?php
	include 'modeloM.php';
	session_start();

	if (isset($_GET["obtenerDatos"])) {
		$nombre = $_SESSION["digitadorActivo"]->obtenerDatos();
		echo $nombre;	
	}

	// Obtengo los atletas de un digitador y los guardo en un array inicial
	if (isset($_GET["getAtletasLF"])) {
		$_SESSION["digitadorActivo"]->getAtletasLF();
		$atletasDLF = $_SESSION["digitadorActivo"]->getAtletasDLF();
		echo json_encode($atletasDLF);
	}

	if (isset($_GET["getAtletasLM"])) {
		$_SESSION["digitadorActivo"]->getAtletasLM();
		$atletasDLM = $_SESSION["digitadorActivo"]->getAtletasDLM();
		echo json_encode($atletasDLM);
	}

	if (isset($_GET["getAtletasMM"])) {
		$_SESSION["digitadorActivo"]->getAtletasMM();
		$atletasDMM = $_SESSION["digitadorActivo"]->getAtletasDMM();
		echo json_encode($atletasDMM);
	}

	if (isset($_GET["getAtletasE"])) {
		$_SESSION["digitadorActivo"]->getAtletasE();
		$atletasE = $_SESSION["digitadorActivo"]->getAtletaDE();
		echo json_encode($atletasE);
	}


	

	if (isset($_POST["usuario"]) && isset($_POST["password"])) {
		$usuario = new Login($_POST["usuario"], $_POST["password"]);

		$tipoUsuario = $usuario->verificarUser();
		if ($tipoUsuario == 2)
			echo 2;
		else if ($tipoUsuario == 1)
			echo 1;
		else
			echo 0;

	}

	if (isset($_POST['atletaLF']) ) {
		$atleta = json_decode($_POST['atletaLF'],true);

		$inscripcionLF = $_SESSION["digitadorActivo"]->inscribirAtletaLF($atleta);
		if ($inscripcionLF) 
			echo json_encode($inscripcionLF);
		else
			echo "Error al obtener los datos de la inscripcion Libre Femenino";
	}

	if (isset($_POST['atletaLM']) ) {
		$atleta = json_decode($_POST['atletaLM'],true);

		$inscripcionLM = $_SESSION["digitadorActivo"]->inscribirAtletaLM($atleta);
		if ($inscripcionLM) 
			echo json_encode($inscripcionLM);
		else
			echo "Error al obtener los datos de la inscripcion Libre Masculino";
	}
	if (isset($_POST['atletaE']) ) {
		$atleta = json_decode($_POST['atletaE'],true);

		$inscripcionE = $_SESSION["digitadorActivo"]->inscribirAtletaE($atleta);
		if ($inscripcionE) 
			echo json_encode($inscripcionE);
		else
			echo "Error al obtener los datos de la inscripcion Elite";
	}

	if (isset($_POST['atletaMM']) ) {
		$atleta = json_decode($_POST['atletaMM'],true);

		$inscripcionMM = $_SESSION["digitadorActivo"]->inscribirAtletaMM($atleta);
		if ($inscripcionMM) 
			echo json_encode($inscripcionMM);
		else
			echo "Error al obtener los datos de la inscripcion Master Masculino";
	}

	if (isset($_POST['coincidenciaDpi'])) {
		if (isset($_SESSION["colaboradorActivo"])) {
			$_SESSION["colaboradorActivo"]->getAtletasCoincidencia($_POST['coincidenciaDpi']);
			$atletasCoincidencia = $_SESSION["colaboradorActivo"]->getAtletasCoincidenciaA();
			echo json_encode($atletasCoincidencia);
		}
	}
	if (isset($_POST['coincidenciaDpiIEPA'])) {
		if (isset($_SESSION["colaboradorActivo"])) {
			$_SESSION["colaboradorActivo"]->setInsumosAtletasCoincidencia($_POST['coincidenciaDpiIEPA']);
			$atletasCoincidencia = $_SESSION["colaboradorActivo"]->getAtletasCoincidenciaA();
			echo json_encode($atletasCoincidencia);
		}
	}

?>