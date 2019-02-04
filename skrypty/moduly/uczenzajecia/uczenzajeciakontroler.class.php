<?php

class UczenzajeciaKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
    }

    function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $widok->setOpcje('zajeciadnityg', $model->dnitygodniauczen());
        $widok->setOpcje('godzinyzajec', $model->godzinyzajec());
        $widok->setOpcje('przedmioty', $model->przedmiotyuczen());
        $widok->planzajec();
    }

}
