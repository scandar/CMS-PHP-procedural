<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

$to = "gero55555@gmail.com";
$header = "From: thescandar@gmail.com";
// send email
mail($to,"My subject",$msg,$header);
?>
