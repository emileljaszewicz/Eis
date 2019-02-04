<?php

class StronaKonfigKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
    }

function index() {
        
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        
        $model->personalizacja();
        $widok->wyswietlbledy($model->getBlad());
        
        
        
        $widok->index();
    }
}
