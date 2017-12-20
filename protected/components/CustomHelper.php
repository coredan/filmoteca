<?php
class CustomHelper extends CApplicationComponent {
 
 public function cutText($text, $length, $replacemenet = "...") {
 	$value = $text;
 	if(strlen($text) > $length){
    	$value = substr($text, 0, $length);
     	$value .= $replacemenet;
 	}
     return $value;
 }
 
}
?>