<?php

class NauczycielorganizerModel extends Model {

    private $blad;
private $plan;
    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    function wyswietlmenu() {
        $menu = array(
            '<a href="' . $this->dolacz . 'organizer.html">Notatki</a>',
            '<a href="' . $this->dolacz . 'organizer.html/nauczycielzajecia">Plan zajęć</a>',
            ' <a href="' . $this->dolacz . 'organizer.html/salenauczyciele">Nauczyciele i sale</a>');
        return implode(' ', $menu);
    }
function pobierznotatki($rekordownastrone, $url = null){
    
    if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
    
    
    $pytanie = new ZapytaniaMysql();
    $pytanie->select('notatki');
    $pytanie->where('Id_Nauczyciel', $_SESSION['UserId']);
    $pytanie->limit($od, $do);
    
    return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
}
function linkinotatki($rekordownastrone, $url = null){
    $pytanie = new ZapytaniaMysql();
        $tab = array();
        $pytanie->select('notatki');
    $pytanie->where('Id_Nauczyciel', $_SESSION['UserId']);

        for ($i = $url * $rekordownastrone; $i < floor($pytanie->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }
        return $tab;
}
function nastepnenotatki($rekordownastrone){
    return $this->pobierznotatki($rekordownastrone, $this->url[2]);
}
function nowanotatka(){
    $tablica = array('tytul', 'tresc');
    if(isset($_POST['zapisznotatka'])){
        $pytanie = new ZapytaniaMysql();
        $pytanie->insert('notatki', 'Notatka_Tytul, Notatka_Tresc, Data_Utworzenia, Id_Nauczyciel', 
                array($_POST['tytul'],$_POST['tresc'],date('Y-m-d'),$_SESSION['UserId']));
        if($pytanie->wykonajpytanie()){
            $this->nullpost($tablica);
        }
    }
    else{
        $this->nullpost($tablica);
    }
}
function notatkaedycja(){
    $pytanie = new ZapytaniaMysql();
    $pytanie->select('notatki');
    $pytanie->where('Id_Notatka', $this->url[2]);
    $pytanie->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
    $dane =$pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    
    if(!isset($_POST['zapisznotatka'])){
        $_POST['tytul'] = $dane['Notatka_Tytul'];
        $_POST['tresc'] = $dane['Notatka_Tresc'];
    }
    else{
        $pytanie2 = new ZapytaniaMysql();
        $pytanie2->update('notatki');
        $pytanie2->setmysql('Notatka_Tytul', $_POST['tytul']);
        $pytanie2->setmysql('Notatka_Tresc', $_POST['tresc']);
        $pytanie2->where('Id_Notatka', $this->url[2]);
        $pytanie2->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie2->wykonajpytanie();
    }
    return $dane;
}
function usunnotatka(){
    $pytanie = new ZapytaniaMysql();
    $pytanie->delete('notatki');
    $pytanie->where('Id_Notatka', $this->url[2]);
        $pytanie->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie->wykonajpytanie();
}
    function sprawdzdzien() {
            $this->dnitygodnianauczyciel();
            $this->godzinyzajec();
            $this->przedmiotynauczyciel();
        if(isset($_POST['dodajdzien'])){
            $sprawdzdzien = new ZapytaniaMysql();
            $sprawdzdzien->select('plany_zajec_nauczyciele');
            $sprawdzdzien->where('Id_Nauczyciel', $_SESSION['UserId']);
            $sprawdzdzien->andmysql('Dzien_Tygodnia', $_POST['dzientyg']);
            if($sprawdzdzien->wykonajpytanie()->rowCount() == 0){
                $this->setDzien($_POST['dzientyg']);
                return 'dodajdzien';
            }
            else{
                $this->setBlad('Taki dzień juz istnieje');
            }
        }
    }
    function setDzien($dane){
        $this->dzien = $dane;
    }
    function getDzien(){
        return $this->dzien;
    }
    
    function nowydziendodaj($url = null){
        if(!isset($_POST['dodajdzien'])){
            $tablica = array('klasa', 'godzinyzajec', 'przedmiot', 'salanr');
            $this->nullpost($tablica);
        }
        $this->wybierzklasy();
        $this->wybierzgodzinyzajec();
        $this->wybierzprzedmioty();
        
        if(isset($_POST['dodajdzien'])){
            if(($_POST['klasa'] != "null") && ($_POST['godzinazajec']) != "null" && ($_POST['przedmiot'] != "null") && !empty($_POST['salanr'])){
                $pytanie = new ZapytaniaMysql;
                $pytanie->select('plany_zajec_nauczyciele');
                $pytanie->leftjoin('konta_nauczyciele', 'Id_Nauczyciel', 'plany_zajec_nauczyciele', 'Id_Nauczyciel');
                $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'plany_zajec_nauczyciele', 'Id_Przedmiot');
                $pytanie->where('Id_Godzina_Zajec', $_POST['godzinazajec']);
                $pytanie->andmysql('Dzien_Tygodnia', $this->url[2]);
                
                $dolaczpytanie2 = clone $pytanie;
                $dolaczpytanie2->andmysql('plany_zajec_nauczyciele.Id_Nauczyciel', $_SESSION['UserId']);
                
                $dolaczpytanie = clone $pytanie;
                $dolaczpytanie->andmysql('Sala_Numer', $_POST['salanr']);
               
                $pytanie->andmysql('Id_Klasa', $_POST['klasa']);
                if($dolaczpytanie2->wykonajpytanie()->rowCount() == 0){
                if($pytanie->wykonajpytanie()->rowCount() == 0){
                    if($dolaczpytanie->wykonajpytanie()->rowCount() == 0){
                    $pytanie2 = new ZapytaniaMysql();
                    
                    $pytanie2->insert('plany_zajec_nauczyciele', 'Id_Nauczyciel, Id_Godzina_Zajec, Id_Przedmiot, Id_Klasa, Dzien_Tygodnia, Sala_Numer',
                            "".$_SESSION['UserId'].", ".$_POST['godzinazajec'].", ".$_POST['przedmiot'].", ".$_POST['klasa'].",".$this->url[2].", ".$_POST['salanr']."");
                    
                    
                    $pytanie2->wykonajpytanie();
                    $this->setBlad('Zapisano');
                    }
                    else{
                        $this->setBlad('Ta sala jest już zajęcta');
                        $this->setDane($dolaczpytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC));
                    }
                }
                else{
                    $this->setBlad('Tej klasie przypisano już zajęcia na tą godzinę');
                    $this->setDane($pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC));
                }
                }
                else{
                    $this->setBlad('Masz już zajęcia o tej godzinie');
                    $this->setDane($dolaczpytanie2->wykonajpytanie()->fetch(PDO::FETCH_ASSOC));
                }
            }
            else{
                $this->setBlad('Wypełnij wszystkie pola');
            }
        }
    }
    function wybierzklasy(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('wychowawcy_klas');
        $pytanie->leftjoin('klasy', 'Id_Nauczyciel', 'wychowawcy_klas', 'Id_Nauczyciel');
        $pytanie->where('wychowawcy_klas.Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function wybierzgodzinyzajec(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('godziny_zajec', 'Id_Godzina_Zajec, concat(Od, " - ", Do) As Godzina_Przedzial');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function wybierzprzedmioty(){//może sprawiać problemy
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('przedmioty_i_nauczyciele');//$pytanie->select('przedmioty');
        $pytanie->leftjoin('przedmioty', 'przedmioty_Id_Przedmiot', 'przedmioty_i_nauczyciele', 'Id_Przedmiot');//$pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);//dodane
        $pytanie->andmysql('konta_nauczyciele_Id_Nauczyciel', $_SESSION['UserId']);//dodane
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function dnitygodnianauczyciel(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->selectdistinct('plany_zajec_nauczyciele', 'Dzien_Tygodnia');
        $pytanie->where('Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie->orderby('Dzien_Tygodnia', "Asc");
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function godzinyzajec(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('godziny_zajec');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function przedmiotynauczyciel(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('plany_zajec_nauczyciele', 'plany_zajec_nauczyciele.Id_Przedmiot, Id_Godzina_Zajec, plany_zajec_nauczyciele.Id_Klasa, Klasa_Nazwa, Przedmiot_Nazwa,Dzien_Tygodnia, Sala_Numer');
        $pytanie->leftjoin('klasy', 'Id_Klasa', 'plany_zajec_nauczyciele', 'Id_Klasa');
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'plany_zajec_nauczyciele', 'Id_Przedmiot');
        $pytanie->where('plany_zajec_nauczyciele.Id_Nauczyciel', $_SESSION['UserId']);
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function edycjadnia(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('plany_zajec_nauczyciele');
        $pytanie->leftjoin('godziny_zajec', 'Id_Godzina_Zajec', 'plany_zajec_nauczyciele', 'Id_Godzina_Zajec');
        $dolaczpytanie = clone $pytanie;
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'plany_zajec_nauczyciele', 'Id_Przedmiot');
        $pytanie->leftjoin('klasy', 'Id_Klasa', 'plany_zajec_nauczyciele', 'Id_Klasa');
        $pytanie->where('plany_zajec_nauczyciele.Dzien_Tygodnia', $this->url[2]);
        $pytanie->andmysql('plany_zajec_nauczyciele.Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie->orderby('plany_zajec_nauczyciele.Id_Godzina_Zajec', "ASC");
        if(!empty($_POST['godzinanr'])){
            $dolaczpytanie->where('plany_zajec_nauczyciele.Id_Godzina_Zajec', $_POST['godzinanr']);
            $dolaczpytanie->andmysql('Dzien_Tygodnia', $this->url[2]);
            $dolaczpytanie->andmysql('plany_zajec_nauczyciele.Id_Nauczyciel', $_SESSION['UserId']);
            if($dolaczpytanie->wykonajpytanie()->rowCount() == 1){
                $_SESSION['godzinadane'] = $dolaczpytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                $this->setDzien($_POST['godzinanr']);
                return 'przeslijdane';
            }
            
        }
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function edytujgodzine(){
        if(isset($_SESSION['godzinadane'])){
           $danedzien = new ZapytaniaMysql;
           $danedzien->select('plany_zajec_nauczyciele');
           $danedzien->where('Dzien_Tygodnia', $_SESSION['godzinadane']['Dzien_Tygodnia']);
           $danedzien->andmysql('plany_zajec_nauczyciele.Id_Nauczyciel', $_SESSION['UserId']);
           $dolaczdane = clone $danedzien;
           $danedzien->andmysql('plany_zajec_nauczyciele.Id_Plan', $_SESSION['godzinadane']['Id_Plan']);
          
           $wynik = $danedzien->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
           if(!isset($_POST['dodajdzien'])){
           $_POST['klasa'] = $wynik['Id_Klasa'];
           $_POST['godzinazajec'] = $wynik['Id_Godzina_Zajec'];
           $_POST['przedmiot'] = $wynik['Id_Przedmiot'];
           $_POST['salanr'] = $wynik['Sala_Numer'];
           }
           else{
               $dolaczdane->andmysql('Id_Godzina_Zajec', $_POST['godzinazajec']);
               $zm =  $dolaczdane->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
               
               if(($zm['Id_Plan'] == $_SESSION['godzinadane']['Id_Plan']) or ($dolaczdane->wykonajpytanie()->rowCount() == 0)){
               $pytanie2 = new ZapytaniaMysql();
               $pytanie2->update('plany_zajec_nauczyciele');
                        $pytanie2->setmysql('Id_Klasa', $_POST['klasa']);
                        $pytanie2->setmysql('Id_Godzina_Zajec', $_POST['godzinazajec']);
                        $pytanie2->setmysql('Id_Przedmiot', $_POST['przedmiot']);
                        $pytanie2->setmysql('Sala_Numer', $_POST['salanr']);
                        $pytanie2->where('Id_Plan', $_SESSION['godzinadane']['Id_Plan']);
                        $pytanie2->andmysql('Id_Nauczyciel', $_SESSION['danezalogowany']['Id_Nauczyciel']);
                    $pytanie2->wykonajpytanie();
                    $this->setBlad('Zapisano');
                    return true;
           }
           else{
               $this->setBlad("Masz już w planie tą godzinę");
           }
           }
           
            }
            return false;
    }
    function usungodzine(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->delete('plany_zajec_nauczyciele');
        $pytanie->where('Id_Plan', $_SESSION['godzinadane']['Id_Plan']);
        $pytanie->andmysql('Id_Nauczyciel', $_SESSION['danezalogowany']['Id_Nauczyciel']);
        $pytanie->wykonajpytanie();
    }
    function sesjalink(){
        if(isset($_SESSION['godzinadane'])){
            return 'organizer.html/edytujgodzine/';
        }
        else{
            return 'organizer.html/dodajdzien/';
        }
    }
    function pobierznauczycieli(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('konta_nauczyciele');
        $pytanie->leftjoin('wychowawcy_klas', 'Id_Nauczyciel', 'konta_nauczyciele', 'Id_Nauczyciel');
        $pytanie->where('konta_nauczyciele.Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        $pytanie->orderby('Nazwisko', "ASC");
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>