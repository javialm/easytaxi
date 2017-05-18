<?php
require_once('../core/db_abstract_model.php');
class Path extends DBAbstractModel {
	public $id_rate;
	public $classname;
	public $price_km;

	public function get($price_km='') {
		if($price_km != ''):
			$this->query = "
			SELECT *
			FROM Rate
			WHERE price_km = $price_km
			";
			$this->get_results_from_query();
		endif;
		if(count($this->rows) == 1){
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
			$this->mensaje = 'Tarifa encontrada';
		} else {
			$this->mensaje = 'Tarifa no encontrada';
		}
	}
	public function set(){
		
	}
	public function edit(){
		
	}
	public function delete(){
		
	}

	public function show_price(){
		
		$this->query = "SELECT * FROM Rate WHERE id_rate IS NOT NULL ";
		$this->get_results_from_query();

		//PASANDO EL RESULTADO AL AJAX PARA RENDERIZARLO EN EL LADO DEL CLIENTE
		if(count($this->rows) >0){
			
			echo json_encode($this->rows, JSON_FORCE_OBJECT);
		}	
	}

	public function login($user_data=array()){
		foreach ($user_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;

		$this->query = "SELECT * FROM User WHERE email = '$email' AND pass = '$pass' ";
		$this->get_results_from_query();
		if(count($this->rows) >0){
			$_SESSION['user'] = $this->rows[0]['level'];
			$_SESSION['nick'] = $this->rows[0]['username'];
			if($this->rows[0]['level'] == "admin"){
				header("location: ../principal/controller.php");
			}else{
				header("location: ../home/controller.php");
			}
		}
	}

	public function createUser($user_data=array()) {
		if($user_data){//if(array_key_exists('id_user', $user_data)) pero el id es autoincrement

				foreach ($user_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query = "
				INSERT INTO User
				(id_user,username,email,pass,level)
				VALUES
				('','$username', '$email', '$pass', 'user')
				";
				$this->execute_single_query();
				$this->mensaje = $model.' agregado';
			header("location: ../home/controller.php");
		}
	}

	public function createPdfTicket(){
		
	}

	function __destruct() {
		unset($this);
	}
	function __construct() {
		$this->db_name = 'proyecto';

	}
}
?>
