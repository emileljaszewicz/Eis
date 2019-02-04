<?php

class DziennikszkolaWidok extends Widok {

    function __construct($kontroler, $url) {
        $this->setTytulstrony("Dziennik");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }

    function index() {
        $this->setWidokmodul("lista_klas");
        $this->szablonglowny();
    }

    function dodajogloszenie() {
        $this->setWidokmodul("ogloszenie_formularz");
        $this->szablonglowny();
    }

    function wyswietllisty() {
        $this->setWidokmodul("listy_obecnosci");
        $this->szablonglowny();
    }

    function uczenformularz() {
        $this->setWidokmodul("nowy_uczen");
        $this->szablonglowny();
    }

    function nowalista() {
        $this->setWidokmodul("sprawdzanie_obecnosci");
        $this->szablonglowny();
    }

    function tabelaobecnosci() {
        $this->setWidokmodul("klasa_lista_obecnosci");
        $this->szablonglowny();
    }

    function obecnoscedycja() {
        $this->setWidokmodul("uczenobecnosc_edycja");
        $this->szablonglowny();
    }

    function ocenyprzedmiot() {
        $this->setWidokmodul("klasa_oceny");
        $this->szablonglowny();
    }

    function nowaocena() {
        $this->setWidokmodul("uczen_ocena");
        $this->szablonglowny();
    }
    function edycjaocena() {
        $this->setWidokmodul("uczen_ocena_edycja");
        $this->szablonglowny();
    }
    function listawag(){
        $this->setWidokmodul("nauczyciel_wagi");
        $this->szablonglowny();
    }
    function ocenakoniec(){
        $this->setWidokmodul("ocena_koncowa");
        $this->szablonglowny();
    }
function edycjawaga(){
    $this->setWidokmodul("waga_edycja");
        $this->szablonglowny();
}
function terminarz(){
    $this->setWidokmodul("terminarz");
        $this->szablonglowny();
}
function dodajtermin(){
    $this->setWidokmodul("nowy_termin");
        $this->szablonglowny();
}
}

?>