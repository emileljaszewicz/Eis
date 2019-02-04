<?php
class RejestracjaWidok extends Widok{
    private $tablica;
	function __construct($kontroler, $url){
            $this->setTytulstrony("Zarejestruj się");
	    parent:: __construct($kontroler, $url);
            $this->setSzablonglowny('szablonglowny/logowanieszablon.php');
            $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
	}
        function index(){
          $this->setWidokmodul("rejestracja_formularz");
          $this->szablonglowny();
        }
 function setWyswietlopcje($tablica){
     $this->tablica = $tablica;
 }
 function getWyswietlopcje(){
     return $this->tablica;
 }
}
?>