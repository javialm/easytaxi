<?php
$diccionario = array(
	'subtitle'=>array(),
	'links_menu'=>array(
		'VIEW_USER'=>MODULO_USER,
		'VIEW_VEHICLE'=>MODULO_VEHICLE,
		'VIEW_RATE'=>MODULO_RATE,
		'VIEW_HOME'=>MODULO_HOME
	),
	'form_actions'=>array()
);

function get_template($form='get') {
	$file = '../site_media/html/principal_'.$form.'.html';
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
	$html = render_dinamic_data($html, $diccionario['links_menu']);
	// render {mensaje}
	$mensaje = '<h3>Bienvenido al panel de gestión</h3>';
	$html = str_replace('{mensaje}', $mensaje, $html);
	print $html;
}
?>
