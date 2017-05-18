<?php
require_once('../core/db_abstract_model.php');
class Vehiculo extends DBAbstractModel {
	public $id_vehicle;
	public $class;
	public $brand;
	public $model;
	public $year;
	public $km;

	public function get($id_vehicle='') {
		if($id_vehicle != ''):
			$this->query = "
			SELECT *
			FROM Vehicle
			WHERE id_vehicle = '$id_vehicle'
			";
			$this->get_results_from_query();
		endif;
		if(count($this->rows) == 1){
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
			$this->mensaje = 'Vehiculo encontrado';
		} else {
			$this->mensaje = 'Vehiculo no encontrado';
		}
	}
	public function set($vehicle_data=array()) {
		if($vehicle_data){//if(array_key_exists('id_vehicle', $vehicle_data)) pero el id es autoincrement

				foreach ($vehicle_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query = "
				INSERT INTO Vehicle
				(id_vehicle,class,brand,model,year,km)
				VALUES
				('','$class', '$brand', '$model' , $year, $km)
				";
				$this->execute_single_query();
				$this->mensaje = $model.' agregado';

		}
	}
	public function edit($prod_data=array()) {
		foreach ($prod_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE Vehicle
			SET class='$class',
			brand='$brand',
			model='$model',
			year='$year',
			km='$km'
			WHERE id_vehicle = '$id_vehicle'
		";
		$this->execute_single_query();
		$this->mensaje = 'Vehiculo modificado';
		}
	public function delete($id_vehicle='') {
		$this->query = "
		DELETE FROM Vehicle
		WHERE id_vehicle = '$id_vehicle'
		";
		$this->execute_single_query();
		$this->mensaje = 'Vehiculo eliminado';
	}
	public function listing($prod_data=array()) {
		foreach ($prod_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;

			$this->query = "SELECT * FROM Vehicle WHERE id_vehicle IS NOT NULL ";
			$this->query .= ($id_vehicle==NULL or $id_vehicle=="") ? '' : 'AND id_vehicle="'.$id_vehicle.'"' ;
			$this->query .= ($class==NULL or $class=="") ? '' : 'AND class="'.$class.'"' ;
			$this->query .= ($brand==NULL or $brand=="") ? '' : 'AND brand="'.$brand.'"' ;
			$this->query .= ($model==NULL or $model=="") ? '' : 'AND model="'.$model.'"' ;
			$this->query .= ($year==NULL or $year=="") ? '' : 'AND year="'.$year.'"' ;
			$this->query .= ($km==NULL or $km=="") ? '' : 'AND km BETWEEN '.$km.' AND '.$km2.'';
			$this->get_results_from_query();

		//PASANDO EL RESULTADO AL AJAX PARA RENDERIZARLO EN EL LADO DEL CLIENTE
		if(count($this->rows) >0){
			$car_data = array();
					/*for($i=0;$i<count($this->rows);$i++){
						$id_vehicle = $this->rows[$i]['id_vehicle'];
						$car_data[$i]["id_vehicle"] = $id_vehicle;
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
