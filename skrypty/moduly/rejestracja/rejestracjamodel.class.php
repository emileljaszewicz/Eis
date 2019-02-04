<?php

class RejestracjaModel extends Model {

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    function wyswietldane() {
        $klasa = new ZapytaniaMysql();
        $tab = null;
        $bladrodzaj = null;
        if (isset($_POST['wyslij'])) {
            if($_POST['typ_szkoly'] != null){
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
              if ($this->walidujformularz($_POST['nip'], 'cyfry')) {
              $tab[] = $_POST['nip'];
              } else {
              $this->setBlad("<b>Numer identyfikacji</b> podatkowej (NIP) jest nieprawidłowy!!");
              } 
            if (sizeof($tab) == 9) {
                $rangaszkola = new ZapytaniaMysql();
                $rangaszkola->select('rodzaje_kont', 'Id_Ranga');
                $rangaszkola->where('Ranga_Nazwa', 'Szkola');
                
                $dane = $_POST['nazwa_uczelni'];
                $dane2 = $_POST["adres_email"];
                $klasa->insert('szkoly', 'Nazwa_Szkoly, Email, Ulica, Budynek_Numer, Kod_Pocztowy, Miejscowosc,'
                . ' Wojewodztwo, Numer_Identyfikacji_podatkowej, Id_Kategoria_Szkoly, Id_Ranga, Data_Rejestracji, Status', "".$_POST['nazwa_uczelni'].",".$_POST['adres_email'].",".$_POST["uczelnia_ulica"].",".$_POST["budynek"].","
                        .$_POST["kod"].",".$_POST["miejscowosc"].",".$_POST["wojewodztwo"].",".$_POST["nip"].",".$_POST['typ_szkoly'].",".$rangaszkola->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)['Id_Ranga'].",".date('Y-m-d').",3");
                if ($klasa->wykonajpytanie()) {
                    $this->setBlad("zapisano");
                } else {
                    $this->setBlad($klasa->getMysqlblad());
                }
            }
            if ($this->getBlad()) {
                return $this->getBlad();
            }
        } else {
            
            $t = array('nazwa_uczelni', 'adres_email', 'uczelnia_ulica', 'budynek', 'kod', 'miejscowosc', 'wojewodztwo', 'nip');
            $this->nullpost($t);
        }
    }
    function wyswietlpola(){
        $klasa = new ZapytaniaMysql();
        $tablica = array();
        foreach(laczzbaza()->query($klasa->select('szkoly_kategorie')) as $d){
            $tablica[$d['Id_Kategoria_Szkoly']] = $d['Rodzaj_Szkoly'];
        }
        return $tablica;
    }
    /*function wyswietlbledy() {
        return $this->getBlad();
    }*/

}

?>