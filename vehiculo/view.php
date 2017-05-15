<?php
$diccionario = array(
	'subtitle'=>array(
		VIEW_SET_VEHICLE=>'Crear un nuevo vehículo',
		VIEW_GET_VEHICLE=>'Buscar vehículo',
		VIEW_DELETE_VEHICLE=>'Eliminar un vehículo',
		VIEW_EDIT_VEHICLE=>'Modificar vehículo'
	),
	'links_menu'=>array(
		'VIEW_SET_VEHICLE'=>MODULO.VIEW_SET_VEHICLE.'/',
		'VIEW_GET_VEHICLE'=>MODULO.VIEW_GET_VEHICLE.'/',
		'VIEW_EDIT_VEHICLE'=>MODULO.VIEW_EDIT_VEHICLE.'/',
		'VIEW_DELETE_VEHICLE'=>MODULO.VIEW_DELETE_VEHICLE.'/',
		'VIEW_PRINCIPAL'=>MODULO_PRINCIPAL
	),
	'form_actions'=>array(
		'SET'=>MODULO.SET_VEHICLE.'/',
		'GET'=>MODULO.GET_VEHICLE.'/',
		'DELETE'=>MODULO.DELETE_VEHICLE.'/',
		'EDIT'=>MODULO.EDIT_VEHICLE.'/'
	)
);

function get_template($form='get') {
	$file = '../site_media/html/vehicle_'.$form.'.html';
	$template = file_get_contents($file);
return $template;
}

function render_dinamic_data($html, $data) {
	foreach ($data as $clave=>$valor) {
		$html = str_replace('{'.$clave.'}', $valor, $html);
	}
return $html;
}

function retornar_vista($vista, $data=array()) {
	global $diccionario;
	$html = get_template('template');
	$html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista],$html);
	$html = str_replace('{formulario}', get_template($vista), $html);
	$html = render_dinamic_data($html, $diccionario['form_actions']);
	$html = render_dinamic_data($html, $diccionario['links_menu']);
	$html = render_dinamic_data($html, $data);
	// render {mensaje}
	if(array_key_exists('descripcion', $data)&& $vista==VIEW_EDIT_VEHICLE) {
		$mensaje = 'Editar vehículo '.$data['descripcion'];
	} else {
		if(array_key_exists('mensaje', $data)) {
			$mensaje = $data['mensaje'];
		} else {
			$mensaje = 'Vehiculos';
		}
	}
	$html = str_replace('{mensaje}', $mensaje, $html);
	print $html;
}
?>
