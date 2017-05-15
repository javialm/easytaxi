<?php
require_once('constants.php');
require_once('view.php');
function handler() {
$event = VIEW_GET_HOME;
	$uri = $_SERVER['REQUEST_URI']; //es la url que estamos ejecutando relativa a la raiz del dominio
	//echo $uri."<br>";
	$peticiones = array(GET_HOME, VIEW_GET_HOME);
	foreach ($peticiones as $peticion) {
		$uri_peticion = MODULO.$peticion.'/';
		//echo $uri_peticion."<br>";
		if( strpos($uri, $uri_peticion) == true ) {
			$event = $peticion;
		}
	}

	switch ($event) {
		
		case GET_HOME: //valor de la constante GET_USER es get
			retornar_vista(VIEW_GET_HOME);
			break;
		default:
			retornar_vista($event);
	}
}
handler();
?>
