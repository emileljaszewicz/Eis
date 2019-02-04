<?php

class AdminKategorieKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
        
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listakategorii',$model->wyswietllisteklas(40));
       $widok->setOpcje('nauczyciele',$model->listanauczycieli());
       $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
        
        $widok->index();
    }
    function szkolaprzedmioty() {
        if(!isset($this->url[3])){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaprzedmiotow',$model->listaprzedmiotow(40));
        $widok->setOpcje('przedmiotylinki',$model->wyswietllinkiprzedmioty(40));
        $widok->wyswietlbledy($model->getBlad());
        $widok->przedmioty();
        }
        else{
            $this->przedmiotystrona();
        }
    }
    function zajeciagodziny() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('godziny',$model->godzinyzajecia(40));
        $widok->setOpcje('linkistron',$model->godzinylinki(40));
        $widok->wyswietlbledy($model->getBlad());
        $widok->godzinylista();
    }
    function dodajklase(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        if($model->klasadodaj()){
            $this->przekierowanie('./index');
        }
        else{
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listakategorii',$model->wyswietllisteklas(40));
       $widok->setOpcje('nauczyciele',$model->listanauczycieli());
       $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
       $widok->index();
        }
    }
    function strona(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listakategorii',$model->strona(40));
        $widok->setOpcje('nauczyciele',$model->listanauczycieli());
        $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
        $widok->index();
    }
    function klasaedycja(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->klasaedycja();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('nauczyciele',$model->listanauczycieli());
        $widok->setOpcje('daneklasa',$model->klasaedycja());
        $widok->setOpcje('url',@$this->url[2]);
        $widok->klasaedytuj();
    }
    function klasausun(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->usunklasa();
        $widok->wyswietlbledy($model->getBlad());
        if($model->usunklasa()){
            $this->przekierowanie('../index');
        }
        else{
            $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listakategorii',$model->wyswietllisteklas(40));
       $widok->setOpcje('nauczyciele',$model->listanauczycieli());
       $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
        
        $widok->index();
        }
    }
    function przedmiotystrona(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaprzedmiotow',$model->przedmiotystrona(40));
        $widok->setOpcje('przedmiotylinki',$model->wyswietllinkiprzedmioty(40));
        $widok->wyswietlbledy($model->getBlad());
        $widok->przedmioty();
    }
    function przedmiotedycja(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        if($model->edytujprzedmiot() == "ok"){
            $this->przekierowanie('../szkolaprzedmioty');
        }
        else{
            $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('przedmiotdane',$model->edytujprzedmiot());
        $widok->wyswietlbledy($model->getBlad());
        }
        $widok->przedmiotedytuj();
    }
    function przedmiotusun(){
        $model = $this->ladujmodel();
        if($model->usunprzedmiot()){
            $this->przekierowanie('../szkolaprzedmioty');
        }
    }
    function godzinaedycja(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $widok->setOpcje('godzinaedytuj', $model->edytujgodzina());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->edytujgodzina();
    }
    function listaocen(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaocen',$model->pobierzoceny());
        $widok->listaocen();
    }
    function ocenaedycja(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $model->ocenaedycja();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('daneocena',$model->ocenaedycja());
        $widok->ocenaedytuj();
    }
    function ocenausun(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        if($model->ocenausun()){
            $this->przekierowanie('../listaocen');
        }
        else{
            $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaocen',$model->pobierzoceny());
        $widok->listaocen();
        }
    }
    function semestry(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        
        $model->podzialsemestry();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        
        
        $widok->semestry();
    }
    function promocje(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $model->promocjeklasy();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaklas',$model->promocjeklasy());
        $widok->promocje();
    }
    function cofnijzamkniecie(){
        $model = $this->ladujmodel();
        
        $model->otwarciepromocja();
        
        $this->przekierowanie('../promocje');
    }
}
