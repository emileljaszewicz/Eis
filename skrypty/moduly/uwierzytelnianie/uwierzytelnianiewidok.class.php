<?php
class UwierzytelnianieWidok extends Widok{
	function __construct($kontroler, $url){
            $this->setTytulstrony("Zarejestruj się");
	    parent:: __construct($kontroler, $url);
            $this->setSzablonglowny('szablonglowny/logowanieszablon.php');
            $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
	}
        function index(){
          $this->setWidokmodul("potwierdz");
          $this->szablonglowny();
        }
}
?>