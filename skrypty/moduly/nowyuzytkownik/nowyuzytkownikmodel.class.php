<?php
class NowyUzytkownikModel extends Model{
	function __construct($url){
            $this->url = $url;
            parent::__construct($this->url);
           
	}
        function walidujdane(){
            if(isset($_POST['zapisz'])){
                $tab = array();
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
                
                if(sizeof($tab == 2)){
                    $pytanie = new ZapytaniaMysql();
                    $pytanie2 = new ZapytaniaMysql();
                    $pytanie3 = new ZapytaniaMysql();
                    $pytanie3->select('uzytkownicy');
                    $pytanie3->where('Login', $_POST['login']);
                    if($pytanie3->wykonajpytanie()->rowCount(PDO::FETCH_ASSOC) == 0){
                    switch($_SESSION['nowyuzytkownik']['Ranga_Nazwa']){
                        case 'Szkola':
                            $tabelauser = 'szkoly';
                            $iduzytkownik = 'Id_Szkola';
                            break;
                        case 'Nauczyciel':
                            $tabelauser = 'konta_nauczyciele';
                            $iduzytkownik = 'Id_Nauczyciel';
                            break;
                        case 'Uczen':
                            $tabelauser = 'konta_uczniowie';
                            $iduzytkownik = 'Id_Uczen';
                            break;
                    }
                    $pytanie->update($tabelauser);
                    $pytanie->setmysql('Login', $_POST['login']);
                    $pytanie->setmysql('Haslo', $_POST['haslo']);
                    $pytanie->where($iduzytkownik, $_SESSION['tabuzytkownicy']['Id_Uzytkownik']);
                    $pytanie->wykonajpytanie();
                    $tablica = array('login', 'haslo', 'haslopowtorz');
                $this->nullpost($tablica);
                    return true;
                }
                else{
                    return $this->setBlad('Taki login już istnieje');
                }
                }
                
            }
            else{
                $tablica = array('login', 'haslo', 'haslopowtorz');
                $this->nullpost($tablica);
            }
        }
}
?>