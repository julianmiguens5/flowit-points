<?php
//vars
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
$to = explode(',', filter_input(INPUT_POST, 'to', FILTER_SANITIZE_SPECIAL_CHARS) );

$from = $_POST['mail'];

//data
$msg = "NOMBRE: "  . filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS) ."<br>\n";
$msg .= "EMAIL: "  . filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_SPECIAL_CHARS)    ."<br>\n";
$msg .= "COMENTARIOS: "  . filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_SPECIAL_CHARS)   ."<br>\n";

//Headers
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: <".$from. ">" ;


//send for each mail
foreach($to as $mail){
   mail($mail, $subject, $msg, $headers);
}

?>
