<?php

class KlasanauczycielModel extends Model {
    private $tab = array();
    private $blad;

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }
    function wyswietlmenu() {
        $menu = array(
            '<a href="' . $this->dolacz . 'twoja_klasa.html">Frekwencje uczniów</a>',
            '<a href="' . $this->dolacz . 'twoja_klasa.html/oceny">Oceny</a>',
            '<a href="' . $this->dolacz . 'twoja_klasa.html/uczniowie">Lista uczniów</a>',
            '<a href="' . $this->dolacz . 'twoja_klasa.html/nieklasyfikowani">Uczniowie nieklasyfikowani</a>');
        return implode(' ', $menu);
    }
    function listaprzedmiotow() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('plany_zajec_nauczyciele', 'distinct(plany_zajec_nauczyciele.Id_Przedmiot), Przedmiot_Nazwa');
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'plany_zajec_nauczyciele', 'Id_Przedmiot');
        $pytanie->where('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $kopiujobiekt = clone $pytanie;
        if(isset($_POST['sesjaprzedmiot'])){
            if(empty($_POST['przedmiotid'])){
               $_POST['przedmiotid'] = null;
            }
            $kopiujobiekt->andmysql('plany_zajec_nauczyciele.Id_Przedmiot', $_POST['przedmiotid']);
            $_SESSION['klasaprzedmiot'] = $kopiujobiekt->wykonajpytanie()->fetch();
        }
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function pobierzuczniow() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('uczen_dane');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        $pytanie->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $pytanie->orderby('Nazwisko', 'ASC');

        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function listanieobecnych() {
        if(isset($_SESSION['klasaprzedmiot'])){
            if(!isset($_SESSION['wychowawcaklasaobecnosc'])){
                $_SESSION['wychowawcaklasaobecnosc'] = null;
            }
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('nieobecnosci');
        $pytanie->leftjoin('listy_nieobecnosci', 'Id_Lista_Nieobecnosc', 'nieobecnosci', 'Id_Lista_Nieobecnosc');
        $pytanie->leftjoin('uczen_dane', 'Id_Uczen', 'nieobecnosci', 'Id_Uczen');
        $pytanie->where('listy_nieobecnosci.Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $pytanie->andmysql('listy_nieobecnosci.Id_Przedmiot', $_SESSION['klasaprzedmiot']['Id_Przedmiot']);
        $kopiujdane = clone $pytanie;
        $this->setLiczsemestry($kopiujdane->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC), 'Data_Listy', 'wychowawcaklasaobecnosc');
        if($kopiujdane->wykonajpytanie()->rowCount() > 0){
        $pytanie->andmysql('Data_Listy', $_SESSION['wychowawcaklasaobecnosc'][0], ">=");
            $pytanie->andmysql('Data_Listy', $_SESSION['wychowawcaklasaobecnosc'][1], "<=");
        }
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    function edytujobecnosc() {
        if(isset($_SESSION['klasaprzedmiot'])){
        if(!isset($this->url[2])){
            $this->url[2] = null;
           
        }
        if(!isset($this->url[3])){
            $this->url[3] = null;
            
        }
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('nieobecnosci');
        $pytanie1->leftjoin('listy_nieobecnosci', 'Id_Lista_Nieobecnosc', 'nieobecnosci', 'Id_Lista_Nieobecnosc');
        $pytanie1->leftjoin('przedmioty', 'Id_Przedmiot', 'listy_nieobecnosci', 'Id_Przedmiot');
        $pytanie1->leftjoin('konta_Uczniowie', 'Id_Uczen', 'nieobecnosci', 'Id_Uczen');
        $pytanie1->where('nieobecnosci.Id_Nieobecnosc', $this->url[2]);
        $pytanie1->andmysql('nieobecnosci.Id_Uczen', $this->url[3]);
        $pytanie1->andmysql('listy_nieobecnosci.Id_Przedmiot', $_SESSION['klasaprzedmiot']['Id_Przedmiot']);
        $daneuczen = $pytanie1->wykonajpytanie()->fetch();

        if (isset($_POST['zapiszobecnosc'])) {
            $pytanie2 = new ZapytaniaMysql();
            $pytanie3 = new ZapytaniaMysql();

            switch ($_POST['uczenobecnosc']) {

                case null:

                    $pytanie3->delete('nieobecnosci');
                    $pytanie3->where('Id_Nieobecnosc', $daneuczen['Id_Nieobecnosc']);
                    $pytanie3->wykonajpytanie();

                    break;
                default:

                    $pytanie2->select('nieobecnosci');
                    $pytanie2->where('Id_Nieobecnosc', $daneuczen['Id_Nieobecnosc']);
                    $pytanie2->andmysql('Id_Lista_Nieobecnosc', $daneuczen['Id_Lista_Nieobecnosc']);

                    if ($pytanie2->wykonajpytanie()->rowCount() == 1) {
                        $pytanie3->update('nieobecnosci');
                        $pytanie3->setmysql('Rodzaj_Nieobecnosci', $_POST['uczenobecnosc']);
                        $pytanie3->where('Id_Nieobecnosc', $daneuczen['Id_Nieobecnosc']);
                        $pytanie3->wykonajpytanie();
                    } else {
                        $pytanie3->insert('nieobecnosci', 'Id_Uczen, Rodzaj_Nieobecnosci, Id_Lista_Nieobecnosc', "" . $daneuczen['Id_Uczen'] . "," . $_POST['uczenobecnosc'] . "," . $daneuczen['Id_Lista_Nieobecnosc'] . "");
                        $pytanie3->wykonajpytanie();
                    }
                    break;
            }
        }
        return $daneuczen;
        }
    }
    function klasaprzedmioty() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('plany_zajec_nauczyciele', 'distinct(plany_zajec_nauczyciele.Id_Przedmiot), Przedmiot_Nazwa');
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'plany_zajec_nauczyciele', 'Id_Przedmiot');
        $pytanie->where('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $kopiujobiekt = clone $pytanie;
        if(isset($_POST['sesjaprzedmiot'])){
            $kopiujobiekt->andmysql('plany_zajec_nauczyciele.Id_Przedmiot', $_POST['przedmiotid']);
            $_SESSION['klasaprzedmiot'] = $kopiujobiekt->wykonajpytanie()->fetch();
        }
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
function rodzajsredniej() {
        if (isset($_SESSION['przedmiot'])) {
            if(!isset($_SESSION['klasaprzedmiot'])){
                $_SESSION['klasaprzedmiot'] = null;
            }
            $pytanie = new ZapytaniaMysql();
            $pytanie->select('przedmioty_rodzaje_srednich', 'distinct(przedmioty_rodzaje_srednich.Id_Przedmiot),przedmioty_rodzaje_srednich.Id_Nauczyciel, Wartosc');
            $pytanie->leftjoin('oceny_uczniow', 'Id_Przedmiot', 'przedmioty_rodzaje_srednich', 'Id_Przedmiot');
            $pytanie->leftjoin('uczen_dane', 'Id_Uczen', 'oceny_uczniow', 'Id_Uczen');
            $pytanie->where('oceny_uczniow.Id_Przedmiot', $_SESSION['klasaprzedmiot']['Id_Przedmiot']);
            $pytanie->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        
            return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        }
    }
function ocenyuczen() {
        if (isset($_SESSION['klasaprzedmiot'])) {
             if (!isset($_SESSION['wychowawcaklasaoceny'])) {
                 $_SESSION['wychowawcaklasaoceny'] = null;
             }
            $pytanie = new ZapytaniaMysql();
            $pytanie->select('oceny_uczniow', 'Id_Ocena_Ucznia, Za_Co, lista_ocen.Ocena_Nazwa, Wartosc_Ocena, oceny_uczniow.Id_Przedmiot, konta_uczniowie.Id_Uczen, Data_Wystawienia, konta_uczniowie.Id_Klasa');
            $pytanie->leftjoin('konta_uczniowie', 'Id_Uczen', 'oceny_uczniow', 'Id_Uczen');
            $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
            $pytanie->where('konta_uczniowie.Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
            $pytanie->andmysql('oceny_uczniow.Id_Przedmiot', $_SESSION['klasaprzedmiot']['Id_Przedmiot']);
            $kopiujpytanie = clone $pytanie;
            $this->setLiczsemestry($kopiujpytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC), 'Data_Wystawienia', 'wychowawcaklasaoceny');
            if($kopiujpytanie->wykonajpytanie()->rowCount() > 0 && $_SESSION['wychowawcaklasaoceny'] != null){
            $pytanie->andmysql('Data_Wystawienia', $_SESSION['wychowawcaklasaoceny'][0], ">=");
            $pytanie->andmysql('Data_Wystawienia', $_SESSION['wychowawcaklasaoceny'][1], "<=");
            }
            return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    function liczsrednia($uczen) {
        
        if(sizeof($_SESSION['wychowawcaklasaoceny']) > 1){
        $dane = $this->rodzajsredniej()['Wartosc'];
        
        if (sizeof($dane) == 0) {
            $dane = 1;
        }
        $pytanie = new ZapytaniaMysql();
        switch ($dane) {
            case 1:
                $pytanie->select('oceny_uczniow', '(sum(lista_ocen.Wartosc_Ocena)/count(Id_Ocena_Ucznia)) As Wynik');
                $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
                $pytanie->where('oceny_uczniow.Id_Przedmiot', $_SESSION['klasaprzedmiot']['Id_Przedmiot']);
                $pytanie->andmysql('oceny_uczniow.Id_Uczen', $uczen);
                $pytanie->andmysql('Data_Wystawienia', $_SESSION['wychowawcaklasaoceny'][0], ">=");
                $pytanie->andmysql('Data_Wystawienia', $_SESSION['wychowawcaklasaoceny'][1], "<=");
                
                return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                break;
            case 2:
                $pytanie->select('oceny_uczniow', '(sum(lista_ocen.Wartosc_Ocena*oceny_uczniow.Ocena_Waga)/sum(oceny_uczniow.Ocena_Waga)) As Wynik');
                $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
                $pytanie->where('oceny_uczniow.Id_Przedmiot', $_SESSION['klasaprzedmiot']['Id_Przedmiot']);
                $pytanie->andmysql('oceny_uczniow.Id_Uczen', $uczen);
                $pytanie->andmysql('Data_Wystawienia', $_SESSION['wychowawcaklasaoceny'][0], ">=");
                $pytanie->andmysql('Data_Wystawienia', $_SESSION['wychowawcaklasaoceny'][1], "<=");
                return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                break;
        }
        }
    }
    function ocenapropozycja($srednia) {
        if ($srednia < 1.5) {
            return '1';
        }
        if (($srednia >= 1.5) && ($srednia < 2)) {
            return '1+';
        }
        if (($srednia >= 2) && ($srednia < 2.5)) {
            return '2';
        }
        if (($srednia >= 2.5) && ($srednia < 3)) {
            return '2+';
        }
        if (($srednia >= 3) && ($srednia < 3.5)) {
            return '3';
        }
        if (($srednia >= 3.5) && ($srednia < 4)) {
            return '3+';
        }
        if (($srednia >= 4) && ($srednia < 4.5)) {
            return '4';
        }
        if (($srednia >= 4.5) && ($srednia < 5)) {
            return '4+';
        }
        if (($srednia >= 5) && ($srednia < 5.5)) {
            return '5';
        }
        if (($srednia >= 5.5) && ($srednia < 6)) {
            return '5+';
        }
        if (($srednia >= 6)) {
            return '6';
        }
    }

    function ocenakoncowa($uczen) {
        if(empty($_SESSION['wychowawcaklasaoceny'][0]) && empty($_SESSION['wychowawcaklasaoceny'][1])){
            $_SESSION['wychowawcaklasaoceny'][0] = null;
            $_SESSION['wychowawcaklasaoceny'][1] = null;
        }
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('oceny_semestralne');
        $pytanie1->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_semestralne', 'Id_Ocena');
        $pytanie1->where('Id_Uczen', $uczen);
        $pytanie1->andmysql('Id_Przedmiot', $_SESSION['klasaprzedmiot']['Id_Przedmiot']);
        $pytanie1->andmysql('Data_Oceny', $_SESSION['wychowawcaklasaoceny'][0], ">=");
                $pytanie1->andmysql('Data_Oceny', $_SESSION['wychowawcaklasaoceny'][1], "<=");
                
        if ($pytanie1->wykonajpytanie()->rowCount() == 1) {
            return $pytanie1->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        } else {
            echo null;
        }
        
    }
    function ocenapodglad(){
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('oceny_uczniow');
        $pytanie1->leftjoin('uczen_dane', 'Id_Uczen', 'oceny_uczniow', 'Id_Uczen');
        $pytanie1->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
        $pytanie1->where('Id_Ocena_Ucznia', $this->url[2]);
        $pytanie1->andmysql('Id_Przedmiot', $_SESSION['klasaprzedmiot']['Id_Przedmiot']);
        $pytanie1->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        
        return $pytanie1->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    function uczendane(){
        $pytanie1  = new ZapytaniaMysql();
        $pytanie1->select('konta_uczniowie');
        $pytanie1->where('Id_Uczen', $this->url[2]);
        $pytanie1->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        
        return $pytanie1->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        
    }
    function uczenedycja(){
        $uczendane = $this->uczendane();
        if(!isset($_POST['zapisz'])){
        $_POST['imie'] = $uczendane['Imie'];
        $_POST['nazwisko'] = $uczendane['Nazwisko'];
        $_POST['email'] = $uczendane['Email'];
        $_POST['ulica'] = $uczendane['Ulica'];
        $_POST['budynek'] = $uczendane['Numer_budynku'];
        $_POST['mieszkanie'] = $uczendane['Numer_Mieszkania'];
        $_POST['kod'] = $uczendane['Kod_Pocztowy'];
        $_POST['miejscowosc'] = $uczendane['Miejscowosc'];
        $_POST['wojewodztwo'] = $uczendane['Wojewodztwo'];
        $_POST['pesel'] = $uczendane['Numer_Pesel'];
        }
        else{
            $pytanie = new ZapytaniaMysql();
            $pytanie->update('Konta_Uczniowie');
            $pytanie->setmysql('Imie', $_POST['imie']);
            $pytanie->setmysql('Nazwisko', $_POST['nazwisko']);
            $pytanie->setmysql('Email', $_POST['email']);
            $pytanie->setmysql('Ulica', $_POST['ulica']);
            $pytanie->setmysql('Numer_Budynku', $_POST['budynek']);
            $pytanie->setmysql('Numer_Mieszkania', $_POST['mieszkanie']);
            $pytanie->setmysql('Kod_Pocztowy', $_POST['kod']);
            $pytanie->setmysql('Miejscowosc', $_POST['miejscowosc']);
            $pytanie->setmysql('Wojewodztwo', $_POST['wojewodztwo']);
            $pytanie->setmysql('Numer_Pesel', $_POST['pesel']);
            $pytanie->where('Id_Uczen', $uczendane['Id_Uczen']);
            $pytanie->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
            
            $pytanie->wykonajpytanie();
        }
    }
    function resetujhaslo(){
        $klasa = new ZapytaniaMysql();
        $klasa->update('konta_uczniowie');
        $klasa->setnull('Login');
        $klasa->setmysql('Haslo', uniqid('', true));
        $klasa->where('Id_Uczen', $this->url[2]);
        $klasa->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $klasa->wykonajpytanie();
    }
    function usunucznia(){
        $klasa = new ZapytaniaMysql();
        $klasa->delete('konta_uczniowie');
        $klasa->where('Id_Uczen', $this->url[2]);
        $klasa->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $klasa->wykonajpytanie();
    }
    function sprawdzpromocje(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('okresy_promocyjne');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        
        return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    function uczenklasyfikacja(){
        $dane = $this->sprawdzpromocje();
        
        if($dane['Udzielanie_Promocji'] == 1){
            if($this->zamknijsemestr()['Koniec_Promocji'] == 0){
            $pytanie = new ZapytaniaMysql();
            $pytanie->insert('uczniowie_nieklasyfikowani', 'Id_Uczen, Id_Szkola', "".$this->url[2].",".$_SESSION['danezalogowany']['Id_Szkola']."");
            if($pytanie->wykonajpytanie()){
                $pytanie2 = new ZapytaniaMysql();
                $pytanie2->update('konta_uczniowie');
                $pytanie2->setnull('Id_Klasa');
                $pytanie2->where('Id_Uczen', $this->url[2]);
                $pytanie2->wykonajpytanie();
                
                return true;
            }
            }
        }
        return false;
    }
    function setLiczsemestry($tablica, $kolumnadaty, $nazwasesji) {
       $tab = array();
        if(isset($_SESSION['klasaprzedmiot'])){
             
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('semestry_podzial');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);

        $semestr = $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        $zm = $tablica;

        $datasemestr = null;
        
        foreach($zm as $zm){
    $zakres = explode('-', $zm[$kolumnadaty]);
    
    
    if((strtotime($zm[$kolumnadaty]) >= strtotime($zakres[0].'-'.$semestr['Semestr1_Od'])) && (strtotime($zm[$kolumnadaty]) <= strtotime($zakres[0].'-12-31'))){
        //echo $zm['Data_Listy'].' Semestr: '.$zakres[0].'/'.($zakres[0]+1).'[zimowy], Zakres danych: '.$zakres[0].'-'.$semestr['Semestr1_Od'].' do '.($zakres[0]+1).'-'.$semestr['Semestr1_Do'] ;
    
        if(($datasemestr[sizeof($datasemestr)-1]['Zakres'] != $zakres[0].'/'.($zakres[0]+1)) && ($datasemestr[sizeof($datasemestr)-1]['Ktory'] != "zimowy")){
        $tab[] = array('Zakres_Semestr' => $zakres[0].'-'.$semestr['Semestr1_Od'].'/'.($zakres[0]+1).'-'.$semestr['Semestr1_Do'],'Przedzial_Semestr' =>$zakres[0].'/'.($zakres[0]+1), 'Nazwa_Semestr' => '(zimowy)');
       
        $datasemestr[] = array("Zakres"=>$zakres[0].'/'.($zakres[0]+1), "Ktory" => "zimowy");
    }
        
    }
    if((strtotime($zm[$kolumnadaty]) >= strtotime($zakres[0].'-01-01')) && (strtotime($zm[$kolumnadaty]) <= strtotime($zakres[0].'-'.$semestr['Semestr1_Do']))){
        //echo $zm['Data_Listy'].' Semestr: '.($zakres[0]-1).'/'.$zakres[0].'[zimowy], Zakres danych: '.($zakres[0]-1).'-'.$semestr['Semestr1_Od'].' do '.$zakres[0].'-'.$semestr['Semestr1_Do'] ;
        if(($datasemestr[sizeof($datasemestr)-1]['Zakres'] != ($zakres[0]-1).'/'.$zakres[0]) && ($datasemestr[sizeof($datasemestr)-1]['Ktory'] != "zimowy")){
        $tab[] = array('Zakres_Semestr' => ($zakres[0]-1).'-'.$semestr['Semestr1_Od'].'/'.$zakres[0].'-'.$semestr['Semestr1_Do'],'Przedzial_Semestr' =>($zakres[0]-1).'/'.$zakres[0], 'Nazwa_Semestr' => '(zimowy)');
        $datasemestr[] = array("Zakres"=>($zakres[0]-1).'/'.$zakres[0], "Ktory" => "zimowy");
        }
        
        
    }
    if((strtotime($zm[$kolumnadaty]) >= strtotime($zakres[0].'-'.$semestr['Semestr2_Od'])) && (strtotime($zm[$kolumnadaty]) <= strtotime($zakres[0].'-'.$semestr['Semestr2_Do']))){
        //echo $zm['Data_Listy'].' Semestr: '.($zakres[0]-1).'/'.$zakres[0].'[letni], Zakres danych: '.$zakres[0].'-'.$semestr['Semestr2_Od'].' do '.$zakres[0].'-'.$semestr['Semestr2_Do'] ;
      
        if(($datasemestr[sizeof($datasemestr)-1]['Zakres'] != ($zakres[0]-1).'/'.$zakres[0]) && $datasemestr[sizeof($datasemestr)-1]['Ktory'] != "letni"){
    $tab[] = array('Zakres_Semestr' => $zakres[0].'-'.$semestr['Semestr2_Od'].'/'.$zakres[0].'-'.$semestr['Semestr2_Do'],'Przedzial_Semestr' =>($zakres[0]-1).'/'.$zakres[0], 'Nazwa_Semestr' => "(letni)");
    $datasemestr[] = array("Zakres"=>($zakres[0]-1).'/'.$zakres[0], "Ktory" => "letni");
     }  
     else if(($datasemestr[sizeof($datasemestr)-1]['Zakres'] == ($zakres[0]-1).'/'.$zakres[0]) && $datasemestr[sizeof($datasemestr)-1]['Ktory'] != "letni"){
    $tab[] = array('Zakres_Semestr' => $zakres[0].'-'.$semestr['Semestr2_Od'].'/'.$zakres[0].'-'.$semestr['Semestr2_Do'],'Przedzial_Semestr' =>($zakres[0]-1).'/'.$zakres[0], 'Nazwa_Semestr' => "(letni)");
    $datasemestr[] = array("Zakres"=>($zakres[0]-1).'/'.$zakres[0], "Ktory" => "letni");
     }      
    
    }
    //echo '<br>';
    
}
      if(isset($_POST['sesjasemestr'])){
          if(empty($_POST['data'])){
              $_POST['data'] = null;
          }
          $dzielprzedzial = explode("/", $_POST['data']);
          $_SESSION[$nazwasesji] = $dzielprzedzial;
      } 
        }
        
        $this->tab = $tab;
    }
 function getLiczsemestry(){
     return $this->tab;
 }
    function wyswietlbledy() {
        return $this->getBlad();
    }
    function nieklasyfikowani(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('uczniowie_nieklasyfikowani');
        $pytanie->leftjoin('konta_uczniowie', 'Id_Uczen', 'uczniowie_nieklasyfikowani', 'Id_Uczen');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        $pytanie->orderby('konta_uczniowie.Nazwisko', 'ASC');
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function przyjmijuczen(){
       if($this->zamknijsemestr()['Koniec_Promocji'] == 0){
            $pytanie2 = new ZapytaniaMysql();
            $pytanie3 = new ZapytaniaMysql();
            
            
                $pytanie2->update('konta_uczniowie');
                $pytanie2->setmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
                $pytanie2->where('Id_Uczen', $this->url[2]);
                $pytanie2->wykonajpytanie();
                
                
                
            
            
            $pytanie3->delete('uczniowie_nieklasyfikowani');
                $pytanie3->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
                $pytanie3->andmysql('Id_Uczen', $this->url[2]);
            $pytanie3->wykonajpytanie();
       }
        
    }
    function zamknijsemestr(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('klasy');
        $pytanie->where('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        
        if(isset($_POST['zamknijsemestr'])){
            $pytanie2 = new ZapytaniaMysql();
            $pytanie2->update('klasy');
            $pytanie2->setmysql('Koniec_Promocji', 1);
            $pytanie2->where('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
            $pytanie2->wykonajpytanie();
        }
        
        return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
}

?>