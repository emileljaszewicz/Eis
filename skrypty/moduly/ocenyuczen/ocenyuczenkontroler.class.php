<?php

class OcenyuczenKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->ocenyuczen();
        $model->getLiczsemestry();
        $widok->setOpcje('wyswietlsemestry',$model->getLiczsemestry());
        $widok->setOpcje('listaprzedmiotow',$model->pobierzprzedmioty());
        $widok->setOpcje('listaocen',$model->ocenyuczen());
        $widok->index();
    }
    function podgladocena(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $widok->setOpcje('ocenaszczegoly',$model->pobierzocene());
        $widok->podgladocena();
    }
    
}
