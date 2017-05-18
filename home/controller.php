<?php
session_start();
require('fpdf.php');//Libreria PDF
require_once('constants.php');
require_once('view.php');
require_once('model.php');
function handler() {
$event = VIEW_GET_HOME;
	$uri = $_SERVER['REQUEST_URI']; //es la url que estamos ejecutando relativa a la raiz del dominio
	//echo $uri."<br>";
	$peticiones = array(GET_HOME, CLASSPRICE_HOME, GET_USER_HOME, SET_ACCOUNT_HOME, LOGOUT_HOME, TICKET_HOME, 
	VIEW_GET_HOME, VIEW_LOGIN_HOME, VIEW_ACCOUNT_HOME, VIEW_LOGOUT_HOME);
	foreach ($peticiones as $peticion) {
		$uri_peticion = MODULO.$peticion.'/';
		//echo $uri_peticion."<br>";
		if( strpos($uri, $uri_peticion) == true ) {
			$event = $peticion;
		}
	}
$path_data = helper_PATH_data();
	$path = set_obj();

	switch ($event) {
		
		case GET_HOME: //Redirección a la pagina principal
			retornar_vista(VIEW_GET_HOME);
			break;
		case CLASSPRICE_HOME: //Se actualiza el formulario de la pagina principal.
			$path->show_price($path_data);
			break;
		case GET_USER_HOME:
			$path->login($path_data);
			break;
		case LOGOUT_HOME: //
			session_destroy();
			header("location: ../home/controller.php");
			//retornar_vista(VIEW_GET_HOME);
			break;
		case SET_ACCOUNT_HOME:
			$path->createUser($path_data);
			break;
		case TICKET_HOME: //TICKET
		$path->get($path_data['class']);

		class PDF extends FPDF
		{
		// Cabecera de página
		function Header()
		{
			// Logo
			$this->Image('../site_media/img/EzTaxi.png',10,8,33);
			// Arial bold 15
			$this->SetFont('Arial','B',15);
			// Movernos a la derecha
			$this->Cell(80);
			// Título
			$this->Cell(40,10,'Ticket de viaje',1,0,'C');
			// Salto de línea
			$this->Ln(20);
		}

		// Pie de página
		function Footer()
		{
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
		}
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0.1,10,'Fecha de emision: '.date('d-m-y h:i A'));
		$pdf->Cell(0.1,0.01,'Hora de salida: '.date('d-m-y h:i A', time()+14000));
		$pdf->Cell(0.1,30,'Usuario: '.$path_data['email']);
		$pdf->Cell(0.1,50,'Clase: '.$path->classname);
		$pdf->Cell(0.1,70,'Precio km: '.$path->price_km);
		$pdf->Cell(0.1,90,'Precio Total: '.$path_data['total_amount'].' Euros');
		
		$pdf->Output();
			break;
		default:
			retornar_vista($event);
	}
}
function set_obj() {
	$obj = new Path();
return $obj;
}
function helper_PATH_data() { //DATA SENT FROM THE FORMS
	$path_data = array();
	if($_POST) {
		if(array_key_exists('class', $_POST)) {
			$path_data['class'] = $_POST['class'];
		}
		if(array_key_exists('total_amount', $_POST)) {
			$path_data['total_amount'] = $_POST['total_amount'];
		}
		if(array_key_exists('username', $_POST)) {
			$path_data['username'] = $_POST['username'];
		}
		if(array_key_exists('email', $_POST)) {
			$path_data['email'] = $_POST['email'];
		}
		if(array_key_exists('pass', $_POST)) {
			$path_data['pass'] = $_POST['pass'];
		}
	} else if($_GET) {
		if(array_key_exists('id_vehicle', $_GET)) {
			$path_data = $_GET['id_vehicle'];
		}
	}
	return $path_data;
}
handler();
?>
