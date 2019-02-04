<?php

echo '<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>' . $this->getTytulstrony() . '</title>
    <link rel="Shortcut icon" href="'.$this->dolacz.'szablonglowny/zdjecia/favikona.png" />
<link href="' . $this->dolacz . $this->cssglowny . '" rel="stylesheet" />
';
if (count($this->getCssdodatkowy()) > 0) {
    foreach ($this->getCssdodatkowy() as $linkcss) {
        echo '<link href="' . $this->dolacz . $linkcss . '" rel="stylesheet" />';
        echo "\n";
    }
}
echo'
		</head>
		<body>';
echo '
              		<div id="strona_kontener">';
echo '<div id="strona_kontener_baner">';
echo '<img src="' . $this->dolacz . 'szablonglowny/zdjecia/eislogo.png" alt="eislogo" />';
echo '</div>';
echo '<div id="menu_kontener">';
echo $this->wolajfunkcja('tworzmenu', $_SESSION['Ranga']);
if (isset($_SESSION['wychowawca'])) {
    echo '<a href="' . $this->dolacz . 'twoja_klasa.html">Twoja klasa</a>';
}
echo '<a href="' . $this->dolacz . $this->url[0] . '/wyloguj">Wyloguj</a>';
echo '<div id="powitanie">Zalogowany jako: ' . $_SESSION['Login'] . '</div>';
echo '</div>';
echo '<div id="strona_zawartosc">';
$this->getWidokmodul();
echo '</div>';
echo '<div id="wyrownaj"></div>';
echo '<div id="stopka">';
echo $this->wolajfunkcja('tworzstopke');
echo'</div>';
echo '</div>';

echo '</body>
		</html>';
?>