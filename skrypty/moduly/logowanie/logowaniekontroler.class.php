<?php

class LogowanieKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->index();
    }
    function wyslijdane(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->wyswietlbledy($this->ladujmodel()->wyswietldane());
        if($this->ladujmodel()->wyswietldane() == 'ok'){
            $this->przekierowanie('../');
        }
        else{
           $widok->index();
        }
    }
}
