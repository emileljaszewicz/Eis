<?php

class OcenyuczenWidok extends Widok {

    private $wysw;

    function __construct($kontroler, $url) {
        $this->setTytulstrony("Wykaz ocen");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }

    function index() {
        $this->setWidokmodul("uczen_oceny");
        $this->szablonglowny();
    }
    function podgladocena(){
        $this->setWidokmodul("oceny_podglad");
        $this->szablonglowny();
    }

}

?>