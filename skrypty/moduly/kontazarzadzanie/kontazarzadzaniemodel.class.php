<?php

class KontaZarzadzanieModel extends Model {

    private $blad;
    private $licz = null;
    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    

    function wyswietlmenu() {
        return '<a href="' . $this->dolacz . 'konta_nauczyciele.html">Lista nauczycieli</a>
        <a href="' . $this->dolacz . 'konta_nauczyciele.html/nowynauczyciel">Dodaj nauczyciela</a>';
    }
function wyswietllistenauczycieli($rekordownastrone, $url = null) {
        $klasa = new ZapytaniaMysql();
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $klasa->select('konta_nauczyciele', 'Id_Nauczyciel, CONCAT(Imie," ", Nazwisko) as Nazwa');
        $klasa->where('Id_Szkola', $_SESSION['UserId']);
        $klasa->limit($od, $do);
        
        return $klasa->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function wyswietldane($ile) {
        return $this->wyswietllistenauczycieli($ile);
    }
    function wyswietllinkistron($rekordownastrone, $url = null) {

        $klasa = new ZapytaniaMysql();
        $tab = array();
        $klasa->select('konta_nauczyciele', 'Id_Nauczyciel');
        $klasa->where('Id_Szkola', $_SESSION['UserId']);
        for ($i = $url * $rekordownastrone; $i < floor($klasa->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }
    function strona($ilenastrone) {
        if (!isset($this->url[2])) {
            $this->url[2] = 0;
        }
        return $this->wyswietllistenauczycieli($ilenastrone, $this->url[2]);
    }
    function nauczycielwyswietl() {
        $klasa = new ZapytaniaMysql();
        $klasa->select('konta_nauczyciele');
        $klasa->where('Id_Nauczyciel', $this->url[2]);
        $klasa->andmysql('Id_Szkola', $_SESSION['UserId']);
        $this->nauczycielprzedmioty();
        return $klasa->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    function nauczycieledycja(){
        $danenauczyciel = $this->nauczycielwyswietl();
        $this->listaprzedmiotow();
        if(!isset($_POST['zapisz'])){
        $_POST['imie'] = $danenauczyciel['Imie'];
        $_POST['nazwisko'] = $danenauczyciel['Nazwisko'];
        $_POST['ulica'] = $danenauczyciel['Ulica'];
        $_POST['budynek'] = $danenauczyciel['Numer_budynku'];
        $_POST['mieszkanie'] = $danenauczyciel['Numer_Mieszkania'];
        $_POST['kod'] = $danenauczyciel['Kod_Pocztowy'];
        $_POST['miejscowosc'] = $danenauczyciel['Miejscowosc'];
        $_POST['wojewodztwo'] = $danenauczyciel['Wojewodztwo'];
        $_POST['pesel'] = $danenauczyciel['Numer_Pesel'];
        $_POST['salanr'] = $danenauczyciel['Sala_Uczy'];
        }
        return $this->dodajnauczyciela($danenauczyciel['Id_Nauczyciel']);
    }
    function listaprzedmiotow(){
        $klasa = new ZapytaniaMysql();
        $klasa->select('przedmioty');
      $klasa->where('Id_Szkola', $_SESSION['UserId']);
      return $klasa->wykonajpytanie()->fetchall(PDO::FETCH_ASSOC);
    }
    function nauczycielprzedmioty(){
        $danenauczyciel = new ZapytaniaMysql();
        $danenauczyciel->select('przedmioty_i_nauczyciele');
        $danenauczyciel->where('konta_nauczyciele_Id_Nauczyciel', $this->url[2]);
        return $danenauczyciel->wykonajpytanie()->fetchall(PDO::FETCH_ASSOC);
    }
    function dodajnauczyciela($url = null){
        $this->listaprzedmiotow();
        if (isset($_POST['zapisz'])) {
            $klasa = new ZapytaniaMysql();
            $klasa2 = new ZapytaniaMysql();
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
              if($this->walidujformularz($_POST['mieszkanie'], 'cyfry')) {
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
              if ($this->walidujformularz($_POST['salanr'], 'cyfry')) {
              $tab[] = $_POST['salanr'];
              } else {
              $this->setBlad("Pole <b>Uczy w sali</b> może zawierać tylko cyfry!!");
              } 
            if (sizeof($tab) == 10) {
                
               if($url == null){
                   $zapytanie = new ZapytaniaMysql();
                   $zapytanie->select('rodzaje_kont');
                   $zapytanie->where('Ranga_Nazwa', 'Nauczyciel');
                   $idrangi = $zapytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                $klasa->insert('konta_nauczyciele', 'Imie, Nazwisko, Haslo, Ulica, Numer_budynku, Numer_Mieszkania, Kod_Pocztowy,'
                . ' Miejscowosc, Wojewodztwo, Numer_Pesel, Id_Szkola, Id_Ranga, Sala_Uczy, Data_Rejestracji', "".$_POST['imie'].",".$_POST['nazwisko'].",".uniqid('', true).", ".$_POST["ulica"].",".$_POST["budynek"].","
                        . "".$_POST["mieszkanie"].",".$_POST["kod"].",".$_POST["miejscowosc"].",".$_POST["wojewodztwo"].",".$_POST["pesel"].",".$_SESSION['UserId'].",".$idrangi['Id_Ranga'].",".$_POST['salanr'].",".date('Y-m-d')."");
               
               }
               else{
                   if(!empty($_POST['przedmiotnr'])){
                       
                    $dodajdane = new ZapytaniaMysql();
                    $usundane = new ZapytaniaMysql();
                       $usundane->deletenotin('przedmioty_i_nauczyciele', 'przedmioty_Id_Przedmiot', $_POST['przedmiotnr']);
                       $usundane->andmysql('konta_nauczyciele_Id_Nauczyciel', $url);
                      $usundane->wykonajpytanie();
                       foreach($_POST['przedmiotnr'] as $d){
                           $pobierzdane = new ZapytaniaMysql();
                           $pobierzdane->select('przedmioty_i_nauczyciele');
                       $pobierzdane->where('konta_nauczyciele_Id_Nauczyciel', $url);
                       $pobierzdane->andmysql('przedmioty_Id_Przedmiot', $d);
                           if($pobierzdane->wykonajpytanie()->rowCount() == 0){
                             
                       $dodajdane->insert('przedmioty_i_nauczyciele', 'przedmioty_Id_Przedmiot, konta_nauczyciele_Id_Nauczyciel', "".$d.",".$url."");
                           }
                       }
                    
               $dodajdane->wykonajpytanie();
         
                   }
                   $klasa2->update('konta_nauczyciele');
                   $klasa2->setmysql('Imie', $_POST['imie']);
                   $klasa2->setmysql('Nazwisko', $_POST['nazwisko']);
                   $klasa2->setmysql('Ulica', $_POST['ulica']);
                   $klasa2->setmysql('Numer_budynku', $_POST['budynek']);
                   $klasa2->setmysql('Numer_Mieszkania', $_POST['mieszkanie']);
                   $klasa2->setmysql('Kod_Pocztowy', $_POST['kod']);
                   $klasa2->setmysql('Miejscowosc', $_POST['miejscowosc']);
                   $klasa2->setmysql('Wojewodztwo', $_POST['wojewodztwo']);
                   $klasa2->setmysql('Numer_Pesel', $_POST['pesel']);
                   $klasa2->setmysql('Sala_Uczy', $_POST['salanr']);
                   $klasa2->where('Id_Nauczyciel', $url);
                 $klasa2->andmysql('Id_Szkola', $_SESSION['UserId']);
               }
                if ($klasa->wykonajpytanie() or $klasa2->wykonajpytanie()) {
                    $this->setBlad("zapisano");
                } else {
                    if($klasa->getMysqlblad() == '1062'){
                    $this->setBlad('taki nauczyciel już istnieje');
                    }
                }
            }
            if ($this->getBlad()) {
                return $this->getBlad();
            }
        }
        else{
            if($url == null){
        $tablica = array('imie', 'nazwisko', 'ulica', 'budynek', 'mieszkanie', 'kod', 'miejscowosc', 'wojewodztwo', 'pesel', 'salanr');
        $this->nullpost($tablica);
            }
        }
    }
    function setLinkformularz($dane = null){
        if($dane == null){
            $link  = 'konta_nauczyciele.html/nowynauczyciel';
        }
        else{
            
            $link = 'konta_nauczyciele.html/nauczycieledycja/'.$dane;
        }
        
        return $link;
    }
    function getLinkformularz(){
        if(!isset($this->url[2])){
        $link = null;
        }
        else{
            $link = $this->url[2];
        }
        return $this->setLinkformularz($link);
    }
function usunnauczyciela(){
        $klasa = new ZapytaniaMysql();
        $klasa->delete('konta_nauczyciele');
        $klasa->where('Id_Nauczyciel', $this->url[2]);
        $klasa->wykonajpytanie();
    }
    function resetujhaslo(){
        $klasa = new ZapytaniaMysql();
        $klasa->update('konta_nauczyciele');
        $klasa->setnull('Login');
        $klasa->setmysql('Haslo', uniqid('', true));
        $klasa->where('Id_Nauczyciel', $this->url[2]);
        $klasa->wykonajpytanie();
    }
}

?>