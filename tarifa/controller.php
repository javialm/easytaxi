<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler() {
	$event = VIEW_GET_RATE;
	$uri = $_SERVER['REQUEST_URI']; //es la url que estamos ejecutando relativa a la raiz del dominio
	//echo $uri."<br>";
	$peticiones = array(SET_RATE, GET_RATE, DELETE_RATE, EDIT_RATE, LIST_RATE,//list rate
	VIEW_SET_RATE, VIEW_GET_RATE, VIEW_DELETE_RATE,
	VIEW_EDIT_RATE);
	foreach ($peticiones as $peticion) {
		$uri_peticion = MODULO.$peticion.'/';
		//echo $uri_peticion."<br>";
		if( strpos($uri, $uri_peticion) == true ) {
			$event = $peticion;
		}
	}
	//echo "event=".$event."<br>";
	$rate_data = helper_RATE_data();
	$tarifa = set_obj();

	switch ($event) {
		case SET_RATE: //valor de la constante SET_RATE es set
			$tarifa->set($rate_data);
			$data = array('mensaje'=>$tarifa->mensaje);
			retornar_vista(VIEW_SET_RATE, $data);
			break;
		case GET_RATE: //valor de la constante GET_RATE es get
			$tarifa->get($rate_data['id_rate']);
			$data = array(
			'id_rate'=>$tarifa->id_rate,
			'classname'=>$tarifa->classname,
			'price_km'=>$tarifa->price_km,
			'mensaje'=>$tarifa->mensaje
			);
			retornar_vista(VIEW_EDIT_RATE, $data);
			break;
		case DELETE_RATE: //valor de la constante DELETE_RATE es delete
			$tarifa->delete($rate_data['id_rate']);
			$data = array('mensaje'=>$tarifa->mensaje);
			retornar_vista(VIEW_DELETE_RATE, $data);
			break;
		case EDIT_RATE: //valor de la constante EDIT_RATE es edit
			$tarifa->edit($rate_data);
			$data = array('mensaje'=>$tarifa->mensaje);
			retornar_vista(VIEW_GET_RATE, $data);
			break;
		case LIST_RATE: //valor de la constante LIST_RATE es list
			$tarifa->listing($rate_data); //enviamos rate_data recogidos al método del modelo
			break;
		default:
			retornar_vista($event);
	}
}
function set_obj() {
	$obj = new tarifa();
return $obj;
}
function helper_RATE_data() {
	$rate_data = array();
	if($_POST) {
		if(array_key_exists('id_rate', $_POST)) {
			$rate_data['id_rate'] = $_POST['id_rate'];
		}
		if(array_key_exists('classname', $_POST)) {
			$rate_data['classname'] = $_POST['classname'];
		}
		if(array_key_exists('price_km', $_POST)) {
			$rate_data['price_km'] = $_POST['price_km'];
		}
	} else if($_GET) {
		if(array_key_exists('id_rate', $_GET)) {
			$rate_data = $_GET['id_rate'];
		}
	}
	return $rate_data;
}
handler();
?>
