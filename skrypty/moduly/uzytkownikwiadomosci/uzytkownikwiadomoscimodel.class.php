<?php

class UzytkownikWiadomosciModel extends Model{
    private $tab = array();
    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }
    function wyswietlmenu() {
        return '<a href="' . $this->dolacz . 'wiadomosci.html">Wiadomości odebrane</a>
        <a href="' . $this->dolacz . 'wiadomosci.html/wiadwyslane">Wiadomości wysłane</a>
        <a href="' . $this->dolacz . 'wiadomosci.html/nowawiadomosc">Nowa wiadomość</a>';
    }
    function wiadodebrane($rekordownastrone, $url=null){
        $tablicadane = array();
        $listawiad = new ZapytaniaMysql();
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $listawiad->select('wiadomosci', 'Id_Wiadomosc, Id_Nadawca, Wiadomosc_Tytul, Id_Ranga_Odbiorca, Czyja_Wiadomosc, Stan');
        $listawiad->where('Id_Odbiorca', $_SESSION['UserId']);
        $listawiad->andmysql('Id_Ranga_Odbiorca', $_SESSION['RangaId']);
        $listawiad->andmysql('Czyja_Wiadomosc', 0);
        $listawiad->limit($od, $do);
        foreach ($listawiad->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC) as $w){
            $this->wiadszczegoly($w['Id_Wiadomosc'], 'Id_Nadawca', 'Nadawca'); 
        }
        return $listawiad->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
        
    }
    function wiadszczegoly($idwiadomosc, $kolumna, $rodzaj){
      
        $wiad = new ZapytaniaMysql();
        $daneosoba = new ZapytaniaMysql();
        $wiad->select('wiadomosci');
        $wiad->leftjoin('rodzaje_kont', 'Id_Ranga_'.$rodzaj, 'wiadomosci', 'Id_Ranga');
        $wiad->where('Id_Wiadomosc', $idwiadomosc);
        
        switch($wiad->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)['Ranga_Nazwa']){
            case 'Administrator_serwis':
                $daneosoba->select('konta_administratora');
                $daneosoba->leftjoin('rodzaje_kont', 'Id_Ranga', 'konta_administratora', 'Id_Ranga');
                $daneosoba->where('Id_Administrator', $wiad->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)[$kolumna]);
                $this->tab[$idwiadomosc] = $daneosoba->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                break;
            case 'Szkola':
                $daneosoba->select('szkoly');
                $daneosoba->leftjoin('rodzaje_kont', 'Id_Ranga', 'szkoly', 'Id_Ranga');
                $daneosoba->where('Id_Szkola', $wiad->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)[$kolumna]);
                $this->tab[$idwiadomosc] = $daneosoba->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                break;
            case 'Nauczyciel':
                $daneosoba->select('konta_nauczyciele');
                $daneosoba->leftjoin('rodzaje_kont', 'Id_Ranga', 'konta_nauczyciele', 'Id_Ranga');
                $daneosoba->where('Id_Nauczyciel', $wiad->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)[$kolumna]);
                $this->tab[$idwiadomosc] = $daneosoba->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                break;
            case 'Uczen':
                $daneosoba->select('konta_uczniowie');
                $daneosoba->leftjoin('rodzaje_kont', 'Id_Ranga', 'konta_uczniowie', 'Id_Ranga');
                $daneosoba->where('Id_Uczen', $wiad->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)[$kolumna]);
                $this->tab[$idwiadomosc] = $daneosoba->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                break;
        }
        
    }
    function wiadwyslane($rekordownastrone, $url=null){
        
        $tablicadane = array();
        $listawiad = new ZapytaniaMysql();
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $listawiad->select('wiadomosci', 'Id_Wiadomosc, Id_Nadawca, Wiadomosc_Tytul, Id_Ranga_Odbiorca, Czyja_Wiadomosc, Stan');
        $listawiad->where('Id_Nadawca', $_SESSION['UserId']);
        $listawiad->andmysql('Czyja_Wiadomosc', 1);
        $listawiad->andmysql('Id_Ranga_Nadawca', $_SESSION['RangaId']);
        $listawiad->limit($od, $do);
        foreach ($listawiad->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC) as $w){
            $this->wiadszczegoly($w['Id_Wiadomosc'], 'Id_Odbiorca', 'Odbiorca');
        }
        return $listawiad->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
        
    }
    function wyswietlszczegoly(){
        return $this->tab;
    }
    function listujwiadomosci(){
        return $this->wiadodebrane(20);
    }
    function wiadomosciwyslane(){
        return $this->wiadwyslane(20);
    }
    function kolejnewyslane(){
        return $this->wiadwyslane(20, $this->url[2]);
    }
    function kolejnewiadomosci(){
        return $this->wiadodebrane(20, $this->url[2]);
    }
    
    function wyswietllinkistron($rekordownastrone, $url = null) {

        $listawiad = new ZapytaniaMysql();
        $tab = array();
        $listawiad->select('wiadomosci', 'Id_Wiadomosc, Id_Nadawca, Wiadomosc_Tytul, Stan');
        $listawiad->where('Id_Odbiorca', $_SESSION['UserId']);
        $listawiad->andmysql('Id_Ranga_Odbiorca', $_SESSION['RangaId']);
        $listawiad->andmysql('Czyja_Wiadomosc', 0);
        
        if(($listawiad->wykonajpytanie()->rowCount() % $rekordownastrone == 1) && ($listawiad->wykonajpytanie()->rowCount() > $rekordownastrone)){
            
    $dodaj = 1;
}
else{
    $dodaj = 0;
}

        for ($i = $url * $rekordownastrone; $i < floor($listawiad->wykonajpytanie()->rowCount() / $rekordownastrone)+$dodaj; $i++) {
            $tab[] = $i;
        }
        return $tab;

    }
    function wyswietllinkiwyslane($rekordownastrone, $url = null) {

        $listawiad = new ZapytaniaMysql();
        $tab = array();
        $listawiad->select('wiadomosci', 'Id_Wiadomosc, Id_Nadawca, Wiadomosc_Tytul, Id_Ranga_Odbiorca, Czyja_Wiadomosc, Stan');
        $listawiad->where('Id_Nadawca', $_SESSION['UserId']);
        $listawiad->andmysql('Czyja_Wiadomosc', 1);
        $listawiad->andmysql('Id_Ranga_Nadawca', $_SESSION['RangaId']);
        
if(($listawiad->wykonajpytanie()->rowCount() % $rekordownastrone == 1) && ($listawiad->wykonajpytanie()->rowCount() > $rekordownastrone)){
    $dodaj = 1;
}
else{
    $dodaj = -1;
}

        for ($i = $url * $rekordownastrone; $i < floor($listawiad->wykonajpytanie()->rowCount() / $rekordownastrone)+$dodaj; $i++) {
            $tab[] = $i;
        }
        return $tab;

    }
    
    function wybierzwiadomosc($czyjawiad){
        
        $listawiad = new ZapytaniaMysql();
        $wiadupdate = new ZapytaniaMysql();
        $wiadupdate->update('wiadomosci');
        $wiadupdate->setmysql('Stan', 1);
        $wiadupdate->where('Id_'.$czyjawiad, $_SESSION['UserId']);
        $wiadupdate->andmysql('Id_Ranga_'.$czyjawiad, $_SESSION['RangaId']);
        $wiadupdate->andmysql('Id_Wiadomosc', $this->url[2]);
        $wiadupdate->wykonajpytanie();
        $listawiad->select('wiadomosci');
        $listawiad->where('Id_'.$czyjawiad, $_SESSION['UserId']);
        $listawiad->andmysql('Id_Ranga_'.$czyjawiad, $_SESSION['RangaId']);
        $listawiad->andmysql('Id_Wiadomosc', $this->url[2]);
        foreach ($listawiad->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC) as $w){
            $this->wiadszczegoly($w['Id_Wiadomosc'], 'Id_Nadawca', 'Nadawca'); //????????????
        }
        return $listawiad->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    function wyswietlwyslana(){
        return $this->wybierzwiadomosc("Odbiorca");
    }
    function wyswietlodebrana(){
        $listawiad = new ZapytaniaMysql();
        $wiadupdate = new ZapytaniaMysql();
        $wiadupdate->update('wiadomosci');
        $wiadupdate->setmysql('Stan', 1);
        $wiadupdate->where('Id_Nadawca', $_SESSION['UserId']);
        $wiadupdate->andmysql('Id_Ranga_Nadawca', $_SESSION['RangaId']);
        $wiadupdate->andmysql('Id_Wiadomosc', $this->url[2]);
        $wiadupdate->wykonajpytanie();
        $listawiad->select('wiadomosci');
        $listawiad->where('Id_Nadawca', $_SESSION['UserId']);
        $listawiad->andmysql('Id_Ranga_Nadawca', $_SESSION['RangaId']);
        $listawiad->andmysql('Id_Wiadomosc', $this->url[2]);
        foreach ($listawiad->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC) as $w){
            $this->wiadszczegoly($w['Id_Wiadomosc'], 'Id_Nadawca', 'Odbiorca');
        }
        return $listawiad->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    function usunwiadomosc(){
        $listawiad = new ZapytaniaMysql();
        $licz = 0;
        if(isset($_POST['usunwiadomosci'])){
            if(isset($_POST['wiadomoscusun'])){
                
            $listawiad->deletein('wiadomosci', 'Id_Wiadomosc', $_POST['wiadomoscusun']);
            $listawiad->wykonajpytanie();
            return true;
            }
            else{
                return $this->setBlad("Wybierz wiadomość do usunięcia");
                
            }
        }
    }
    function nowawiadomosc(){
        
        if(!isset($_POST['wyslij'])){
        $tablica = array('wiadomosc_tytul', 'wiadomosc_tresc');
        $this->nullpost($tablica);
        }
        else{
            if($_POST['typ_szkoly'] != 'null' and !empty($_POST['wiadomosc_tytul']) and !empty($_POST['wiadomosc_tresc'])){
            $dzieltablice = explode('=>', $_POST['typ_szkoly']);
            
            $rodzajkonta = new ZapytaniaMysql();
            $rodzajkonta->select('rodzaje_kont');
            $rodzajkonta->where('Id_Ranga', $dzieltablice[1]);
            /*
            switch($rodzajkonta->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)['Ranga_Nazwa']){
                case 'Administrator_serwis':
                    $szkolaodbiorca = null;
                    break;
                default:
                    $szkolaodbiorca = $dzieltablice[0];
                    break;
                
            }
            switch($_SESSION['Ranga']){
                case 'Administrator_serwis':
                    $szkolanadawca = 'bbb';
                    break;
                default:
                    $szkolanadawca = $_SESSION['danezalogowany']['Id_Szkola'];
                    break;
            }
             */
            $zapiszdane = new ZapytaniaMysql();
            $zapiszdane->insert('wiadomosci', 'Wiadomosc_Tytul, Wiadomosc_Tresc, Id_Ranga_Odbiorca, Id_Odbiorca, Id_Ranga_Nadawca, Id_Nadawca, Data_Wyslania, Stan, Czyja_Wiadomosc',array($_POST['wiadomosc_tytul'],$_POST['wiadomosc_tresc'],$dzieltablice[1],$dzieltablice[0],$_SESSION['RangaId'],$_SESSION['UserId'],date('Y-m-d'),0,0));
            $zapiszdane->insert('wiadomosci', 'Wiadomosc_Tytul, Wiadomosc_Tresc, Id_Ranga_Odbiorca, Id_Odbiorca, Id_Ranga_Nadawca, Id_Nadawca, Data_Wyslania, Stan, Czyja_Wiadomosc',array($_POST['wiadomosc_tytul'],$_POST['wiadomosc_tresc'],$dzieltablice[1],$dzieltablice[0],$_SESSION['RangaId'],$_SESSION['UserId'],date('Y-m-d'),0,1));
            
            if($zapiszdane->wykonajpytanie()){
                $this->setBlad('Wysłano');
                
            }
            else{
                return $this->setBlad('Błąd wysyłania wiadomości');
                
            }
            }
            else{
                return $this->setBlad('Wypełnij wszystkie pola!!');
            }
        }
    }
    function listauzytkownikow(){
        $listauzytkownikow = new ZapytaniaMysql();
        switch($_SESSION['Ranga']){
            case 'Administrator_serwis':
                $listauzytkownikow->select('szkoly', 'Id_Szkola as Id, Nazwa_Szkoly as Nazwa, szkoly.Id_Ranga, Ranga_Nazwa As Nazwa_Rangi');
                $listauzytkownikow->leftjoin('rodzaje_kont', 'Id_Ranga', 'szkoly', 'Id_Ranga');
                $listauzytkownikow->unionall('Id_Administrator As Id, Imie As Nazwa, konta_administratora.Id_Ranga, Ranga_Nazwa As Nazwa_Rangi', 'konta_administratora');
                $listauzytkownikow->leftjoin('rodzaje_kont', 'Id_Ranga', 'konta_administratora', 'Id_Ranga');
            break;
        case 'Szkola':
                $listauzytkownikow->select('konta_administratora', 'Id_Administrator as Id, CONCAT(Imie," ", Nazwisko) As Nazwa, konta_administratora.Id_Ranga, Ranga_Nazwa as Nazwa_Rangi');
            $listauzytkownikow->leftjoin('rodzaje_kont', 'Id_Ranga', 'konta_administratora', 'Id_Ranga');
            $listauzytkownikow->unionall('Id_Nauczyciel as Id, CONCAT(Imie," ", Nazwisko) as Nazwa, konta_nauczyciele.Id_Ranga, Ranga_Nazwa as Nazwa_Rangi', 'konta_nauczyciele');
            $listauzytkownikow->leftjoin('rodzaje_kont', 'Id_Ranga', 'konta_nauczyciele', 'Id_Ranga');
            $listauzytkownikow->where('Id_Szkola', $_SESSION['UserId']);
            break;
        case 'Nauczyciel':
                $listauzytkownikow->select('szkoly', 'Id_Szkola as Id, Nazwa_Szkoly As Nazwa, szkoly.Id_Ranga, Ranga_Nazwa as Nazwa_Rangi');
            $listauzytkownikow->leftjoin('rodzaje_kont', 'Id_Ranga', 'szkoly', 'Id_Ranga');
            $listauzytkownikow->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
            $listauzytkownikow->unionall('Id_Nauczyciel as Id, CONCAT(Imie," ", Nazwisko) as Nazwa, konta_nauczyciele.Id_Ranga, Ranga_Nazwa as Nazwa_Rangi', 'konta_nauczyciele');
            $listauzytkownikow->leftjoin('rodzaje_kont', 'Id_Ranga', 'konta_nauczyciele', 'Id_Ranga');
            $listauzytkownikow->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
            break;
        
        case 'Uczen':
                
            $listauzytkownikow->select('konta_nauczyciele', 'Id_Nauczyciel as Id, CONCAT(Imie," ", Nazwisko) as Nazwa, konta_nauczyciele.Id_Ranga, Ranga_Nazwa as Nazwa_Rangi');
            $listauzytkownikow->leftjoin('rodzaje_kont', 'Id_Ranga', 'konta_nauczyciele', 'Id_Ranga');
            $listauzytkownikow->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
            $listauzytkownikow->andmysql('Ranga_Nazwa', 'Nauczyciel');
            break;
        }
        
        return $listauzytkownikow->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
}
