<?php

class SzkolyListaModel extends Model {

    private $blad;
    private $licz = null;
    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    function wyswietldane($ile, $status) {
        return $this->wyswietllisteszkol($ile, $status);
    }
    function wyswietlkategorie($ile) {
        return $this->wyswietllistekategorii($ile);
    }

    function wyswietlmenu() {
        return '<a href="' . $this->dolacz . 'listaszkol.html">Lista szkół</a>
        <a href="' . $this->dolacz . 'listaszkol.html/szkoladodaj">Dodaj szkołę</a>
        <a href="' . $this->dolacz . 'listaszkol.html/szkolykategorie">Kategorie szkół</a>
        <a href="' . $this->dolacz . 'listaszkol.html/szkolyakceptacje">Do akceptacji</a>';
    }

    function strona($ilenastrone) {
        if (!isset($this->url[2])) {
            $this->url[2] = 0;
        }
        return $this->wyswietllisteszkol($ilenastrone,1, $this->url[2]);
    }
    function katstrona($ilenastrone) {
        if (!isset($this->url[3])) {
            $this->url[3] = 0;
        }
        return $this->wyswietllistekategorii($ilenastrone, $this->url[3]);
    }

    function wyswietllisteszkol($rekordownastrone, $status, $url = null) {
        $klasa = new ZapytaniaMysql();
        $szkoly = array();
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $klasa->select('szkoly', 'Id_Szkola, Nazwa_Szkoly');
        $klasa->where('Status', $status);
        $klasa->limit($od, $do);
        foreach ($klasa->wykonajpytanie() as $szkola) {
            $szkoly[$szkola['Id_Szkola']] = $szkola['Nazwa_Szkoly'];
        }
        return $szkoly;
    }

