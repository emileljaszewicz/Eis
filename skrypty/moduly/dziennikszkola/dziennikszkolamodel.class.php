<?php

class DziennikszkolaModel extends Model {

    private $blad;
    private $tab = array();
    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    function wyswietlmenu() {
        return '<a href="' . $this->dolacz . 'dziennik.html">Wybierz klasę</a>
      <a href="' . $this->dolacz . 'dziennik.html/listyobecnosci">Listy obecności</a>
     <a href="' . $this->dolacz . 'dziennik.html/dodajucznia">Dodaj ucznia</a>
     <a href="' . $this->dolacz . 'dziennik.html/listaocen">Oceny</a>
     <a href="' . $this->dolacz . 'dziennik.html/terminarz">Terminarz</a>
                <a href="' . $this->dolacz . 'dziennik.html/dodajwagi">Lista Wag</a>';
    }

    function index() {
        if (!isset($_SESSION['klasadane'])) {
            $_SESSION['klasadane'] = null;
        }
        if (isset($_POST['sesja']) && !empty($_POST['klasa'])) {
            $pytanie = new ZapytaniaMysql();
            $pytanie->select('klasy');
            $pytanie->where('Id_Klasa', $_POST['klasa']);
            $_SESSION['klasadane'] = $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
            return $_SESSION['klasadane'];
        }
    }

