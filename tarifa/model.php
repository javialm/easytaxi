<?php
require_once('../core/db_abstract_model.php');
class Tarifa extends DBAbstractModel {
	public $id_rate;
	public $classname;
	public $price_km;

	public function get($id_rate='') {
		if($id_rate != ''):
			$this->query = "
			SELECT *
			FROM Rate
			WHERE id_rate = '$id_rate'
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
	public function set($rate_data=array()) {
		if($rate_data){//if(array_key_exists('id_vehicle', $rate_data)) pero el id es autoincrement

				foreach ($rate_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query = "
				INSERT INTO Rate
				(id_rate,classname,price_km)
				VALUES
				('','$classname', $price_km)";
				$this->execute_single_query();
				$this->mensaje = $classname.' agregado';
			
		}
	}
	public function edit($prod_data=array()) {
		foreach ($prod_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE Vehicle
			SET classname='$classname',
			price_km=$price_km,
			WHERE id_rate = '$id_rate'
		";
		$this->execute_single_query();
		$this->mensaje = 'Tarifa modificada';
		}
	public function delete($id_rate='') {
		$this->query = "
		DELETE FROM Rate
		WHERE id_rate = '$id_rate'
		";
		$this->execute_single_query();
		$this->mensaje = 'Tarifa eliminado';
	}
	public function listing($prod_data=array()) {
		foreach ($prod_data as $campo=>$valor):
			$$campo = $valor;
		endforeach;

			$this->query = "SELECT * FROM Rate WHERE id_rate IS NOT NULL ";
			$this->query .= ($id_rate==NULL or $id_rate=="") ? '' : 'AND id_rate="'.$id_rate.'"' ;
			$this->query .= ($classname==NULL or $classname=="") ? '' : 'AND classname="'.$classname.'"' ;
			$this->query .= ($price_km==NULL or $price_km=="") ? '' : 'AND price_km="'.$price_km.'"' ;
			$this->get_results_from_query();

		//PASANDO EL RESULTADO AL AJAX PARA RENDERIZARLO EN EL LADO DEL CLIENTE
		if(count($this->rows) >0){
			$car_data = array();
					/*for($i=0;$i<count($this->rows);$i++){
						$id_rate = $this->rows[$i]['id_vehicle'];
						$car_data[$i]["id_vehicle"] = $id_rate;
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
