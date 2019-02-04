<?php

class SzkolalicencjaModel extends Model {

    

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }
    function sprawdzwaznosc(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('licencje');
        $pytanie->where('Id_Szkola', $_SESSION['UserId']);
        $dane = $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        if(isset($_POST['zapisz']) && !empty($_POST['licencja'])){
            if(($_POST['licencja'] == $dane['Licencja_Klucz']) && $_POST['licencja'] != $dane['Licencja_Stara']){
            $pytanie2 = new ZapytaniaMysql();
            $pytanie2->update('licencje');
            $pytanie2->setmysql('Licencja_Status', 1);
            $pytanie2->setmysql('Wazne_Do', date('Y-m-d', strtotime("+1 Year")));
            $pytanie2->setmysql('Licencja_Stara', $_POST['licencja']);
            $pytanie2->where('Id_Szkola', $_SESSION['UserId']);
            $pytanie2->wykonajpytanie();
            $this->setBlad('Aktywowano');
            $this->nullpost(array('licencja'));
            }
            else{
                $this->setBlad('Wprowadzono niepoprawny klucz licencyjny');
            }
        }
        else{
            $this->nullpost(array('licencja'));
        }
        return $dane;
    }
}

?>