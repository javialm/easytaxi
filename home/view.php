<?php
$diccionario = array(
	'subtitle'=>array(
		VIEW_GET_HOME=>'Home',
	),
	'links_menu'=>array(
		'VIEW_HOME'=>MODULO_HOME,
		'VIEW_PRINCIPAL'=>MODULO_PRINCIPAL
	),
	'form_actions'=>array()
);

function get_template($form='get') {
	$file = '../site_media/html/home_'.$form.'.html';
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
	if(array_key_exists('descripcion', $data)&& $vista==VIEW_EDIT_USER) {
		$mensaje = 'Editar usuario '.$data['descripcion'];
	} else {
		if(array_key_exists('mensaje', $data)) {
			$mensaje = $data['mensaje'];
		} else {
			$mensaje = 'Usuarios';
		}
	}
	$html = str_replace('{mensaje}', $mensaje, $html);
	print $html;
}
?>
