<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>'.$this->getTytulstrony().'</title>
<link href="'.$this->dolacz.$this->cssglowny.'" rel="stylesheet" />
    <link rel="Shortcut icon" href="'.$this->dolacz.'szablonglowny/zdjecia/favikona.png" />
';
		if(count($this->getCssdodatkowy()) > 0){
                    foreach($this->getCssdodatkowy() as $linkcss){
			echo '<link href="'.$this->dolacz.$linkcss.'" rel="stylesheet" />';
                    }
		}
		echo'
		</head>
		<body>';
                echo '
              		<div id="strona_kontener">';
		echo '<div id="strona_kontener_baner">';
		echo '<img src="'.$this->dolacz.'szablonglowny/zdjecia/eislogo.png" alt="eislogo" />';
		echo '</div>';
		echo '<div id="strona_zawartosc">';  
		$this->getWidokmodul();
		echo '</div>';
                echo '<div id="stopka">';
echo $this->wolajfunkcja('tworzstopke');
echo'</div>';
		echo '</div>';
		echo '</body>
		</html>';
		?>