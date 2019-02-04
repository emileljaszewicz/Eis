<?php

class UczenzajeciaModel extends Model {

    private $blad;

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }
    function dnitygodniauczen(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->selectdistinct('plany_zajec_nauczyciele', 'Dzien_Tygodnia');
        $pytanie->where('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $pytanie->orderby('Dzien_Tygodnia', "Asc");
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function godzinyzajec(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('godziny_zajec');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function przedmiotyuczen(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('plany_zajec_nauczyciele', 'concat(Imie," ", Nazwisko) as Kto, plany_zajec_nauczyciele.Id_Przedmiot, Id_Godzina_Zajec, plany_zajec_nauczyciele.Id_Klasa, Przedmiot_Nazwa,Dzien_Tygodnia, plany_zajec_nauczyciele.Sala_Numer');
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'plany_zajec_nauczyciele', 'Id_Przedmiot');
        $pytanie->leftjoin('konta_nauczyciele', 'Id_Nauczyciel', 'plany_zajec_nauczyciele', 'Id_Nauczyciel');
        $pytanie->where('plany_zajec_nauczyciele.Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>