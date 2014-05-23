<?php 

$link = $_GET['deviceid'];
hostup($link);

	   function hostup($link) 
    { 
        
		$ping = exec("ping -c 1 -s 64 -t 64 ".$link);
         if (!$ping) { 
            $text=" <img  src=\"images/red_icon.png\" width=\"16\" height=\"16\" class=\"imgs\"/>"; 
         }else{ 
            $text="<img  src=\"images/green_icon.png\" width=\"16\" height=\"16\" class=\"imgs\" />"; 
         } 
         echo $text; 
    }

?>