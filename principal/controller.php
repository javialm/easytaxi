<?php
require_once('constants.php');
require_once('view.php');
function handler() {
	$event = "";
	//$uri = $_SERVER['REQUEST_URI']; //es la url que estamos ejecutando relativa a la raiz del dominio
	//echo $uri."<br>";
	//$peticiones = array(VIEW_USER, VIEW_PRODUCT);
	//foreach ($peticiones as $peticion) {
		//$uri_peticion = MODULO.$peticion.'/';
		//echo $uri_peticion."<br>";
		/*if( strpos($uri, $uri_peticion) == true ) {
			$event = $peticion;
		}
	}
	echo "event=".$event."<br>";*/
	retornar_vista($event);
}

handler();
?>