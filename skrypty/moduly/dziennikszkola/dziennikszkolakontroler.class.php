<?php

class DziennikszkolaKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
        
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->index();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlklasy',$model->pobierzklasy(20));
        $widok->setOpcje('linkistron',$model->wyswietllinkiklasy(20));
        
        $widok->index();
    }
    function strona(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlklasy',$model->kolejnestrony(20));
        $widok->setOpcje('linkistron',$model->wyswietllinkiklasy(20));
        $widok->index();
    }
    function listyobecnosci(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->listyobecnosci(20);
        $model->getLiczsemestry();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlsemestry',$model->getLiczsemestry());
        $widok->setOpcje('przedmiotynauczyciel',$model->listaprzedmiotow());
        if(!isset($this->url[2])){
        $widok->setOpcje('listyobecnosci',$model->listyobecnosci(20));
        $widok->setOpcje('linkistron',$model->wyswietllinkinieobecnosci(20));
        $widok->wyswietllisty();
        }
        else{
            $funkcja = @$this->url[2];
            $this->$funkcja(); // dorobić urlerror
        }
    }
    function stronalisty(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->listyobecnosci(20);
        $model->getLiczsemestry();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlsemestry',$model->getLiczsemestry());
        $widok->setOpcje('przedmiotynauczyciel',$model->listaprzedmiotow());
        $widok->setOpcje('listyobecnosci',$model->nieobecnoscistrony(20));
        $widok->setOpcje('linkistron',$model->wyswietllinkinieobecnosci(20));
        $widok->wyswietllisty();
    }
    function dodajucznia(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->nowekonto();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('formlink',$model->getLinkformularz());
        $widok->uczenformularz();
    }
    function anulujsesje(){
        if(isset($_SESSION['klasadane'])){
            unset($_SESSION['klasadane']);
            unset($_SESSION['przedmiot']);
            unset($_SESSION['przedzialsemestr']);
            unset($_SESSION['przedzialoceny']);
        }
        $this->przekierowanie('../dziennik.html');
    }
    function dodajliste(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->klasauczniowie();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listauczniow',$model->klasauczniowie());
        $widok->nowalista();
    }
    function wyswietldzienlista(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        if($model->klasadzienobecnosci() == "usunliste"){
            $this->przekierowanie('../listyobecnosci');
        }
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('dzienlista',$model->klasadzienobecnosci());
        $widok->setOpcje('listauczniow',$model->pobierzuczniow());
        $widok->setOpcje('dnizajec',$model->getDnizajecia());
        $widok->setOpcje('listanieobecnych',$model->getListanieobecnych());
        $widok->wyswietlbledy($model->getBlad());
        $widok->tabelaobecnosci();
    }
    function obecnoscedycja(){
       $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->edytujobecnosc();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('daneuzytkownik',$model->edytujobecnosc());
        $widok->obecnoscedycja();
    }
    function listaocen(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->rodzajsredniej();
        $model->ocenyuczen();
        $model->getLiczsemestry();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlsemestry',$model->getLiczsemestry());
        $widok->setOpcje('sredniarodzaj',$model->rodzajsredniej());
        $widok->setOpcje('listauczniow',$model->pobierzuczniow());
        $widok->setOpcje('ocenyucznia',$model->ocenyuczen());
        $widok->ocenyprzedmiot();
    }
    function dodajocene(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        if($model->zapiszocena()){
            $this->przekierowanie('../listaocen');
        }
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaocen',$model->pobierzoceny());
        $widok->setOpcje('daneuczen',$model->pobierzucznia());
        $widok->setOpcje('pobierzwagi',$model->dodajwage());
        $widok->nowaocena();
    }
    function edytujocene(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $model->uczenocenaedycja();
        
        if($model->uczenocenaedycja() == "usunocene"){
            $this->przekierowanie('../../listaocen');
        }
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaocen',$model->pobierzoceny());
        $widok->setOpcje('daneuczen',$model->pobierzucznia());
        $widok->setOpcje('ocenaedycja',$model->uczenocenaedycja());
        $widok->setOpcje('listawag',$model->dodajwage());
        $widok->edycjaocena();
    }
    function dodajwagi(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->dodajwage();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('nauczycielwagi',$model->dodajwage());
        $widok->listawag();
    }
    function ocenakoncowa(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->dodajocenakoncowa();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaocen',$model->pobierzoceny());
        $widok->setOpcje('daneuczen',$model->pobierzucznia());
        $widok->setOpcje('ocenakoncowa',$model->dodajocenakoncowa());
        $widok->ocenakoniec();
    }
    function edytujwage(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->dodajwage();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wagaedycja', $model->wagaedycja());
        $widok->setOpcje('nauczycielwagi',$model->dodajwage());
        $widok->edycjawaga();
    }
    function usunwage(){
        $model = $this->ladujmodel();
        $model->usunwaga();
        $this->przekierowanie('../dodajwagi');
    }
    function terminarz(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('przedmiotynauczyciel',$model->listaprzedmiotow());
        $widok->setOpcje('powiadomienia',$model->nauczycielterminy());
        $widok->terminarz();
    }
    function nowytermin(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->dodajtermin();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('linkformularz',$model->linkformularz());
        $widok->dodajtermin();
    }
    function edytujtermin(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->terminedycja();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('linkformularz',$model->linkformularz());
        $widok->dodajtermin();
    }
    function usuntermin(){
        $model = $this->ladujmodel();
        $model->terminusun();
        $this->przekierowanie('../terminarz');
    }
}
