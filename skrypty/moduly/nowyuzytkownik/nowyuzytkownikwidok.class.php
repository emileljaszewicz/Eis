<?php
class NowyUzytkownikWidok extends Widok{
	function __construct($kontroler, $url){
            $this->setTytulstrony("Rejestracja użytkownika");
	    parent:: __construct($kontroler, $url);
            $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
	}
        function index(){
          $this->setWidokmodul("zmianadanych");
          $this->szablonglowny();
        }
}
?>