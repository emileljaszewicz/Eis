<?php

class KontaZarzadzanieKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
        
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listanauczycieli',$model->wyswietldane(40));
        $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
        
        $widok->index();
    }
    function strona(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listanauczycieli',$model->strona(40));
        $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
        $widok->index();
    }
    function nauczycielpokaz(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('nauczycieldane',$model->nauczycielwyswietl());
        $widok->nauczycieldane();
    }
    function nauczycieledycja(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->wyswietlbledy($model->nauczycieledycja());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('formlink',$model->getLinkformularz());
        $widok->setOpcje('listaprzedmiotow',$model->listaprzedmiotow());
        $widok->setOpcje('dane',$model->nauczycielwyswietl());
        $widok->setOpcje('nauczycielprzedmioty',$model->nauczycielprzedmioty());
        $widok->formularznauczyciel();
    }
    function nowynauczyciel(){
        
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->wyswietlbledy($this->ladujmodel()->dodajnauczyciela());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('formlink',$model->getLinkformularz());
        $widok->setOpcje('listaprzedmiotow',$model->listaprzedmiotow());
        $model->dodajnauczyciela();
        $widok->formularznauczyciel();
    }
    function nauczycielusun(){
        $model = $this->ladujmodel();
        $model->usunnauczyciela();
        $this->przekierowanie('../index');
    }
    function hasloreset(){
        $model = $this->ladujmodel();
        $model->resetujhaslo();
        $this->przekierowanie('../nauczycielpokaz/'.@$this->url[2]);
    }
    
}
