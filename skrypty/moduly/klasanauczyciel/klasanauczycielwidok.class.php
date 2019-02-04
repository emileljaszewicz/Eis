<?php

class KlasanauczycielWidok extends Widok {

    private $wysw;

    function __construct($kontroler, $url) {
        $this->setTytulstrony("Zarządzaj klasą");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }

    function index() {
        $this->setWidokmodul("klasa_lista_obecnosci");
        $this->szablonglowny();
    }

    function edycjaobecnosc() {
        $this->setWidokmodul("uczenobecnosc_edycja");
        $this->szablonglowny();
    }

    function ocenyuczniowie() {
        $this->setWidokmodul("klasa_oceny");
        $this->szablonglowny();
    }

    function sprawdzocena() {
        $this->setWidokmodul("ocena_podglad");
        $this->szablonglowny();
    }

    function wychowawcauczniowie() {
        $this->setWidokmodul("uczniowie_lista");
        $this->szablonglowny();
    }

    function uczeninfo() {
        $this->setWidokmodul("uczen_dane");
        $this->szablonglowny();
    }

    function uczenformularz() {
        $this->setWidokmodul("uczen_formularz");
        $this->szablonglowny();
    }
    function listanieklasyfikowanych() {
        $this->setWidokmodul("uczniowie_nieklasyfikowani");
        $this->szablonglowny();
    }

}

?>