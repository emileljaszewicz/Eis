<?php

class UzytkownikWiadomosciWidok extends Widok{
    function __construct($kontroler, $url) {
        $this->setTytulstrony("Wiadomości");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }
    function listawiadomosci(){
        $this->setWidokmodul("lista_wiadomosci");
        $this->szablonglowny();
    }
    function wiadwyslane(){
        $this->setWidokmodul("wiadomosci_wyslane");
        $this->szablonglowny();
    }
    function wiadczytaj(){
        $this->setWidokmodul("tresc_wiadomosc");
        $this->szablonglowny();
    }
    function wiadwyslana(){
        $this->setWidokmodul("tresc_wiadomosc_wyslana");
        $this->szablonglowny();
    }
    function wiadomoscformularz(){
        $this->setWidokmodul("wiadomosc_formularz");
        $this->szablonglowny();
    }
}

