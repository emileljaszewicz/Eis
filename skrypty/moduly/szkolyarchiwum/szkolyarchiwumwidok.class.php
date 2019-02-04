<?php

class SzkolyArchiwumWidok extends Widok {

    function __construct($kontroler, $url) {
        $this->setTytulstrony("Archiwum - szkoły");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }

    function index() {
        $this->setWidokmodul("listaarchiwum");
        $this->szablonglowny();
    }

    

}

?>