<?php

class KlasanauczycielKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->listanieobecnych();
        $model->getLiczsemestry();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlsemestry',$model->getLiczsemestry());
        $widok->setOpcje('przedmiotynauczyciel',$model->listaprzedmiotow());
        $widok->setOpcje('listauczniow',$model->pobierzuczniow());
        $widok->setOpcje('listanieobecnych',$model->listanieobecnych());
        $widok->wyswietlbledy($model->getBlad());
        $widok->index();
    }
    function obecnoscedycja(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->edytujobecnosc();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('daneuzytkownik',$model->edytujobecnosc());
        $widok->edycjaobecnosc();
    }
    function sesjausun(){
        unset($_SESSION['klasaprzedmiot']);
        unset($_SESSION['wychowawcaklasaobecnosc']);
        unset($_SESSION['wychowawcaklasaoceny']);
        $this->przekierowanie('../twoja_klasa.html/index');
    }
    function oceny(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->ocenyuczen();
        $model->getLiczsemestry();
        $model->rodzajsredniej();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('wyswietlsemestry',$model->getLiczsemestry());
        $widok->setOpcje('przedmiotynauczyciel',$model->klasaprzedmioty());
        $widok->setOpcje('sredniarodzaj',$model->rodzajsredniej());
        $widok->setOpcje('listauczniow',$model->pobierzuczniow());
        $widok->setOpcje('ocenyucznia',$model->ocenyuczen());
        
        $widok->ocenyuczniowie();
    }
    function podgladocena(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('uczenocena',$model->ocenapodglad());
        $widok->setOpcje('sredniarodzaj',$model->rodzajsredniej());
        $widok->sprawdzocena();
    }
    function uczniowie(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listauczniow',$model->pobierzuczniow());
        $widok->setOpcje('promocjeaktywne',$model->sprawdzpromocje());
        $widok->setOpcje('semestrzamkniety',$model->zamknijsemestr());
        $widok->wychowawcauczniowie();
    }
    function uczenszczegoly(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('promocjeaktywne',$model->sprawdzpromocje());
        $widok->setOpcje('semestrzamkniety',$model->zamknijsemestr());
        $widok->setOpcje('uczendane',$model->uczendane());
        $widok->uczeninfo();
    }
    function uczenedycja(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->uczenedycja();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('linkid',$model->uczendane());
        $widok->uczenformularz();
    }
    function uczenwyklucz(){
        $model = $this->ladujmodel();
        
        if($model->uczenklasyfikacja() == true){
            $this->przekierowanie('../uczniowie');
        }
        
    }
    function uczenprzyjmij(){
        $model = $this->ladujmodel();
        
        $model->przyjmijuczen();
        $this->przekierowanie('../nieklasyfikowani');
    }
    function hasloreset(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $model->resetujhaslo();
        $this->przekierowanie('../uczenszczegoly/'.@$this->url[2]);
    }
    function uczenusun(){
        $model = $this->ladujmodel();
        
        $model->usunucznia();
        $this->przekierowanie('../uczniowie');
    }
    function nieklasyfikowani(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listauczniow',$model->nieklasyfikowani());
        $widok->setOpcje('semestrzamkniety',$model->zamknijsemestr());
        $widok->listanieklasyfikowanych();
    }
}
