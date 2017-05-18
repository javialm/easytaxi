<?php
$diccionario = array(
	'subtitle'=>array(
		VIEW_SET_RATE=>'Crear tarifa',
		VIEW_GET_RATE=>'Ver tarifas ',
		VIEW_DELETE_RATE=>'Eliminar una tarifa',
		VIEW_EDIT_RATE=>'Modificar tarifa'
	),
	'links_menu'=>array(
		'VIEW_SET_RATE'=>MODULO.VIEW_SET_RATE.'/',
		'VIEW_GET_RATE'=>MODULO.VIEW_GET_RATE.'/',
		'VIEW_EDIT_RATE'=>MODULO.VIEW_EDIT_RATE.'/',
		'VIEW_DELETE_RATE'=>MODULO.VIEW_DELETE_RATE.'/',
		'VIEW_PRINCIPAL'=>MODULO_PRINCIPAL
	),
	'form_actions'=>array(
		'SET'=>MODULO.SET_RATE.'/',
		'GET'=>MODULO.GET_RATE.'/',
		'DELETE'=>MODULO.DELETE_RATE.'/',
		'EDIT'=>MODULO.EDIT_RATE.'/'
	)
);

function get_template($form='get') {
	$file = '../site_media/html/tarifa_'.$form.'.html';
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
	if(array_key_exists('descripcion', $data)&& $vista==VIEW_EDIT_RATE) {
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
