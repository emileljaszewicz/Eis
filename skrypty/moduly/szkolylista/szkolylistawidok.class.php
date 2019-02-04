<?php

class SzkolyListaWidok extends Widok {
private $wysw;
    function __construct($kontroler, $url) {
        $this->setTytulstrony("Lista szkół");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }

    function index() {
        $this->setWidokmodul("szkoly_forma");
        $this->szablonglowny();
    }
    function szkoladane(){
        $this->setWidokmodul("szkola_dane");
        $this->zwrocmenu();
        $this->szablonglowny();
    }
 function wyswietlszkoly($szkoly = null, $menu = null){
     $this->szkoly = $szkoly;
     $this->menu = $menu;
 }
 function dodajszkoly(){
        $this->setWidokmodul("szkola_formularz");
        $this->szablonglowny();
    }
    function kategorieszkol(){
        $this->setWidokmodul("szkola_kategorie");
        $this->szablonglowny();
    }
    function edytujkategorie(){
        $this->setWidokmodul("kategoria_edycja");
        $this->szablonglowny();
    }
    function szkolyakceptacje() {
        $this->setWidokmodul("szkoly_forma");
        $this->szablonglowny();
    }
 function zwrocszkoly(){
     return $this->szkoly;
 }
 function zwrocmenu(){
     return $this->menu;
 }
 function setLinkistron($linki){
     $this->linki = $linki;
 }
function getLinkistron(){
    return $this->linki;
}
}

?>