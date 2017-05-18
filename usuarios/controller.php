<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler() {
	$event = VIEW_GET_USER;
	$uri = $_SERVER['REQUEST_URI']; //es la url que estamos ejecutando relativa a la raiz del dominio
	//echo $uri."<br>";
	$peticiones = array(SET_USER, GET_USER, DELETE_USER, EDIT_USER, LIST_USER,//list vehicle
	VIEW_SET_USER, VIEW_GET_USER, VIEW_DELETE_USER,
	VIEW_EDIT_USER);
	foreach ($peticiones as $peticion) {
		$uri_peticion = MODULO.$peticion.'/';
		//echo $uri_peticion."<br>";
		if( strpos($uri, $uri_peticion) == true ) {
			$event = $peticion;
		}
	}
	//echo "event=".$event."<br>";
	$user_data = helper_USER_data();
	$user = set_obj();

	switch ($event) {
		case SET_USER: //valor de la constante SET_USER es set
			$user->set($user_data);
			$data = array('mensaje'=>$user->mensaje);
			retornar_vista(VIEW_SET_USER, $data);
			break;
		case GET_USER: //valor de la constante GET_USER es get
			$user->get($user_data['id_user']);
			$data = array(
			'id_user'=>$user->id_user,
			'username'=>$user->username,
			'email'=>$user->email,
			'pass'=>$user->pass,
			'level'=>$user->level,
			'mensaje'=>$user->mensaje
			);
			retornar_vista(VIEW_EDIT_USER, $data);
			break;
		case DELETE_USER: //valor de la constante DELETE_USER es delete
			$user->delete($user_data['$id_user']);
			$data = array('mensaje'=>$user->mensaje);
			retornar_vista(VIEW_DELETE_USER, $data);
			break;
		case EDIT_USER: //valor de la constante EDIT_USER es edit
			$user->edit($user_data);
			$data = array('mensaje'=>$user->mensaje);
			retornar_vista(VIEW_GET_USER, $data);
			break;
		case LIST_USER: //valor de la constante LIST_USER es list
			$user->listing($user_data); //enviamos vehicle_data recogidos al método del modelo
			//var_dump($user_data);
			break;
		default:
			retornar_vista($event);
	}
}
function set_obj() {
	$obj = new Usuario();
return $obj;
}
function helper_USER_data() {
	$user_data = array();
	if($_POST) {
		if(array_key_exists('id_user', $_POST)) {
			$user_data['id_user'] = $_POST['id_user'];
		}
		if(array_key_exists('username', $_POST)) {
			$user_data['username'] = $_POST['username'];
		}
		if(array_key_exists('email', $_POST)) {
			$user_data['email'] = $_POST['email'];
		}
		if(array_key_exists('pass', $_POST)) {
			$user_data['pass'] = $_POST['pass'];
		}
		if(array_key_exists('level', $_POST)) {
			$user_data['level'] = $_POST['level'];
		}
	} else if($_GET) {
		if(array_key_exists('id_user', $_GET)) {
			$user_data = $_GET['id_user'];
		}
	}
	return $user_data;
}
handler();
?>
