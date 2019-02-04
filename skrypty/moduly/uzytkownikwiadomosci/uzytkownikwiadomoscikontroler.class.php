<?php

class UzytkownikWiadomosciKontroler extends Kontroler{
    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
        
    }
    function index(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('wiadlista', $model->listujwiadomosci());
        $widok->setOpcje('wiadomoscszczegoly', $model->wyswietlszczegoly());
        $widok->setOpcje('wiadstrony', $model->wyswietllinkistron(20));
        $widok->listawiadomosci();
    }
    function wiadpokaz(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('czytajwiadomosc', $model->wyswietlwyslana());
        $widok->setOpcje('wiadomoscszczegoly', $model->wyswietlszczegoly());
        $widok->wiadczytaj();
    }
    function pokazwyslana(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('czytajwiadomosc', $model->wyswietlodebrana());
        $widok->wiadwyslana();
    }
    function wiadomoscstrona(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('wiadlista', $model->kolejnewiadomosci());
        $widok->setOpcje('wiadstrony', $model->wyswietllinkistron(20));
        $widok->setOpcje('wiadomoscszczegoly', $model->wyswietlszczegoly());
        $widok->listawiadomosci();
    }
    
    function wiadusun(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        if($model->usunwiadomosc()){
            $this->przekierowanie('../wiadomosci.html');
        }
        else{
            $widok->wyswietlbledy($model->getBlad());
           $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('wiadlista', $model->listujwiadomosci());
        $widok->setOpcje('wiadomoscszczegoly', $model->wyswietlszczegoly());
        $widok->setOpcje('wiadstrony', $model->wyswietllinkistron(20));
        $widok->listawiadomosci();
        }
    }
    function nowawiadomosc(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('selectopcje', $model->listauzytkownikow());
        if($model->nowawiadomosc()){
            $this->przekierowanie('../wiadomosci.html/nowawiadomosc');
        }
        else{
            $widok->wyswietlbledy($model->getBlad());
        }
        $widok->wiadomoscformularz();
    }
    function wiadwyslane(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('wiadlista', $model->wiadomosciwyslane());
        $widok->setOpcje('wiadomoscszczegoly', $model->wyswietlszczegoly());
        $widok->setOpcje('wiadstrony', $model->wyswietllinkiwyslane(20));
        $widok->wiadwyslane();
    }
    function wyslanestrona(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $widok->setOpcje('podmenu', $model->wyswietlmenu());
        $widok->setOpcje('wiadlista', $model->kolejnewyslane());
        $widok->setOpcje('wiadomoscszczegoly', $model->wyswietlszczegoly());
        $widok->setOpcje('wiadstrony', $model->wyswietllinkiwyslane(20));
        $widok->wiadwyslane();
    }
}

