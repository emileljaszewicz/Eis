<?php

class SzkolalicencjaKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->sprawdzwaznosc();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('licencjadane',$model->sprawdzwaznosc());
        
        $widok->index();
    }
    
    
}
