<?php

class SzkolaogloszeniaKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        
            parent:: __construct($kontroler, $url);
        
        
        
        
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlogloszenia',$model->pobierzogloszenia(10));
        $widok->setOpcje('linkistron',$model->wyswietllinkiogloszenia(10));
        $widok->index();
    }
    function strona(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlogloszenia',$model->nastepneogloszenia(10));
        $widok->setOpcje('linkistron',$model->wyswietllinkiogloszenia(10));
        $widok->index();
    }
    
    function dodajnowe(){
        if(($_SESSION['Ranga'] == 'Administrator_serwis') or ($_SESSION['Ranga'] == 'Szkola')){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->noweogloszenie();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('selectopcje',$model->listaodbiorcow());
        $widok->dodajogloszenie();
        }
    }
    function ogloszenieusun(){
        if(($_SESSION['Ranga'] == 'Administrator_serwis') or ($_SESSION['Ranga'] == 'Szkola')){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $model->usunogloszenie();
       $this->przekierowanie('../../ogloszenia.html/index');
        }
    }
}
