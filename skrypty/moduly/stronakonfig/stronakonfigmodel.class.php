<?php

class StronaKonfigModel extends Model {

    private $blad;

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    function personalizacja(){
        $tab = null;
        $tablica = array('login', 'haslo', 'haslopowtorz','email', 'imie', 'nazwisko');
        if(!isset($_POST['zapisz'])){
        $this->nullpost($tablica);
        }
        else{
            
                if(!empty($_POST['login'])){
                if($this->walidujformularz($_POST['login'], 'tekst,cyfry')){
                   $tab[] = 1;
                }
                else{
                    return $this->setBlad('Pole <b>Podaj login</b> może zawierać tylko litery i cyfry');
                }
                }
                else{
                    return $this->setBlad('Pole <b>Podaj login</b> nie może być puste');
                }
                
                if($_POST['haslo'] == $_POST['haslopowtorz']){    
                if(!empty($_POST['haslo']) && !empty($_POST['haslopowtorz'])){
                if($this->walidujformularz($_POST['haslo'], 'tekst,cyfry') && $this->walidujformularz($_POST['haslopowtorz'], 'tekst,cyfry')){
                   $tab[] = 1;
                }
                else{
                    return $this->setBlad('Pola <b>Podaj hasło</b> i <b>Powtórz hasło</b> może zawierać tylko litery i cyfry');
                }
                }
                else{
                    return $this->setBlad('Pola <b>Podaj hasło</b> i <b>Powtórz hasło</b> nie mogą być puste');
                }
                }
                else{
                    return $this->setBlad('Pola <b>Podaj hasło</b> i <b>Powtórz hasło</b> nie są takie same');
                }
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $tab[] = 1;
                }
                else{
                    return $this->setBlad('Wpisano niepoprawny adres email');
                }
                
                if(sizeof($tab) == 3){
                    $pobierzrange = new ZapytaniaMysql();
                    $pobierzrange->select('rodzaje_kont');
                    $pobierzrange->where('Ranga_Nazwa', 'Administrator_serwis');
                    
                    $dodajuzytkownika = new ZapytaniaMysql();
                    $dodajuzytkownika->insert('konta_administratora', 'Login, Haslo, Email, Imie, Nazwisko, Id_Ranga', [$_POST['login'],$_POST['haslo'],$_POST['email'], $_POST['imie'], 
                        $_POST['nazwisko'], $pobierzrange->wykonajpytanie()->fetch(PDO::FETCH_ASSOC)['Id_Ranga']]);
                    
                    if($dodajuzytkownika->wykonajpytanie()){
                    $_SESSION['dostep'] = true;
                    
                    $this->nullpost($tablica);
                    }
                }
                
                
        }
        if(isset($_SESSION['dostep'])){
                    $this->setBlad('Dane zostały zapisane poprawnie. Aby móc się zalogować wciśnij
                    <form action="'.$this->dolacz.'logowanie_do_aplikacji.html" method="post">  
                    <input type="submit" name="zmiennazwa" value="zmień" />
                    </form>');
        }
        if(isset($_POST['zmiennazwa'])){
            rename('skrypty/moduly/stronakonfig', 'skrypty/moduly/old_stronakonfig');
            session_destroy();
            header('location:.');
        }
    }
    function wyswietlbledy() {
        return $this->getBlad();
    }

}

?>