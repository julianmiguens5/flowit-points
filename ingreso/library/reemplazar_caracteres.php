<? 

function convertir_especiales_html($str){
   if (!isset($GLOBALS["carateres_latinos"])){
      $todas = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
      $etiquetas = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES);
      $GLOBALS["carateres_latinos"] = array_diff($todas, $etiquetas);
   }
   $str = strtr($str, $GLOBALS["carateres_latinos"]);
   return $str;
}

function limpiar_caracteres_especiales($s) {
	
	$caracteres_raros = array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&ntilde;","&Ntilde;","&uuml;","&Uuml;","&acute;", "&rsquo;", "&lsquo;");
	$caracteres_remp = array("a","e","i","o","u","A","E","I","O","U","n","N","u","U","","","");
 	$s = str_replace($caracteres_raros, $caracteres_remp, $s);
	return $s;
}

?>