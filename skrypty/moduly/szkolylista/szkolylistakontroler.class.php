<?php

class SzkolyListaKontroler extends Kontroler {

    function __construct($kontroler, $url) {
        parent:: __construct($kontroler, $url);
        
    }

function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaszkol',$model->wyswietldane(40, 1));
        $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
        
        $widok->index();
    }
    function strona(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaszkol',$model->strona(40));
        $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
        $widok->index();
    }
    function szkolapokaz(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaszkol',$model->Szkolawyswietl());
        $widok->setOpcje('licencjadlugosc', $model->wyswietllicencja());
        $widok->wyswietlszkoly($model->Szkolawyswietl());
        $widok->szkoladane();
    }
    function szkoladodaj(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->wyswietlbledy($this->ladujmodel()->walidujdane());
        $widok->wyswietlszkoly($model->getWyswietlopcje(),$model->wyswietlmenu());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('formlink',$model->getLinkformularz());
        $widok->setOpcje('selectopcje',$model->getWyswietlopcje());
        $widok->dodajszkoly();
    }
    function szkolaedytuj(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->wyswietlbledy($model->walidujdane(@$this->url[2]));
        $widok->wyswietlszkoly($model->walidujdane(@$this->url[2]),$model->wyswietlmenu());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('formlink',$model->getLinkformularz());
        $widok->setOpcje('selectopcje',$model->getWyswietlopcje());
        $widok->dodajszkoly();
    }
    function szkolausun(){
        $model = $this->ladujmodel();
        $model->usunszkole();
        $this->przekierowanie('../index');
    }
    function szkolykategorie(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        if(isset($_POST['zapisz'])){
            if($model->kategoriadodaj()){
            $this->przekierowanie('szkolykategorie');
            }
            else{
                $widok->wyswietlbledy($model->getBlad());
            }
        }
        if(!isset($this->url[3])){
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listakategorii',$model->wyswietlkategorie(10));
        $widok->setOpcje('kategoriestrony',$model->wyswietlstronykategorii(10));
        $widok->kategorieszkol();
        }
        else{
            $this->katstrona();
        }
    }
    function katusun(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $model->kategoriausun();
        if($model->kategoriausun()){
        $this->przekierowanie('../szkolykategorie');
        }
        else{
            $widok->wyswietlbledy($model->getBlad());
            $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listakategorii',$model->wyswietlkategorie(10));
        $widok->setOpcje('kategoriestrony',$model->wyswietlstronykategorii(10));
        $widok->kategorieszkol();
        }
    }
    function katedycja(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('kategoriaedycja',$model->kategoriaedytuj());
        
        $widok->edytujkategorie();
    }
    function kategoriaupdate(){
        $model = $this->ladujmodel();
        $widok = $this->ladujwidok();
        
            if($model->kategoriaaktualizuj()){
            $this->przekierowanie('../szkolykategorie');
            }
            else{
                $widok->wyswietlbledy($model->getBlad());
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('kategoriaedycja',$model->kategoriaedytuj());
        $widok->edytujkategorie();
            }
        
    }
    function katstrona(){
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listakategorii',$model->katstrona(10));
        $widok->setOpcje('kategoriestrony',$model->wyswietlstronykategorii(10));
        $widok->kategorieszkol();
    }
    function szkolyakceptacje() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->setOpcje('podmenu',$model->wyswietlmenu());
        $widok->setOpcje('listaszkol',$model->wyswietldane(40, 0));
        $widok->setOpcje('linkistron',$model->wyswietllinkistron(40));
        $widok->index();
    }
    function szkolaakceptuj(){
        $model = $this->ladujmodel();
        $model->rejestracjaakcept(1);
        $this->przekierowanie('../szkolyakceptacje');
    }
    function szkoladezaktywuj(){
        $model = $this->ladujmodel();
        $model->rejestracjaakcept(0);
        $this->przekierowanie('../index');
    }
    function szkolaarchiwum(){
        $model = $this->ladujmodel();
        $model->rejestracjaakcept(2);
        $this->przekierowanie('../index');
    }
    function kluczreset(){
        $model = $this->ladujmodel();
        $model->resetujlicencja(5);
        $this->przekierowanie('../szkolapokaz/'.@$this->url[2]);
    }
    function hasloreset(){
        $model = $this->ladujmodel();
        $model->resetujhaslo();
        $this->przekierowanie('../szkolapokaz/'.@$this->url[2]);
    }
}
