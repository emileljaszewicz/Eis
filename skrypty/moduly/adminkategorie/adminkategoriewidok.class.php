<?php

class AdminKategorieWidok extends Widok {
private $wysw;
    function __construct($kontroler, $url) {
        $this->setTytulstrony("Zarządzaj kategoriami");
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
    function przedmioty() {
        $this->setWidokmodul("szkola_przedmioty");
        $this->szablonglowny();
    }
    function godzinylista() {
        $this->setWidokmodul("godziny_zajec");
        $this->szablonglowny();
    }
    function klasaedytuj() {
        $this->setWidokmodul("klasa_edycja");
        $this->szablonglowny();
    }
    function przedmiotedytuj(){
        $this->setWidokmodul("przedmiot_edycja");
        $this->szablonglowny();
    }
    function edytujgodzina(){
        $this->setWidokmodul("godzina_edycja");
        $this->szablonglowny();
    }
    function listaocen(){
        $this->setWidokmodul("lista_ocen");
        $this->szablonglowny();
    }
    function ocenaedytuj(){
        $this->setWidokmodul("edycja_ocena");
        $this->szablonglowny();
    }
    function semestry(){
        $this->setWidokmodul("przedzial_semestry");
        $this->szablonglowny();
    }
    function promocje(){
        $this->setWidokmodul("promocje");
        $this->szablonglowny();
    }
}

?>