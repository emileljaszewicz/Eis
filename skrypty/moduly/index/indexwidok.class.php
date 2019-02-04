<?php
class IndexWidok extends Widok{
	function __construct($kontroler, $url){
            $this->setTytulstrony("Strona główna");
	    parent:: __construct($kontroler, $url);
            $this->setSzablonglowny('szablonglowny/indexszablon.php');
            $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formalogowanie.css');
	}
        function index(){
          $this->setWidokmodul("index");
          $this->szablonglowny();
        }
        function formularz(){
            $this->setWidokmodul("formularz");
          $this->szablonglowny();
        }
        function danewyslane(){
            $this->setWidokmodul("wyslano");
          $this->szablonglowny();
        }
}
?>