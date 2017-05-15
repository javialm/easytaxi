<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler() {
	$event = VIEW_GET_VEHICLE;
	$uri = $_SERVER['REQUEST_URI']; //es la url que estamos ejecutando relativa a la raiz del dominio
	//echo $uri."<br>";
	$peticiones = array(SET_VEHICLE, GET_VEHICLE, DELETE_VEHICLE, EDIT_VEHICLE, LIST_VEHICLE,//list vehicle
	VIEW_SET_VEHICLE, VIEW_GET_VEHICLE, VIEW_DELETE_VEHICLE,
	VIEW_EDIT_VEHICLE);
	foreach ($peticiones as $peticion) {
		$uri_peticion = MODULO.$peticion.'/';
		//echo $uri_peticion."<br>";
		if( strpos($uri, $uri_peticion) == true ) {
			$event = $peticion;
		}
	}
	//echo "event=".$event."<br>";
	$vehicle_data = helper_VEHICLE_data();
	$vehiculo = set_obj();

	switch ($event) {
		case SET_VEHICLE: //valor de la constante SET_VEHICLE es set
			$vehiculo->set($vehicle_data);
			$data = array('mensaje'=>$vehiculo->mensaje);
			retornar_vista(VIEW_SET_VEHICLE, $data);
			break;
		case GET_VEHICLE: //valor de la constante GET_VEHICLE es get
			$vehiculo->get($vehicle_data['id_vehicle']);
			$data = array(
			'id_vehicle'=>$vehiculo->id_vehicle,
			'class'=>$vehiculo->class,
			'brand'=>$vehiculo->brand,
			'model'=>$vehiculo->model,
			'year'=>$vehiculo->year,
			'km'=>$vehiculo->km,
			'mensaje'=>$vehiculo->mensaje
			);
			retornar_vista(VIEW_EDIT_VEHICLE, $data);
			break;
		case DELETE_VEHICLE: //valor de la constante DELETE_VEHICLE es delete
			$vehiculo->delete($vehicle_data['id_vehicle']);
			$data = array('mensaje'=>$vehiculo->mensaje);
			retornar_vista(VIEW_DELETE_VEHICLE, $data);
			break;
		case EDIT_VEHICLE: //valor de la constante EDIT_VEHICLE es edit
			$vehiculo->edit($vehicle_data);
			$data = array('mensaje'=>$vehiculo->mensaje);
			retornar_vista(VIEW_GET_VEHICLE, $data);
			break;
		case LIST_VEHICLE: //valor de la constante LIST_VEHICLE es list
			$vehiculo->listing($vehicle_data); //enviamos vehicle_data recogidos al método del modelo
			break;
		default:
			retornar_vista($event);
	}
}
function set_obj() {
	$obj = new vehiculo();
return $obj;
}
function helper_VEHICLE_data() {
	$vehicle_data = array();
	if($_POST) {
		if(array_key_exists('id_vehicle', $_POST)) {
			$vehicle_data['id_vehicle'] = $_POST['id_vehicle'];
		}
		if(array_key_exists('class', $_POST)) {
			$vehicle_data['class'] = $_POST['class'];
		}
		if(array_key_exists('brand', $_POST)) {
			$vehicle_data['brand'] = $_POST['brand'];
		}
		if(array_key_exists('model', $_POST)) {
			$vehicle_data['model'] = $_POST['model'];
		}
		if(array_key_exists('year', $_POST)) {
			$vehicle_data['year'] = $_POST['year'];
		}
		if(array_key_exists('km', $_POST)) {
			$vehicle_data['km'] = $_POST['km'];
		}
		if(array_key_exists('km', $_POST)) {
			$vehicle_data['km2'] = $_POST['km2'];
		}else{
			$vehicle_data['km2'] = "";
		}
	} else if($_GET) {
		if(array_key_exists('id_vehicle', $_GET)) {
			$vehicle_data = $_GET['id_vehicle'];
		}
	}
	return $vehicle_data;
}
handler();
?>
