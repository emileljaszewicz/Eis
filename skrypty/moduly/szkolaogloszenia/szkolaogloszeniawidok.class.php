<?php

class SzkolaogloszeniaWidok extends Widok {

    function __construct($kontroler, $url) {
        $this->setTytulstrony("Powiadomienia");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }

    function index() {
        $this->setWidokmodul("ogloszenia_forma");
        $this->szablonglowny();
    }
function dodajogloszenie(){
    $this->setWidokmodul("ogloszenie_formularz");
        $this->szablonglowny();
}
    

}

?>