<?php

class SzkolaogloszeniaModel extends Model {

    private $blad;

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    function wyswietlmenu() {
        if(($_SESSION['Ranga'] == 'Administrator_serwis') or ($_SESSION['Ranga'] == 'Szkola')){
        return 
        '<a href="' . $this->dolacz . 'ogloszenia.html">Ogłoszenia</a>
        <a href="' . $this->dolacz . 'ogloszenia.html/dodajnowe">Dodaj nowe</a>';
        }
        else{
            return '<a href="' . $this->dolacz . 'ogloszenia.html">Ogłoszenia</a>';
        }
    }
function pobierzogloszenia($rekordownastrone, $url = null){
    if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
    $pytanie = new ZapytaniaMysql();
    $pytanie->select('ogloszenia');
    $pytanie->leftjoin('rodzaje_kont', 'Id_Ranga_Nadawca', 'ogloszenia', 'Id_Ranga');
    $_SESSION['danezalogowany'];
    $_SESSION['Ranga'];
    
    switch($_SESSION['Ranga']){
                        case 'Administrator_serwis':
                            $pytanie->where('Id_Ranga_Nadawca', $_SESSION['UserId']);
                            $pytanie->ormysql('Id_Ranga_Odbiorca', $_SESSION['UserId']);//Sprawdzić jak działa
                            break;
                        case 'Szkola':
                            $pytanie->where('Id_Szkola', $_SESSION['UserId']);
                            $pytanie->ormysql('Id_Szkola', 0);
                            break;
                        case 'Nauczyciel':
                            $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
                            $pytanie->ormysql('Id_Ranga_Odbiorca', $_SESSION['danezalogowany']['Id_Szkola']); //Sprawdzić poprawność wyświetlania
                            break;
                        case 'Uczen':
                            $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
                            $pytanie->andmysql('Do_Kogo', 0);
                            break;
                        
                    }
                    
    $pytanie->limit($od, $do);
    return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
}
function kolejnestrony($rekordownastrone){
    return $this->pobierzszkoly($rekordownastrone, $this->url[2]);
}
function wyswietllinkiogloszenia($rekordownastrone, $url = null) {

        $pytanie = new ZapytaniaMysql();
        $tab = array();
        $pytanie->select('ogloszenia');
        
        switch($_SESSION['Ranga']){
                        case 'Administrator_serwis':
                            $pytanie->where('Id_Ranga_Nadawca', $_SESSION['UserId']);
                            $pytanie->ormysql('Id_Ranga_Odbiorca', $_SESSION['UserId']);//Sprawdzić jak działa
                            break;
                        case 'Szkola':
                            $pytanie->where('Id_Szkola', $_SESSION['UserId']);
                            $pytanie->ormysql('Id_Szkola', 0);
                            break;
                        case 'Nauczyciel':
                            $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
                            $pytanie->ormysql('Id_Ranga_Odbiorca', $_SESSION['danezalogowany']['Id_Szkola']); //Sprawdzić poprawność wyświetlania
                            break;
                        case 'Uczen':
                            $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
                            $pytanie->andmysql('Do_Kogo', 0);
                            break;
                        
                    }
        
        for ($i = $url * $rekordownastrone; $i < floor($pytanie->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }
    function nastepneogloszenia($rekordownastrone){
        return $this->pobierzogloszenia($rekordownastrone, $this->url[2]);
    }
    function noweogloszenie(){
        if(isset($_POST['wyslij'])){
            $dzieldane = explode("=>", $_POST['danewysylka']);
            $dodajdane = new ZapytaniaMysql();
            $dodajdane->insert('ogloszenia', 'Ogloszenie_Tytul, Ogloszenie_Tresc, Id_Ranga_Nadawca, Id_Ranga_Odbiorca, Id_Szkola, Do_Kogo, Data_Wyslania'
                    , array($_POST['ogloszenie_tytul'],$_POST['ogloszenie_tresc'],$_SESSION['RangaId'],$dzieldane[1],$dzieldane[0],$_POST['daneodczyt'],date('Y-m-d')));
            return $dodajdane->wykonajpytanie();
        }
        else{
            $tablica = array('ogloszenie_tytul', 'ogloszenie_tresc');
            $this->nullpost($tablica);
        }
    }
    function listaodbiorcow(){
        $pytanie = new ZapytaniaMysql();
        
        switch($_SESSION['Ranga']){
                        case 'Administrator_serwis':
                            $pytanie->select('rodzaje_kont', 'Id_Ranga As Id_Rekord, Ranga_Nazwa As Nazwa_Rangi, Id_Ranga');
                            $pytanie->where('Ranga_Nazwa', 'Administrator_serwis');
                            $pytanie->unionselect('rodzaje_kont', 'Id_Ranga As Id_Rekord, Ranga_Nazwa As Nazwa_Rangi, Id_Ranga');
                            $pytanie->where('Ranga_Nazwa', 'Szkola');
                            
                            break;
                        case 'Szkola':
                            $pytanie->select('szkoly', 'Id_Szkola As Id_Rekord, Nazwa_Szkoly As Nazwa_Rangi, Id_Ranga');
                            $pytanie->where('Id_Szkola', $_SESSION['UserId']);
                            break;
                    }
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
function usunogloszenie(){
    $usundane = new ZapytaniaMysql();
    $usundane->delete('ogloszenia');
    $usundane->where('Id_Ogloszenie', $this->url[2]);
    if($_SESSION['Ranga'] == "Szkola"){
    $usundane->andmysql('Id_Szkola', $_SESSION['UserId']);
    $usundane->andmysql('Id_Ranga_Nadawca', $_SESSION['RangaId']);
    }
    if($_SESSION['Ranga'] == "Administrator_serwis"){
    $usundane->andmysql('Id_Ranga_Nadawca', $_SESSION['RangaId']);
    
    }
    $usundane->wykonajpytanie();
}
}

?>