    function pobierzklasy($rekordownastrone, $url = null) {
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('plany_zajec_nauczyciele', 'distinct(plany_zajec_nauczyciele.Id_Klasa), klasy.Id_Nauczyciel, wychowawcy_klas.Wychowawca_Klasa'
                . ', wychowawcy_klas.Klasa_Nazwa');
        $pytanie->leftjoin('klasy', 'Id_Klasa', 'plany_zajec_nauczyciele', 'Id_Klasa');
        $pytanie->leftjoin('wychowawcy_klas', 'Id_Nauczyciel', 'klasy', 'Id_Nauczyciel');
        $pytanie->where('plany_zajec_nauczyciele.Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie->limit($od, $do);
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }

    function kolejnestrony($rekordownastrone) {
        return $this->pobierzklasy($rekordownastrone, $this->url[2]);
    }

    function wyswietllinkiklasy($rekordownastrone, $url = null) {

        $pytanie = new ZapytaniaMysql();
        $tab = array();
        $pytanie->select('plany_zajec_nauczyciele', 'distinct(plany_zajec_nauczyciele.Id_Klasa), klasy.Id_Nauczyciel, wychowawcy_klas.Wychowawca_Klasa'
                . ', wychowawcy_klas.Klasa_Nazwa');
        $pytanie->leftjoin('klasy', 'Id_Klasa', 'plany_zajec_nauczyciele', 'Id_Klasa');
        $pytanie->leftjoin('wychowawcy_klas', 'Id_Nauczyciel', 'klasy', 'Id_Nauczyciel');
        $pytanie->where('plany_zajec_nauczyciele.Id_Nauczyciel', $_SESSION['UserId']);

        for ($i = $url * $rekordownastrone; $i < floor($pytanie->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }

    function listaprzedmiotow() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('przedmioty_i_nauczyciele');
        $pytanie->leftjoin('przedmioty', 'przedmioty_Id_Przedmiot', 'przedmioty_i_nauczyciele', 'Id_Przedmiot');
        $pytanie->where('konta_nauczyciele_Id_Nauczyciel', $_SESSION['UserId']);
        $kopiujobiekt = clone $pytanie;
        if (isset($_POST['sesjaprzedmiot']) && !empty($_POST['przedmiotid'])) {
            $kopiujobiekt->andmysql('przedmioty.Id_Przedmiot', $_POST['przedmiotid']);
            $_SESSION['przedmiot'] = $kopiujobiekt->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        }
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }

    function setLiczsemestry($tablica, $kolumnadaty, $nazwasesji) {
        $tab = array();
        if(isset($_SESSION['przedmiot'])){
            
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('semestry_podzial');
        $pytanie->where('Id_Szkola', $_SESSION['klasadane']['Id_Szkola']);

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
      if(isset($_POST['sesjasemestr']) && !empty($_POST['data'])){
          $dzielprzedzial = explode("/", $_POST['data']);
          $_SESSION[$nazwasesji] = $dzielprzedzial;
      } 
        }
        
        $this->tab = $tab;
    }
 function getLiczsemestry(){
     return $this->tab;
 }
    function listyobecnosci($rekordownastrone, $url = null) {
        
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        if (isset($_SESSION['przedmiot'])) {
                if(!isset($_SESSION['przedzialsemestr'])){
                    $_SESSION['przedzialsemestr'][0] = null;
                    $_SESSION['przedzialsemestr'][1] = null;
                }

            $pytanie = new ZapytaniaMysql();
            $pytanie->select('listy_nieobecnosci');
            $pytanie->where('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
            $pytanie->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
            $pytanie->andmysql('Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
            $kopiujdane = clone $pytanie;
            
            $this->setLiczsemestry($kopiujdane->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC), 'Data_Listy', 'przedzialsemestr');
            
            $pytanie->andmysql('Data_Listy', $_SESSION['przedzialsemestr'][0], ">=");
            $pytanie->andmysql('Data_Listy', $_SESSION['przedzialsemestr'][1], "<=");
            
            
            $pytanie->limit($od, $do);
            return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    function nieobecnoscistrony($rekordownastrone) {
        return $this->listyobecnosci($rekordownastrone, $this->url[3]);
    }

    function wyswietllinkinieobecnosci($rekordownastrone, $url = null) {

        $pytanie = new ZapytaniaMysql();
        $tab = array();
        if (isset($_SESSION['przedmiot'])) {
            $pytanie->select('listy_nieobecnosci');
            $pytanie->where('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
            $pytanie->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
            $pytanie->andmysql('Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
            $pytanie->andmysql('Data_Listy', $_SESSION['przedzialsemestr'][0], ">=");
            $pytanie->andmysql('Data_Listy', $_SESSION['przedzialsemestr'][1], "<=");

            for ($i = $url * $rekordownastrone; $i < floor($pytanie->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
                $tab[] = $i;
            }
        }
        return $tab;
    }

    function nowekonto() {

        $tablica = array('imie', 'nazwisko', 'ulica', 'budynek', 'mieszkanie', 'kod', 'miejscowosc', 'wojewodztwo', 'pesel', 'email');
        if (isset($_POST['zapisz'])) {
            $tab = null;
            if ($this->walidujformularz($_POST['imie'], 'tekst')) {
                $tab[] = $_POST['imie'];
            } else {
                $this->setBlad("Pole <b>Imię</b> może zawierać tylko litery!!");
            }
            if ($this->walidujformularz($_POST['nazwisko'], 'tekst')) {
                $tab[] = $_POST['nazwisko'];
            } else {
                $this->setBlad("Pole <b>Nazwisko</b> jest niepoprawne!!");
            }
            if ($this->walidujformularz($_POST['ulica'], 'tekst')) {
                $tab[] = $_POST['ulica'];
            } else {
                $this->setBlad("Pole <b>Ulica</b> może zawierać tylko litery i cyfry!!");
            }
            if ($this->walidujformularz($_POST['budynek'], 'cyfry')) {
                $tab[] = $_POST['budynek'];
            } else {
                $this->setBlad("Pole <b>Numer budynku</b> może zawierać tylko cyfry!!");
            }
            if ($this->walidujformularz($_POST['mieszkanie'], 'cyfry')) {
                $tab[] = $_POST['mieszkanie'];
            } else {
                $this->setBlad("Pole <b>Numer mieszkania</b> może zawierać tylko cyfry!!");
            }
            if ($this->walidujformularz($_POST['kod'], 'kodpoczta')) {
                $tab[] = $_POST['kod'];
            } else {
                $this->setBlad("Pole <b>Kod pocztowy</b> zawiera niewłaściwy format znaków !!");
            }
            if ($this->walidujformularz($_POST['miejscowosc'], 'tekst')) {
                $tab[] = $_POST['miejscowosc'];
            } else {
                $this->setBlad("Pole <b>Miejscowość</b> może zawierać tylko litery!!");
            }
            if ($this->walidujformularz($_POST['wojewodztwo'], 'tekst')) {
                $tab[] = $_POST['wojewodztwo'];
            } else {
                $this->setBlad("Pole <b>Województwo</b> może zawierać tylko litery!!");
            }
            if ($this->walidujformularz($_POST['pesel'], 'nip')) {
                $tab[] = $_POST['pesel'];
            } else {
                $this->setBlad("Pole <b>Numer pesel</b> jest nieprawidłowe!!");
            }
            if ($this->walidujformularz($_POST['email'], 'email')) {
                $tab[] = $_POST['pesel'];
            } else {
                $this->setBlad("Pole <b>Adres email</b> zawiera niewłaściwy format znaków!!");
            }

            if (sizeof($tab) == 10) {
                $pytanie2 = new ZapytaniaMysql();
                $pytanie2->select('rodzaje_kont');
                $pytanie2->where('Ranga_Nazwa', 'Uczen');
                $dane = $pytanie2->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                $pytanie = new ZapytaniaMysql();
                $pytanie->insert('konta_uczniowie', 'Imie, Nazwisko, Haslo,Ulica, Numer_Budynku, Numer_Mieszkania, Kod_Pocztowy, Miejscowosc, Wojewodztwo'
                        . ', Numer_Pesel, Id_Klasa, Id_Ranga, Data_Rejestracji, Email', "" . $_POST['imie'] . "," . $_POST['nazwisko'] . "," . uniqid('', true) . "," . $_POST['ulica'] . "," . $_POST['budynek'] . "," . $_POST['mieszkanie'] . "," . $_POST['kod'] . ","
                        . "" . $_POST['miejscowosc'] . "," . $_POST['wojewodztwo'] . "," . $_POST['pesel'] . ","
                        . "" . $_SESSION['danezalogowany']['Id_Klasa'] . "," . $dane['Id_Ranga'] . "," . date('Y-m-d') . "," . $_POST['email'] . "");
                if ($pytanie->wykonajpytanie()) {
                    $this->setBlad('Zapisano');
                    $this->nullpost($tablica);
                } else {
                    if ($pytanie->getMysqlerrorinfo() == 1062) {
                        $this->setBlad('Uczeń o takim numerze pesel już istnieje');
                    }
                    $this->setBlad($pytanie->getMysqlerrorinfo());
                }
            }
        } else {
            $this->nullpost($tablica);
        }
    }

    function setLinkformularz($dane = null) {
        if ($dane == null) {
            $link = 'dziennik.html/dodajucznia';
        } else {

            $link = 'listaszkol.html/uczenedytuj/' . $dane;
        }

        return $link;
    }

    function getLinkformularz() {
        if (!isset($this->url[2])) {
            $link = null;
        } else {
            $link = $this->url[2];
        }
        return $this->setLinkformularz($link);
    }

    function pobierzuczniow() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('uczen_dane');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
        $pytanie->andmysql('Klasa_Nazwa', $_SESSION['klasadane']['Klasa_Nazwa']);
        $pytanie->orderby('Nazwisko', 'ASC');

        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }

    function klasauczniowie() {

        if (isset($_POST['zapiszlista'])) {
            $pytanie3 = new ZapytaniaMysql();
            $pytanie3->select('listy_nieobecnosci');
            $pytanie3->where('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
            $pytanie3->andmysql('Data_Listy', date('Y-m-d'));
            $pytanie3->andmysql('Id_Nauczyciel', $_SESSION['UserId']);

            if ($pytanie3->wykonajpytanie()->rowCount() == 0) {
                $pytanie4 = new ZapytaniaMysql();
                $pytanie4->insert('listy_nieobecnosci', 'Id_Przedmiot, Data_Listy, Id_Nauczyciel, Id_Klasa', "" . $_SESSION['przedmiot']['Id_Przedmiot'] . "," . date('Y-m-d') . "," . $_SESSION['UserId'] . "," . $_SESSION['klasadane']['Id_Klasa'] . "");
                $pytanie4->wykonajpytanie();

                if (!empty($_POST['osoba'])) {
                    $pytanie5 = new ZapytaniaMysql();
                    foreach ($_POST['osoba'] as $uczen) {
                        $pytanie5->insert('nieobecnosci', 'Id_Uczen, Rodzaj_Nieobecnosci, Id_Lista_Nieobecnosc', "" . $uczen . ",0," . $pytanie3->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)['Id_Lista_Nieobecnosc'] . "");
                    }
                    $pytanie5->wykonajpytanie();
                }

                $this->setBlad('Zapisano');
            } else {
                $this->setBlad('Taka lista juz istnieje');
            }
        }
        return $this->pobierzuczniow();
    }

    function klasadzienobecnosci() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('listy_nieobecnosci');
        $pytanie->where('Id_Lista_Nieobecnosc', $this->url[2]);
        $pytanie->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
        $tablicadane = $pytanie->wykonajpytanie()->fetch();
        $this->setListanieobecnych($tablicadane);
        $this->setDnizajecia($tablicadane);
        if (isset($_POST['listausun'])) {
            $pytanie2 = new ZapytaniaMysql();
            $pytanie2->select('listy_nieobecnosci');
            $pytanie2->where('Data_Listy', $tablicadane['Data_Listy'], '>');
            $pytanie2->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
            
            if ($pytanie2->wykonajpytanie()->rowCount() == 0) {
                $pytanie3 = new ZapytaniaMysql();
                $pytanie3->delete('listy_nieobecnosci');
                $pytanie3->where('Id_Lista_Nieobecnosc', $tablicadane['Id_Lista_Nieobecnosc']);
                $pytanie3->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
                $pytanie3->andmysql('Id_Klasa', $tablicadane['Id_Klasa']);
                $pytanie3->wykonajpytanie();
                return "usunliste";
            } else {
                $this->setBlad('Nie można usunąć tej listy');
            }
        } else {
            return $tablicadane;
        }
    }

    function setListanieobecnych($tablica) {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('nieobecnosci');
        $pytanie->leftjoin('listy_nieobecnosci', 'Id_Lista_Nieobecnosc', 'nieobecnosci', 'Id_Lista_Nieobecnosc');
        $pytanie->where('listy_nieobecnosci.Data_Listy', $tablica['Data_Listy'], '<=');

        $this->dane = $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }

    function getListanieobecnych() {
        return $this->dane;
    }

    function setDnizajecia($tablica) {
        $pytanie2 = new ZapytaniaMysql();
        $pytanie2->select('listy_nieobecnosci');
        $pytanie2->where('Data_Listy', $tablica['Data_Listy'], '<=');
        $pytanie2->andmysql('Data_Listy', $_SESSION['przedzialsemestr'][0], ">=");
        $pytanie2->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
        $pytanie2->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie2->andmysql('Id_Klasa', $tablica['Id_Klasa']);
        $this->dzienzajecia = $pytanie2->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }

    function getDnizajecia() {
        return $this->dzienzajecia;
    }

    function usunliste() {
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('listy_nieobecnosci');
        $pytanie1->where('Data_Listy', $wartosc);
    }

    function edytujobecnosc() {
        if (!isset($this->url[3])) {
            $this->url[3] = null;
        }
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('listy_nieobecnosci', 'listy_nieobecnosci.Id_Lista_Nieobecnosc, nieobecnosci.Id_Nieobecnosc, Id_Przedmiot, '
                . 'Data_Listy, Id_Nauczyciel, listy_nieobecnosci.Id_Klasa, concat(Imie, " ", Nazwisko) As Kto, Rodzaj_Nieobecnosci, konta_uczniowie.Id_Uczen');
        $pytanie1->leftjoin('konta_uczniowie', 'Id_Klasa', 'listy_nieobecnosci', 'Id_Klasa');
        $pytanie1->leftjoin('nieobecnosci', 'Id_Lista_Nieobecnosc', 'listy_nieobecnosci', 'Id_Lista_Nieobecnosc');
        $pytanie1->porownajkolumny("And", 'konta_uczniowie.Id_Uczen', 'nieobecnosci.Id_Uczen');
        $pytanie1->where('listy_nieobecnosci.Id_Lista_Nieobecnosc', $this->url[2]);
        $pytanie1->andmysql('listy_nieobecnosci.Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
        $pytanie1->andmysql('listy_nieobecnosci.Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie1->andmysql('konta_uczniowie.Id_Uczen', $this->url[3]);
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

    function ocenyuczen() {
        if (isset($_SESSION['przedmiot'])) {
                if(!isset($_SESSION['przedzialoceny'])){
                    $_SESSION['przedzialoceny'] = null;
                }
                
            $pytanie = new ZapytaniaMysql();
            $pytanie->select('oceny_uczniow', 'Id_Ocena_Ucznia, Za_Co, lista_ocen.Ocena_Nazwa, Wartosc_Ocena, oceny_uczniow.Id_Przedmiot, konta_uczniowie.Id_Uczen, Data_Wystawienia, konta_uczniowie.Id_Klasa');
            $pytanie->leftjoin('konta_uczniowie', 'Id_Uczen', 'oceny_uczniow', 'Id_Uczen');
            $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
            $pytanie->where('konta_uczniowie.Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
            $pytanie->andmysql('oceny_uczniow.Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
            $kopiujpytanie = clone $pytanie;
            $this->setLiczsemestry($kopiujpytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC), 'Data_Wystawienia', 'przedzialoceny');
            $pytanie->andmysql('Data_Wystawienia', $_SESSION['przedzialoceny'][0], ">=");
            $pytanie->andmysql('Data_Wystawienia', $_SESSION['przedzialoceny'][1], "<=");
            
            
            return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    function pobierzucznia() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('konta_uczniowie');
        $pytanie->where('Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
        $pytanie->andmysql('Id_Uczen', $this->url[2]);

        return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }

    function pobierzoceny() {

        $pytanie = new ZapytaniaMysql();
        $pytanie->select('lista_ocen');
        $pytanie->where('szkoly_Id_Szkola', $_SESSION['przedmiot']['Id_Szkola']);

        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }

    function zapiszocena() {
        $dane = $this->pobierzucznia();
        if (isset($_POST['zapiszocena'])) {
            $pytanie = new ZapytaniaMysql();
            $pytanie->insert('oceny_uczniow', 'Id_Ocena, Id_Przedmiot, Id_Uczen, Za_Co, Ocena_Opis, Ocena_Waga, Data_Wystawienia', "" . $_POST['uczenocena'] . ", " . $_SESSION['przedmiot']['Id_Przedmiot'] . ","
                    . "" . $dane['Id_Uczen'] . "," . $_POST['ocena_za_co'] . "," . $_POST['wagaopis'] . "," . $_POST['ocenawaga'] . "," . date('Y-m-d') . "");
            $pytanie->wykonajpytanie();
            return true;
        }
        return false;
    }

    function uczenocenaedycja() {
        $uczendane = $this->pobierzucznia();
        $pytanie2 = new ZapytaniaMysql();
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('oceny_uczniow');
        $pytanie->where('Id_Ocena_Ucznia', $this->url[3]);
        $pytanie->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
        $pytanie->andmysql('Id_Uczen', $uczendane['Id_Uczen']);
        $dane = $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        if (isset($_POST['zapiszocena'])) {
            $pytanie2->update('oceny_uczniow');
            $pytanie2->setmysql('Id_Ocena', $_POST['uczenocena']);
            $pytanie2->setmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
            $pytanie2->setmysql('Id_Uczen', $dane['Id_Uczen']);
            $pytanie2->setmysql('Za_Co', $_POST['ocena_za_co']);
            $pytanie2->setmysql('Ocena_Opis', $_POST['ocenaopis']);
            $pytanie2->setmysql('Ocena_Waga', $_POST['ocenawaga']);
            $pytanie2->where('Id_Ocena_Ucznia', $dane['Id_Ocena_Ucznia']);
            $pytanie2->wykonajpytanie();
        }
        if (isset($_POST['usunocena'])) {
            $pytanie2->delete('oceny_uczniow');
            $pytanie2->where('Id_Ocena_Ucznia', $dane['Id_Ocena_Ucznia']);
            $pytanie2->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
            $pytanie2->andmysql('Id_Uczen', $dane['Id_Uczen']);
            $pytanie2->wykonajpytanie();

            return 'usunocene';
        }

        return $dane;
    }

    function rodzajsredniej() {
        if (isset($_SESSION['przedmiot'])) {
            $pytanie = new ZapytaniaMysql();
            $pytanie2 = new ZapytaniaMysql();
            $pytanie->select('przedmioty_rodzaje_srednich');
            $pytanie->where('Id_Nauczyciel', $_SESSION['UserId']);
            $pytanie->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
            $kopiujdane = clone $pytanie;
            if (isset($_POST['zapiszsrednia'])) {
                if ($kopiujdane->wykonajpytanie()->rowCount() == 1) {
                    $pytanie2->update('przedmioty_rodzaje_srednich');
                    $pytanie2->setmysql('Wartosc', $_POST['sredniarodzaj']);
                    $pytanie2->where('Id_Nauczyciel', $_SESSION['UserId']);
                    $pytanie2->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
                    $pytanie2->wykonajpytanie();
                }
                if ($kopiujdane->wykonajpytanie()->rowCount() == 0) {
                    $pytanie2->insert('przedmioty_rodzaje_srednich', 'Id_Nauczyciel, Id_Przedmiot, Wartosc', "" . $_SESSION['UserId'] . "," . $_SESSION['przedmiot']['Id_Przedmiot'] . "," . $_POST['sredniarodzaj'] . "");
                    $pytanie2->wykonajpytanie();
                }
            }

            return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        }
    }

    function liczsrednia($uczen) {
        $dane = $this->rodzajsredniej()['Wartosc'];
        if (sizeof($dane) == 0) {
            $dane = 1;
        }
        $pytanie = new ZapytaniaMysql();
        switch ($dane) {
            case 1:
                $pytanie->select('oceny_uczniow', '(sum(lista_ocen.Wartosc_Ocena)/count(Id_Ocena_Ucznia)) As Wynik');
                $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
                $pytanie->where('oceny_uczniow.Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
                $pytanie->andmysql('oceny_uczniow.Id_Uczen', $uczen);
                
                break;
            case 2:
                $pytanie->select('oceny_uczniow', '(sum(lista_ocen.Wartosc_Ocena*oceny_uczniow.Ocena_Waga)/sum(oceny_uczniow.Ocena_Waga)) As Wynik');
                $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
                $pytanie->where('oceny_uczniow.Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
                $pytanie->andmysql('oceny_uczniow.Id_Uczen', $uczen);
                
                break;
        }
        $pytanie->andmysql('Data_Wystawienia', $_SESSION['przedzialoceny'][0], ">=");
            $pytanie->andmysql('Data_Wystawienia', $_SESSION['przedzialoceny'][1], "<=");
            return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
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
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('oceny_semestralne');
        $pytanie1->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_semestralne', 'Id_Ocena');
        $pytanie1->where('Id_Uczen', $uczen);
        $pytanie1->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
        
        if ($pytanie1->wykonajpytanie()->rowCount() == 1 && isset($_SESSION['przedzialoceny'])) {
            return $pytanie1->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        } else {
            echo null;
        }
    }

    function dodajwage() {
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('nauczyciele_wagi');
        $pytanie1->where('Id_Nauczyciel', $_SESSION['UserId']);
        $kopiujklasa = clone $pytanie1;
        if (isset($_POST['zapiszwaga'])) {
            $kopiujklasa->andmysql('Waga_Opis', $_POST['wagarodzaj']);

            if (($kopiujklasa->wykonajpytanie()->rowCount() == 0) or ( isset($this->url[2]))) {
                $pytanie2 = new ZapytaniaMysql();
                if (!isset($this->url[2])) {
                    $pytanie2->insert('nauczyciele_wagi', 'Id_Nauczyciel, Waga, Waga_Opis', "" . $_SESSION['UserId'] . "," . $_POST['nauczycielwaga'] . "," . $_POST['wagarodzaj'] . "");
                } else {
                    $pytanie2->update('nauczyciele_wagi');
                    $pytanie2->setmysql('Waga', $_POST['nauczycielwaga']);
                    $pytanie2->setmysql('Waga_Opis', $_POST['wagarodzaj']);
                    $pytanie2->where('Id_Waga_Nauczyciel', $this->wagaedycja()['Id_Waga_Nauczyciel']);
                    $pytanie2->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
                }
                if (!$pytanie2->wykonajpytanie()) {
                    $this->setBlad("Waga posiada niepoprawną wartość");
                }
            } else {
                $this->setBlad("Ten rodzaj wagi już istnieje");
            }
        }

        return $pytanie1->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }

    function wagaedycja() {
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('nauczyciele_wagi');
        $pytanie1->where('Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie1->andmysql('Id_Waga_Nauczyciel', $this->url[2]);
        return $pytanie1->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }

    function usunwaga() {
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->delete('nauczyciele_wagi');
        $pytanie1->where('Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie1->andmysql('Id_Waga_Nauczyciel', $this->url[2]);
        return $pytanie1->wykonajpytanie();
    }

    function dodajocenakoncowa() {
        $dane = $this->pobierzucznia();
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('oceny_semestralne');
        $pytanie->where('Id_Uczen', $dane['Id_Uczen']);
        $pytanie->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
        $kopiujpytanie = clone $pytanie;
        if (isset($_POST['zapiszocena'])) {
            if ($pytanie->wykonajpytanie()->rowCount() == 0) {

                $pytanie2 = new ZapytaniaMysql();
                $pytanie2->insert('oceny_semestralne', 'Id_Ocena, Id_Uczen, Id_Przedmiot, Data_Oceny', "" . $_POST['uczenocena'] . "," . $dane['Id_Uczen'] . "," . $_SESSION['przedmiot']['Id_Przedmiot'] . "," . date('Y-m-d') . "");
                $pytanie2->wykonajpytanie();
            }
            if ($pytanie->wykonajpytanie()->rowCount() == 1) {
                $pytanie3 = new ZapytaniaMysql();
                if ($_POST['uczenocena'] != "null") {
                    $pytanie3->update('oceny_semestralne');
                    $pytanie3->setmysql('Id_Ocena', $_POST['uczenocena']);
                    $pytanie3->where('Id_Uczen', $dane['Id_Uczen']);
                    $pytanie3->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
                    $pytanie3->wykonajpytanie();
                } else {
                    $pytanie3->delete('oceny_semestralne');
                    $pytanie3->where('Id_Uczen', $dane['Id_Uczen']);
                    $pytanie3->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
                    $pytanie3->wykonajpytanie();
                }
            }
        }
        return $kopiujpytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }

    function nauczycielterminy() {
        if (isset($_SESSION['przedmiot'])) {
            $pytanie = new ZapytaniaMysql();
            $pytanie->select('kalendarz_wydarzenia');
            $pytanie->where('Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
            $pytanie->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
            $pytanie->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);

            return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    function dodajtermin() {
        if (isset($_SESSION['przedmiot'])) {
            $tablica = array('wydarzenie_tytul', 'wydarzenie_tresc', 'wydarzenie_sala');
            if (isset($_POST['zapisztermin'])) {
                $pytanie2 = new ZapytaniaMysql();
                $pytanie2->insert('kalendarz_wydarzenia', 'Id_Klasa, Id_Nauczyciel, Id_Przedmiot, Wydarzenie_Nazwa, Wydarzenie_Tresc, Sala, Data_Wydarzenia', "" . $_SESSION['klasadane']['Id_Klasa'] . "," . $_SESSION['UserId'] . "," . $_SESSION['przedmiot']['Id_Przedmiot'] . "," . $_POST['wydarzenie_tytul'] . "," . $_POST['wydarzenie_tresc'] . ","
                        . "" . $_POST['wydarzenie_sala'] . "," . $_POST['rok'] . '-' . $_POST['miesiac'] . '-' . $_POST['dzien'] . "");
                if ($pytanie2->wykonajpytanie()) {
                    $this->nullpost($tablica);
                } else {
                    $this->setBlad('Wprowadzono niepoprawne dane');
                }
            } else {
                $this->nullpost($tablica);
            }
        }
    }

    function terminedycja() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('kalendarz_wydarzenia');
        $pytanie->where('Id_Wydarzenie', $this->url[2]);
        $pytanie->andmysql('Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
        $pytanie->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);

        $dane = $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);

        if (!isset($_POST['zapisztermin'])) {
            $_POST['wydarzenie_tytul'] = $dane['Wydarzenie_Nazwa'];
            $_POST['wydarzenie_tresc'] = $dane['Wydarzenie_Tresc'];
            $_POST['wydarzenie_sala'] = $dane['Sala'];
            $dzieldata = explode('-', $dane['Data_Wydarzenia']);
            $_POST['dzien'] = $dzieldata[2];
            $_POST['miesiac'] = $dzieldata[1];
            $_POST['rok'] = $dzieldata[0];
        } else {
            $pytanie2 = new ZapytaniaMysql();
            $pytanie2->update('kalendarz_wydarzenia');
            $pytanie2->setmysql('Wydarzenie_Nazwa', $_POST['wydarzenie_tytul']);
            $pytanie2->setmysql('Wydarzenie_Tresc', $_POST['wydarzenie_tresc']);
            $pytanie2->setmysql('Sala', $_POST['wydarzenie_sala']);
            $pytanie2->setmysql('Data_Wydarzenia', $_POST['rok'] . '-' . $_POST['miesiac'] . '-' . $_POST['dzien']);
            $pytanie2->where('Id_Wydarzenie', $this->url[2]);
            $pytanie2->andmysql('Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
            $pytanie2->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
            $pytanie2->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
            $pytanie2->wykonajpytanie();
        }
    }

    function terminusun() {
        $pytanie = new ZapytaniaMysql();
        $pytanie->delete('kalendarz_wydarzenia');
        $pytanie->where('Id_Wydarzenie', $this->url[2]);
        $pytanie->andmysql('Id_Klasa', $_SESSION['klasadane']['Id_Klasa']);
        $pytanie->andmysql('Id_Nauczyciel', $_SESSION['UserId']);
        $pytanie->andmysql('Id_Przedmiot', $_SESSION['przedmiot']['Id_Przedmiot']);
        $pytanie->wykonajpytanie();
    }

    function linkformularz() {
        if (!isset($this->url[2])) {
            $link = 'dziennik.html/nowytermin';
        } else {
            $link = 'dziennik.html/edytujtermin/' . $this->url[2];
        }
        return $link;
    }

}

?>