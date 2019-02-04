<?php

class UczenkalendarzKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
    }

    function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
$model->databierzaca();
        $widok->index();
    }

    function idzdodaty() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $widok->setOpcje('danewydarzenie', $model->wydarzeniedata()); 
        $widok->wydarzenieforma();
    }

}
