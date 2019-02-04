<?php

class AllertyKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlszkoly',$model->pobierzszkoly(20));
        $widok->setOpcje('linkistron',$model->wyswietllinkistron(20));
        $widok->index();
    }
    function strona(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlszkoly',$model->kolejnestrony(20));
        $widok->setOpcje('linkistron',$model->wyswietllinkistron(20));
        $widok->index();
    }
    
}
