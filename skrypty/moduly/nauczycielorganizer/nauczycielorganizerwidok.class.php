<?php

class nauczycielorganizerWidok extends Widok {

    function __construct($kontroler, $url) {
        $this->setTytulstrony("Organizer");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }

    function index() {
        $this->setWidokmodul("notatki");
        $this->szablonglowny();
    }

    function nowanotatka() {
        $this->setWidokmodul("nowa_notatka");
        $this->szablonglowny();
    }

    function edytujnotatka() {
        $this->setWidokmodul("edycja_notatka");
        $this->szablonglowny();
    }

    function planzajec() {
        $this->setWidokmodul("nauczyciel_plan_zajec");
        $this->szablonglowny();
    }

    function dodajdzien() {
        $this->setWidokmodul("dodaj_dzien_formularz");
        $this->szablonglowny();
    }

    function edycjadnia() {
        $this->setWidokmodul("edytuj_dzien");
        $this->szablonglowny();
    }

    function listanauczycieli() {
        $this->setWidokmodul("nauczyciele_sale");
        $this->szablonglowny();
    }

}

?>