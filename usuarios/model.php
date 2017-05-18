<?php
require_once('../core/db_abstract_model.php');
class Usuario extends DBAbstractModel {
	public $id_user;
	public $username;
	public $email;
	public $pass;
	public $level;

	public function get($id_user='') {
		if($id_user != ''):
			$this->query = "
			SELECT *
			FROM user
			WHERE id_user = '$id_user'
			";
			$this->get_results_from_query();
		endif;
		if(count($this->rows) == 1){
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
			$this->mensaje = 'Usuario encontrado';
		} else {
			$this->mensaje = 'Usuario no encontrado';
		}
	}
	public function set($user_data=array()) {
		if($user_data){//if(array_key_exists('id_user', $user_data)) pero el id es autoincrement

				foreach ($user_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query = "
				INSERT INTO User
				(id_user,username,email,pass,level)
				VALUES
				('','$username', '$email', '$pass', '$level')
				";
				$this->execute_single_query();
				$this->mensaje = $model.' agregado';
			
		}
	}
	public function edit($user_data=array()) {
		foreach ($user_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE User
			SET username='$username',
			email='$email',
			pass='$pass',
			level='$level',
			WHERE id_user = '$id_user'
		";
		$this->execute_single_query();
		$this->mensaje = 'Usuario modificado';
		}
	public function delete($id_user='') {
		$this->query = "
		DELETE FROM User
		WHERE id_user = '$id_user'
		";
		$this->execute_single_query();
		$this->mensaje = 'Usuario eliminado';
	}
	public function listing($user_data=array()) {
		foreach ($user_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;

			$this->query = "SELECT * FROM User WHERE id_user IS NOT NULL ";
			/*$this->query .= ($id_user==NULL or $id_user=="") ? '' : 'AND id_user="'.$id_user.'"' ;
			$this->query .= ($username==NULL or $username=="") ? '' : 'AND username="'.$username.'"' ;
			$this->query .= ($email==NULL or $email=="") ? '' : 'AND email="'.$email.'"' ;
			$this->query .= ($pass==NULL or $pass=="") ? '' : 'AND pass="'.$pass.'"' ;
			$this->query .= ($level==NULL or $level=="") ? '' : 'AND level="'.$level.'"' ;*/
			$this->get_results_from_query();

		//PASANDO EL RESULTADO AL AJAX PARA RENDERIZARLO EN EL LADO DEL CLIENTE
		if(count($this->rows) >0){
			//$car_data = array();
					/*for($i=0;$i<count($this->rows);$i++){
						$id_user = $this->rows[$i]['id_user'];
						$car_data[$i]["id_user"] = $id_user;
					}*/
					echo json_encode($this->rows, JSON_FORCE_OBJECT);
		}	
		
	}

	function __destruct() {
		unset($this);
	}
	function __construct() {
		$this->db_name = 'proyecto';

	}
}
?>
