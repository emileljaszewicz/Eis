<?php
class UwierzytelnianieModel extends Model{
	function __construct($url){
            $this->url = $url;
            parent::__construct($this->url);
           
	}
        function walidujdane(){
            if(isset($_POST['logowanie'])){
                
                $daneuzytkownik = array();
                $pytanie = new ZapytaniaMysql();
                $pytanie->select('uzytkownicy');
                $pytanie->where('Haslo', $_POST['login']);
                $pytanie->isnull('Login');
                $daneuzytkownik = $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                if(!empty($daneuzytkownik) && strlen($_POST['login']) > 10){
                    $pytanie2 = new ZapytaniaMysql();
                    $pytanie2->select('rodzaje_kont');
                    $pytanie2->where('Id_Ranga', $daneuzytkownik['Id_Ranga']);
                    $uzytkownikranga = $pytanie2->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                    
                    $_SESSION['nowyuzytkownik'] = $uzytkownikranga;
                    $_SESSION['tabuzytkownicy'] = $daneuzytkownik;
                    $_SESSION['Ranga'] = 'Nowy';
                    $_SESSION['Login'] = 'Nowy użytkownik';
                    return true;
                }
                else{
                    $this->setBlad('Wprowadzono niepoprawny identyfikator');
                }
            
            
            }
        }
}
?>