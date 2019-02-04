<?php

class NauczycielorganizerKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
      
    }

    function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();

        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('notatki', $model->pobierznotatki(20));
        $widok->setOpcje('linki', $model->linkinotatki(20));
        $widok->index();
    }

    function nowanotatka() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();

        $model->nowanotatka();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->nowanotatka();
    }

    function edytujnotatka() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();

        $model->notatkaedycja();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('danenotatka', $model->notatkaedycja());
        $widok->edytujnotatka();
    }
function notatkausun(){
    $model = $this->ladujmodel();
    
    $model->usunnotatka();
    $this->przekierowanie('../../organizer.html/index');
}
function notatkastrona(){
    $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('notatki', $model->nastepnenotatki(20));
        $widok->setOpcje('linki', $model->linkinotatki(20));
        $widok->index();
}
    function strona() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('wyswietlogloszenia', $model->nastepneogloszenia(10));
        $widok->setOpcje('linkistron', $model->wyswietllinkiogloszenia(10));
        $widok->index();
    }

    function nauczycielzajecia() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        if ($model->sprawdzdzien() == 'dodajdzien') {
            $this->przekierowanie('../organizer.html/dodajdzien/' . $model->getDzien());
        }
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('zajeciadnityg', $model->dnitygodnianauczyciel());
        $widok->setOpcje('godzinyzajec', $model->godzinyzajec());
        $widok->setOpcje('przedmioty', $model->przedmiotynauczyciel());
        $widok->planzajec();
    }

    function dodajdzien($url = null) {
        
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->nowydziendodaj($url);
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('dziennr', @$this->url[2]);
        $widok->setOpcje('listaklas', $model->wybierzklasy());
        $widok->setOpcje('godzinyzajecia', $model->wybierzgodzinyzajec());
        $widok->setOpcje('przedmiotyszkola', $model->wybierzprzedmioty());
        $widok->setOpcje('formlink', $model->sesjalink());
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('bladdodajdane', $model->getDane());
        $widok->dodajdzien();
    }

    function edytujdzien() {
        
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();

        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('listazajec', $model->edycjadnia());
        $widok->setOpcje('dziennr', @$this->url[2]);
        $widok->edycjadnia();
        if ($model->edycjadnia() == 'przeslijdane') {
            $this->przekierowanie('../edytujgodzine/' . $model->getDzien());
        }
    }

    function edytujgodzine() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        if ($model->edytujgodzine()) {
            $linkdzienedycja = $_SESSION['godzinadane']['Dzien_Tygodnia'];
            unset($_SESSION['godzinadane']);
            $this->przekierowanie('../edytujdzien/' . $linkdzienedycja);
        }
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('dziennr', @$this->url[2]);
        $widok->setOpcje('listaklas', $model->wybierzklasy());
        $widok->setOpcje('godzinyzajecia', $model->wybierzgodzinyzajec());
        $widok->setOpcje('przedmiotyszkola', $model->wybierzprzedmioty());
        $widok->setOpcje('formlink', $model->sesjalink());
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('bladdodajdane', $model->getDane());
        $widok->dodajdzien();
    }

    function godzinausun() {
        $model = $this->ladujmodel();
        $model->usungodzine();
        $this->anulujedycje();
    }

    function anulujedycje() {
        if (isset($_SESSION['godzinadane'])) {
            $linkdzienedycja = $_SESSION['godzinadane']['Dzien_Tygodnia'];
            unset($_SESSION['godzinadane']);
            $this->przekierowanie('./edytujdzien/' . $linkdzienedycja);
        } else {
            $this->przekierowanie('./nauczycielzajecia');
        }
    }
function salenauczyciele(){
    $widok = $this->ladujwidok();
        $model = $this->ladujmodel();

        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('nauczyciele', $model->pobierznauczycieli());
        $widok->listanauczycieli();
}
}
