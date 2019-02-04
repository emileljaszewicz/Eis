<?php

class LogowanieModel extends Model {

    private $blad;

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    function wyswietldane() {
        $tab = array();
        if (isset($_POST['wyslij'])) {
            
            if ($this->walidujformularz($_POST['login'], 'tekst')) {
                $tab[] = $_POST['login'];
            } else {
                $this->setBlad("Login może zawierać tylko litery i nie może być pusty!!");
            }
            if ($this->walidujformularz($_POST['haslo'], 'tekst,cyfry')) {
                $tab[] = $_POST['haslo'];
            } else {
                $this->setBlad("Hasło może zawierać tylko litery i cyfry i nie może być puste!!");
            }
            if (sizeof($tab) == 2) {
                $klasa = new ZapytaniaMysql();
                $klasa->select('uzytkownicy');
                $klasa->where('Login', $_POST['login']);
                $klasa->andmysql('Haslo', $_POST['haslo']);

                if ($klasa->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)) {
                    $klasa2 = new ZapytaniaMysql();
                    $klasa2->select('uzytkownicy');
                    
                    $klasa2->leftjoin('rodzaje_kont', 'Id_Ranga', 'uzytkownicy', 'Id_Ranga');
                    $klasa2->where('Login', $_POST['login']);
                    $id =$klasa2->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                    
                    if(!isset($_SESSION['Ranga'])){
                        $klasa3 = new ZapytaniaMysql();
                    $_SESSION['Ranga']  = $id['Ranga_Nazwa']; 
                    $_SESSION['Login'] = $_POST['login'];
                    switch($_SESSION['Ranga']){
                        case 'Administrator_serwis':
                            $klasa3->select('konta_administratora');
                            $idnazwa = 'Id_Administrator';
                            break;
                        case 'Szkola':
                            $klasa3->select('szkoly');
                            $idnazwa = 'Id_Szkola';
                            break;
                        case 'Nauczyciel':
                            
                            $klasa3->select('konta_nauczyciele', 'konta_nauczyciele.Id_Nauczyciel, konta_nauczyciele.Id_Szkola, Id_Klasa, Klasa_Nazwa, Id_Ranga');
                            $klasa3->leftjoin('wychowawcy_klas', 'Id_Nauczyciel', 'konta_nauczyciele', 'Id_Nauczyciel');
                            $idnazwa = 'Id_Nauczyciel';
                            break;
                        case 'Uczen':
                            $klasa3->select('konta_uczniowie');
                            $klasa3->leftjoin('uczen_dane', 'Id_Uczen', 'konta_uczniowie', 'Id_Uczen');
                            $idnazwa = 'Id_Uczen';
                            break;
                        
                    }
                    $klasa3->where('Id_Ranga', $id['Id_Ranga']);
                    $klasa3->andmysql('Login', $_SESSION['Login']);
                    $iduzytkownik = $klasa3->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                    
                    $_SESSION['danezalogowany'] = $iduzytkownik;
                    if(!empty($_SESSION['danezalogowany']['Id_Klasa']) && $id['Ranga_Nazwa'] == "Nauczyciel"){
                        $_SESSION['wychowawca'] = 'Wychowawca';
                    }
                    $_SESSION['UserId']  = $iduzytkownik[$idnazwa];   
                    $_SESSION['RangaId']  = $iduzytkownik['Id_Ranga'];   
                    }
                    if(sizeof($_SESSION['danezalogowany']) > 0){
                        if(isset($_SESSION['danezalogowany']['Id_Szkola'])){
                        $sprawdzlicencje = new ZapytaniaMysql();
                        $sprawdzlicencje->select('licencje');
                        $sprawdzlicencje->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);
                        
                        $statuslicencja  = $sprawdzlicencje->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                        
                        if(($statuslicencja['Licencja_Status'] == 0 && $_SESSION['Ranga'] != "Szkola") or ($statuslicencja['Wazne_Do'] < date('Y-m-d') && $_SESSION['Ranga'] != "Szkola")){
                            $this->setBlad('Brak uprawnień do zalogowania!!');
                            unset($_SESSION['Ranga']);
                        }
                        
                        }
                        
                    }
                    
                } else {
                    $this->setBlad('Błędne dane logowania!!');
                }
            }
            if ($this->getBlad()) {
                return $this->getBlad();
            }
            if(!isset($_SESSION['Ranga'])){
                session_destroy();
            }
            if(isset($_SESSION['Ranga'])){
                return 'ok';
            }
        
    }
    }

    function wyswietlbledy() {
        return $this->getBlad();
    }

}

?>