    function wyswietllinkistron($rekordownastrone, $url = null) {

        $klasa = new ZapytaniaMysql();
        $tab = array();
        $klasa->select('szkoly', 'Id_Szkola');

        for ($i = $url * $rekordownastrone; $i < floor($klasa->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }
    function wyswietllistekategorii($rekordownastrone, $url = null) {
        $klasa = new ZapytaniaMysql();
        $szkoly = array();
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $klasa->select('szkoly_kategorie');
        $klasa->limit($od, $do);
        foreach ($klasa->wykonajpytanie() as $szkola) {
            $szkoly[$szkola['Id_Kategoria_Szkoly']] = $szkola['Rodzaj_Szkoly'];
        }
        return $szkoly;
    }

    function wyswietlstronykategorii($rekordownastrone, $url = null) {

        $klasa = new ZapytaniaMysql();
        $tab = array();
        $klasa->select('szkoly_kategorie', 'Id_Kategoria_Szkoly');
        
        for ($i = $url * $rekordownastrone; $i < ceil($klasa->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }
    function kategoriadodaj(){
        $klasa = new ZapytaniaMysql();
        $klasa->insert('szkoly_kategorie', 'Rodzaj_Szkoly', $_POST['nazwa_kategorii']);
        if(!$klasa->wykonajpytanie()){
            return $this->setBlad(kodybledow($klasa->getMysqlerrorinfo()));
        }
        return true;
    }
    function kategoriausun(){
        $klasa = new ZapytaniaMysql();
        $klasa->delete('szkoly_kategorie');
        $klasa->where('Id_Kategoria_Szkoly', $this->url[2]);
        if(!$klasa->wykonajpytanie()){
            return $this->setBlad(kodybledow($klasa->getMysqlerrorinfo()));
        }
        return true;
    }
    function kategoriaedytuj(){
        $klasa = new ZapytaniaMysql();
        $klasa->select('szkoly_kategorie');
        $klasa->where('Id_Kategoria_Szkoly', $this->url[2]);
        if(!$klasa->wykonajpytanie()){
            return $this->setBlad(kodybledow($klasa->getMysqlerrorinfo()));
        }
        else{
            return $klasa->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        }
        
    }
function kategoriaaktualizuj(){
    $klasa = new ZapytaniaMysql();
    $klasa->update('szkoly_kategorie');
    $klasa->setmysql('Rodzaj_Szkoly', $_POST['nazwa_kategorii']);
    $klasa->where('Id_Kategoria_Szkoly', $this->url[2]);
    if(!$klasa->wykonajpytanie()){
        return $this->setBlad(kodybledow($klasa->getMysqlerrorinfo()));
    }
    return true;
}
    function Szkolawyswietl() {
        $klasa = new ZapytaniaMysql();
        $klasa2 = new ZapytaniaMysql();
        
        $klasa->select('szkoly');
        $klasa->leftjoin('szkoly_kategorie', 'Id_Kategoria_Szkoly', 'szkoly', 'Id_Kategoria_Szkoly');
        $klasa->where('szkoly.Id_Szkola', $this->url[2]);
        $rekord = $klasa->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        $klasa2->select('licencje');
        $klasa2->where('licencje.Id_Szkola', $this->url[2]);
        $rekord2 = $klasa2->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        
        if($klasa2->wykonajpytanie()->rowCount() > 0){
            $this->liczlicencja(date('Y-m-d'), $rekord2['Wazne_Do']);
            return array_merge($rekord, $rekord2);
        }
        else{
            $rekord2['Wazne_Od'] = null;
            $rekord2['Wazne_Do'] = null;
            $rekord2['Licencja_Klucz'] = null;
            $rekord2['Licencja_Status'] = null;
       return array_merge($rekord, $rekord2);
        }
    }

    function liczlicencja($od, $do){
        return $this->licz = ((strtotime($do) - strtotime($od)) / (60*60*24));
    }
 function wyswietllicencja(){
     return $this->licz;
 }
    function getWyswietlopcje() {
        $klasa = new ZapytaniaMysql();
        $tablica = array();
        foreach(laczzbaza()->query($klasa->select('szkoly_kategorie')) as $d){
            $tablica[$d['Id_Kategoria_Szkoly']] = $d['Rodzaj_Szkoly'];
        }
        return $tablica;
    }
    function walidujdane($url = null){
        $klasa = new ZapytaniaMysql();
        $klasa2 = new ZapytaniaMysql();
        $tab = null;
        $bladrodzaj = null;
        if($url != null && !isset($_POST['zapisz'])){
            $_POST['typ_szkoly'] = $this->Szkolawyswietl()['Id_Kategoria_Szkoly'];
         $_POST['nazwa_uczelni'] = $this->Szkolawyswietl()['Nazwa_Szkoly'];
         $_POST['adres_email'] = $this->Szkolawyswietl()['Email'];
         $_POST['uczelnia_ulica'] = $this->Szkolawyswietl()['Ulica'];
         $_POST['budynek'] = $this->Szkolawyswietl()['Budynek_Numer'];
         $_POST['kod'] = $this->Szkolawyswietl()['Kod_Pocztowy'];
         $_POST['miejscowosc'] = $this->Szkolawyswietl()['Miejscowosc'];
         $_POST['wojewodztwo'] = $this->Szkolawyswietl()['Wojewodztwo'];
         $_POST['nip'] = $this->Szkolawyswietl()['Numer_Identyfikacji_podatkowej'];
        }
        if (isset($_POST['zapisz'])) {
            if($_POST['typ_szkoly'] != 'null'){
                $tab[] = $_POST['typ_szkoly'];
            }
            else{
                $this->setBlad("wypelnij szkole!!");
            }
            if ($this->walidujformularz($_POST['nazwa_uczelni'], 'tekst')) {
                $tab[] = $_POST['nazwa_uczelni'];
            } else {
                $this->setBlad("Pole <b>Nazwa uczelni</b> może zawierać tylko litery!!");
            }
             if ($this->walidujformularz($_POST['adres_email'], 'email')) {
              $tab[] = $_POST['adres_email'];
              } else {
              $this->setBlad("Pole <b>Email</b> jest niepoprawne!!");
              }
              if ($this->walidujformularz($_POST['uczelnia_ulica'], 'tekst')) {
              $tab[] = $_POST['uczelnia_ulica'];
              } else {
              $this->setBlad("Pole <b>Ulica</b> może zawierać tylko litery i cyfry!!");
              }
              if ($this->walidujformularz($_POST['budynek'], 'cyfry')) {
              $tab[] = $_POST['budynek'];
              } else {
              $this->setBlad("Pole <b>Budynek</b> może zawierać tylko cyfry!!");
              }
              if($this->walidujformularz($_POST['kod'], 'kodpoczta')) {
              $tab[] = $_POST['kod'];
              } else {
              $this->setBlad("Pole ' Kod pocztowy ' zawiera zły format znaków!!");
              }
              if ($this->walidujformularz($_POST['miejscowosc'], 'tekst')) {
              $tab[] = $_POST['miejscowosc'];
              } else {
              $this->setBlad("Pole <b>Miejscowość</b> może zawierać tylko litery !!");
              }
              if ($this->walidujformularz($_POST['wojewodztwo'], 'tekst')) {
              $tab[] = $_POST['wojewodztwo'];
              } else {
              $this->setBlad("Pole <b>Województwo</b> może zawierać tylko litery!!");
              }
              if ($this->walidujformularz($_POST['nip'], 'nip')) {
              $tab[] = $_POST['nip'];
              } else {
              $this->setBlad("<b>Numer identyfikacji</b> podatkowej (NIP) jest nieprawidłowy!!");
              } 
            if (sizeof($tab) == 9) {
                $pytanie = new ZapytaniaMysql();
                $pytanie->select('rodzaje_kont');
                $pytanie->where('Ranga_Nazwa', 'Szkola');
                
               if($url == null){
                $klasa->insert('szkoly', 'Nazwa_Szkoly, Email, Ulica, Budynek_Numer, Kod_Pocztowy, Miejscowosc,'
                . ' Wojewodztwo, Numer_Identyfikacji_podatkowej, Id_Kategoria_Szkoly, Id_Ranga, Data_Rejestracji, Status', "".$_POST['nazwa_uczelni'].",".$_POST['adres_email'].",".$_POST["uczelnia_ulica"].",".$_POST["budynek"].","
                        .$_POST["kod"].",".$_POST["miejscowosc"].",".$_POST["wojewodztwo"].",".$_POST["nip"].",".$_POST['typ_szkoly'].",".$pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)['Id_Ranga'].",".date('Y-m-d').",0");
               }
               else{
                   $klasa2->update('szkoly');
                   $klasa2->setmysql('Id_Kategoria_Szkoly', $_POST['typ_szkoly']);
                   $klasa2->setmysql('Nazwa_Szkoly', $_POST['nazwa_uczelni']);
                   $klasa2->setmysql('Email', $_POST['adres_email']);
                   $klasa2->setmysql('Ulica', $_POST['uczelnia_ulica']);
                   $klasa2->setmysql('Budynek_Numer', $_POST['budynek']);
                   $klasa2->setmysql('Kod_Pocztowy', $_POST['kod']);
                   $klasa2->setmysql('Miejscowosc', $_POST['miejscowosc']);
                   $klasa2->setmysql('Wojewodztwo', $_POST['wojewodztwo']);
                   $klasa2->setmysql('Numer_Identyfikacji_podatkowej', $_POST['nip']);
                   $klasa2->where('Id_Szkola', $this->Szkolawyswietl()['Id_Szkola']);
                 
               }
                if ($klasa->wykonajpytanie() or $klasa2->wykonajpytanie()) {
                    $this->setBlad("zapisano");
                } else {
                    if($klasa->getMysqlblad() == '1062'){
                    $this->setBlad('Taka szkoła już istnieje');
                    }
                }
            }
            if ($this->getBlad()) {
                return $this->getBlad();
            }
        } else {
            if($url == null){
            $t = array('typ_szkoly', 'nazwa_uczelni', 'adres_email', 'uczelnia_ulica', 'budynek', 'kod', 'miejscowosc', 'wojewodztwo', 'nip');
            $this->nullpost($t);
            }
        }
    }
    function setLinkformularz($dane = null){
        if($dane == null){
            $link  = 'listaszkol.html/szkoladodaj';
        }
        else{
            
            $link = 'listaszkol.html/szkolaedytuj/'.$dane;
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
    function usunszkole(){
        $klasa = new ZapytaniaMysql();
        $klasa->delete('szkoly');
        $klasa->where('Id_Szkola', $this->url[2]);
        $klasa->wykonajpytanie();
    }
    function rejestracjaakcept($statusrodzaj){
        $klasa = new ZapytaniaMysql();
        $klasa2 = new ZapytaniaMysql();
        $klasa3 = new ZapytaniaMysql();
        $klasa4 = new ZapytaniaMysql();
        $klasa3->select('licencje');
        $klasa3->where('Id_Szkola', $this->url[2]);
        $szkolaid = $klasa3->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        $klasa->update('szkoly');
        $klasa->setmysql('Status', $statusrodzaj);
        $klasa->where('Id_Szkola', $this->url[2]);
        $klasa->wykonajpytanie();
        if(!is_array($szkolaid)){
        $klasa2->insert('licencje', 'Wazne_Od, Wazne_Do, Id_Szkola, Licencja_Klucz, Licencja_Status', "".date('Y-m-d').", ".date('Y-m-d', strtotime("+1 Year")).", ".$this->url[2].",".sha1(time().$this->url[2]).", 0");
        $klasa2->wykonajpytanie();
        $klasa4->update('szkoly');
        $klasa4->setmysql('Haslo', uniqid('', true));
        $klasa4->where('Id_Szkola', $this->url[2]);
        $klasa4->wykonajpytanie();
        }
    }
    function resetujlicencja($dnidokonca){
        $klasa = new ZapytaniaMysql();
        $klasa2 = new ZapytaniaMysql();
        $klasa2->select('licencje');
        $klasa2->where('Id_Szkola', $this->url[2]);
        $licencja = $klasa2->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        if($this->liczlicencja(date('Y-m-d'), $licencja['Wazne_Do']) <= $dnidokonca){
        $klasa->update('licencje');
        $klasa->setmysql('Licencja_Klucz', sha1(time().$this->url[2]));
        $klasa->where('Id_Szkola', $this->url[2]);
        $klasa->wykonajpytanie();
        }
    }
    function resetujhaslo(){
        $klasa = new ZapytaniaMysql();
        $klasa->update('szkoly');
        $klasa->setnull('Login');
        $klasa->setmysql('Haslo', uniqid('', true));
        $klasa->where('Id_Szkola', $this->url[2]);
        $klasa->wykonajpytanie();
    }
    function wyswietlbledy() {
        return $this->getBlad();
    }

}

?>