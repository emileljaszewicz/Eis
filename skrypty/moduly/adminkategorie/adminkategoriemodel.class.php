<?php

class AdminKategorieModel extends Model {

    private $blad;
    private $licz = null;
    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }

    

    function wyswietlmenu() {
        return '<a href="' . $this->dolacz . 'kategorie.html">Klasy</a>
        <a href="' . $this->dolacz . 'kategorie.html/szkolaprzedmioty">Przedmioty</a>
                <a href="' . $this->dolacz . 'kategorie.html/zajeciagodziny">Godziny zajęć</a>
                <a href="' . $this->dolacz . 'kategorie.html/listaocen">Oceny</a>
                <a href="' . $this->dolacz . 'kategorie.html/semestry">Semestry</a>
                    <a href="' . $this->dolacz . 'kategorie.html/promocje">Okres promocyjny</a>';
    }
function wyswietllisteklas($rekordownastrone, $url = null) {
        $klasa = new ZapytaniaMysql();
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $klasa->select('klasy');
        
        $klasa->where('klasy.Id_Szkola', $_SESSION['UserId']);
        $klasa->limit($od, $do);
        return $klasa->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    
function klasadodaj(){
    if(isset($_POST['zapisz'])){
        $pytanie = new ZapytaniaMysql();
            
        if($_POST['nauczycielid'] != "Null"){
            $pytanie->insert('klasy', 'Klasa_Nazwa, Id_Nauczyciel, Data_Zalozenia, Id_Szkola, Koniec_Promocji', "".$_POST['nazwa_klasy'].", ".$_POST['nauczycielid'].",".date('Y-m-d').",".$_SESSION['UserId'].", 1");
        }
            else{
                $pytanie->insert('klasy', 'Klasa_Nazwa, Data_Zalozenia, Id_Szkola, Koniec_Promocji', "".$_POST['nazwa_klasy'].",".date('Y-m-d').",".$_SESSION['UserId'].", 1");
            }
            
            if(!$pytanie->wykonajpytanie()){
                if($pytanie->getMysqlerrorinfo() == 1062){
                return $this->setBlad('Ten nauczyciel jest juz wychowawcą');
                }
                else{
                    return $this->setBlad('Wypełnij wszystkie pola');
                }
            }    
        
            return true;      
        
    }
    else{
        $tablica = array('nazwa_klasy');
        $this->nullpost($tablica);
    }
        
}
function klasaedycja(){
    if(!isset($_POST['zapisz'])){
    $wyswietlklasa = new ZapytaniaMysql();
    $wyswietlklasa->select('klasy');
    $wyswietlklasa->leftjoin('konta_nauczyciele', 'Id_Nauczyciel', 'klasy', 'Id_Nauczyciel');
    $wyswietlklasa->where('Id_Klasa', $this->url[2]);
    $wyswietlklasa->andmysql('klasy.Id_Szkola', $_SESSION['UserId']);
    
    return $wyswietlklasa->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    
        $pytanie = new ZapytaniaMysql();
    $pytanie->update('klasy');
              $pytanie->setmysql('Klasa_Nazwa', $_POST['nazwa_klasy']);
              $pytanie->setmysql('Id_Nauczyciel', $_POST['nauczycielid']);
              $pytanie->where('Id_Klasa', $this->url[2]);
              if(!$pytanie->wykonajpytanie()){
                  $this->setBlad('Ten nauczyciel ma już przypisaną klasę');
              }
              else{
                  $this->setBlad('Zapisano');
                  return true;
              }
    
}
function listanauczycieli(){
    $zapytanie = new ZapytaniaMysql();
    $zapytanie->select('konta_nauczyciele');
    $zapytanie->where('Id_Szkola', $_SESSION['UserId']);
    return $zapytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
}
function strona($ilenastrone) {
        if (!isset($this->url[2])) {
            $this->url[2] = 0;
        }
        return $this->wyswietllisteklas($ilenastrone, $this->url[2]);
    }
    function wyswietllinkistron($rekordownastrone, $url = null) {

        $klasa = new ZapytaniaMysql();
        $tab = array();
        $klasa->select('klasy', 'klasy.Id_Szkola');
        $klasa->leftjoin('konta_nauczyciele', 'Id_Nauczyciel', 'klasy', 'Id_Nauczyciel');
        $klasa->where('klasy.Id_Szkola', $_SESSION['UserId']);
        for ($i = $url * $rekordownastrone; $i < floor($klasa->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }
    function usunklasa(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('konta_uczniowie');
        $pytanie->leftjoin('klasy', 'Id_Klasa', 'konta_uczniowie', 'Id_Klasa');
        $pytanie->where('konta_uczniowie.Id_Klasa', $this->url[2]);
        $pytanie->andmysql('klasy.Id_Szkola', $_SESSION['UserId']);
        
        if($pytanie->wykonajpytanie()->rowCount() == 0){
        $klasa = new ZapytaniaMysql();
        $klasa->delete('klasy', 'klasy');
        $klasa->leftjoin('konta_nauczyciele', 'Id_Nauczyciel', 'klasy', 'Id_Nauczyciel');
        $klasa->where('Id_Klasa', $this->url[2]);
        $klasa->andmysql('klasy.Id_Szkola', $_SESSION['UserId']);
        if(!$klasa->wykonajpytanie()){
            return $this->setBlad('błąd usuwania klasy');
        }
        }
        else{
            return $this->setBlad('klasa ma już przypisanych uczniów');
        }
        return true;
    }
    function listaprzedmiotow($rekordownastrone, $url = null){
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $klasa = new ZapytaniaMysql();
        $klasa->select('przedmioty');
        $klasa->where('Id_Szkola', $_SESSION['UserId']);
        $klasa->limit($od, $do);
        if(isset($_POST['zapisz'])){
            if(!empty($_POST['nazwa_przedmiotu'])){
            $pytanie1 = new ZapytaniaMysql();
            $pytanie1->select('przedmioty');
            $pytanie1->where('Przedmiot_Nazwa', $_POST['nazwa_przedmiotu']);
            $pytanie1->andmysql('Id_Szkola', $_SESSION['UserId']);
            if($pytanie1->wykonajpytanie()->rowCount() == 0){
                $pytanie2 = new ZapytaniaMysql();
                $pytanie2->insert('przedmioty', 'Przedmiot_Nazwa, Id_Szkola', "".$_POST['nazwa_przedmiotu'].", ".$_SESSION['UserId']."");
                if($pytanie2->wykonajpytanie()){
                    $this->setBlad('dodano');
                }
            }
            else{
                $this->setBlad('Taki przedmiot już istnieje');
            }
            }
            else{
                $this->setBlad('Wpisz nazwę przedmiotu');
            }
        }
        return $klasa->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function wyswietllinkiprzedmioty($rekordownastrone, $url = null) {

        $klasa = new ZapytaniaMysql();
        $tab = array();
        $klasa->select('przedmioty');
        $klasa->where('Id_Szkola', $_SESSION['UserId']);
        for ($i = $url * $rekordownastrone; $i < floor($klasa->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }
    function przedmiotystrona($rekordownastrone){
        return $this->listaprzedmiotow($rekordownastrone, $this->url[3]);
    }
    function edytujprzedmiot(){
        $klasa = new ZapytaniaMysql();
        $klasa->select('przedmioty');
        $klasa->where('Id_Szkola', $_SESSION['UserId']);
        $klasa->andmysql('Id_Przedmiot', $this->url[2]);
        if(isset($_POST['zapisz'])){
            $pytanie = new ZapytaniaMysql();
            $pytanie->select('przedmioty');
            $pytanie->where('Przedmiot_Nazwa', $_POST['nazwa_przedmiotu']);
            $pytanie->andmysql('Id_Szkola', $_SESSION['UserId']);
            if($pytanie->wykonajpytanie()->rowCount() == 0){
                $pytanie2 = new ZapytaniaMysql();
                $pytanie2->update('przedmioty');
                $pytanie2->setmysql('Przedmiot_Nazwa', $_POST['nazwa_przedmiotu']);
                $pytanie2->where('Id_Przedmiot', $this->url[2]);
                $pytanie2->andmysql('Id_Szkola', $_SESSION['UserId']);
                $pytanie2->wykonajpytanie();
                return 'ok';
            }
            else{
                $this->setBlad('Przedmiot o tej nazwie już istnieje');
            }
        }
        return $klasa->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    function usunprzedmiot(){
        $klasa = new ZapytaniaMysql();
        $klasa->delete('przedmioty');
        $klasa->where('Id_Przedmiot', $this->url[2]);
        $klasa->andmysql('Id_Szkola', $_SESSION['UserId']);
        $klasa->wykonajpytanie();
        return true;
    }
    function godzinyzajecia($rekordownastrone, $url = null){
        if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
        $klasa = new ZapytaniaMysql();
        $klasa->select('godziny_zajec');
        $klasa->where('Id_Szkola', $_SESSION['UserId']);
        $klasa->limit($od, $do);
        if(isset($_POST['zapisz'])){
            if(!empty($_POST['godzinaod']) && !empty($_POST['godzinado'])){
            $pytanie1 = new ZapytaniaMysql();
            $pytanie1->select('godziny_zajec');
            $pytanie1->where('Id_Szkola', $_SESSION['UserId']);
            $dane = $pytanie1->wykonajpytanie();
            
            if($dane->rowCount() > 0){
                $minimum = $dane->fetchAll(PDO::FETCH_ASSOC)[($dane->rowCount())-1]['Do'];
                
            }
            else{
                $minimum = 0;
            }
            if(($_POST['godzinado'] > $_POST['godzinaod']) && ($_POST['godzinaod'] >= $minimum)){
                $pytanie2 = new ZapytaniaMysql();
                $pytanie2->insert('godziny_zajec', 'Od, Do, Id_Szkola', "".str_replace(array(',', '-', ':',' ', ';'), '.',$_POST['godzinaod']).",".str_replace(array(',', '-', ':',' ', ';'), '.',$_POST['godzinado']).",".$_SESSION['UserId']."");
                if($pytanie2->wykonajpytanie()){
                    $this->setBlad('dodano');
                }
            }
            else{
                $this->setBlad('Niepoprawny przedział czasowy');
            }
            }
            else{
                 $this->setBlad('Wypełnij wszystkie pola');
            }
        }
        return $klasa->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function godzinylinki($rekordownastrone, $url = null) {

        $klasa = new ZapytaniaMysql();
        $tab = array();
        $klasa->select('przedmioty');
        $klasa->where('Id_Szkola', $_SESSION['UserId']);
        for ($i = $url * $rekordownastrone; $i < floor($klasa->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }
    function edytujgodzina(){
        $klasa = new ZapytaniaMysql();
        $klasa->select('godziny_zajec');
        $klasa->where('Id_Godzina_zajec', $this->url[2]);
        $klasa->andmysql('Id_Szkola', $_SESSION['UserId']);
        if(isset($_POST['zapisz'])){
            if(!empty($_POST['godzinaod']) && !empty($_POST['godzinado'])){
                $zapytanie = new ZapytaniaMysql();
                $zapytanie->update('godziny_zajec');
                $zapytanie->setmysql('Od', str_replace(array(',', '-', ':',' ', ';'), '.',$_POST['godzinaod']));
                $zapytanie->setmysql('Do', str_replace(array(',', '-', ':',' ', ';'), '.',$_POST['godzinado']));
                $zapytanie->where('Id_Godzina_Zajec', $this->url[2]);
                $zapytanie->wykonajpytanie();
            }
            else{
                $this->setBlad('Wypełnij wszystkie pola');
            }
        }
        return $klasa->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    function pobierzoceny(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('lista_ocen');
        $pytanie->where('szkoly_Id_Szkola', $_SESSION['UserId']);
        if(isset($_POST['zapisz'])){
            if($_POST['ocenaid'] != "null" && !empty($_POST['nazwa_oceny'])){
            $pytanie2 = new ZapytaniaMysql();
            $pytanie2->insert('lista_ocen', 'Wartosc_Ocena, Ocena_Nazwa, szkoly_Id_Szkola', "".$_POST['ocenaid'].",".$_POST['nazwa_oceny'].",".$_SESSION['UserId']."");
            $pytanie2->wykonajpytanie();
            }
            else{
                $this->setBlad('Wypełnij wszystkie pola');
            }
        }
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function ocenaedycja(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('lista_ocen');
        $pytanie->where('Id_Ocena', $this->url[2]);
        $pytanie->andmysql('szkoly_Id_Szkola', $_SESSION['UserId']);
        $dane = $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        
        if(isset($_POST['zapisz'])){
            $pytanie2 = new ZapytaniaMysql();
            $pytanie2->update('lista_ocen');
            $pytanie2->setmysql('Wartosc_Ocena', $_POST['ocenaid']);
            $pytanie2->setmysql('Ocena_Nazwa', $_POST['nazwa_oceny']);
            $pytanie2->where('Id_Ocena', $dane['Id_Ocena']);
            $pytanie2->andmysql('szkoly_Id_Szkola', $_SESSION['UserId']);
            $pytanie2->wykonajpytanie();
        }
        return $dane;
    }
    function ocenausun(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('oceny_uczniow');
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'oceny_uczniow', 'Id_Przedmiot');
        $pytanie->where('Id_Ocena', $this->url[2]);
        $pytanie->andmysql('Id_Szkola', $_SESSION['UserId']);
        if($pytanie->wykonajpytanie()->rowCount() == 0){
        $klasa = new ZapytaniaMysql();
        $klasa->delete('lista_ocen');
        $klasa->where('Id_Ocena', $this->url[2]);
        $klasa->andmysql('szkoly_Id_Szkola', $_SESSION['UserId']);
        if($klasa->wykonajpytanie()){
        return true;
        }
        else{
            $this->setBlad('Błąd usuwania oceny');
        }
        }
        else{
            $this->setBlad('Ta ocena jest już w użyciu');
        }
    }
    function podzialsemestry(){
        $klasa = new ZapytaniaMysql();
        $klasa->select('semestry_podzial');
        $klasa->where('Id_Szkola', $_SESSION['UserId']);
        
        $dane = $klasa->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        $sem1od = explode('-', $dane['Semestr1_Od']);
        $sem1do = explode('-', $dane['Semestr1_Do']);
        $sem2od = explode('-', $dane['Semestr2_Od']);
        $sem2do = explode('-', $dane['Semestr2_Do']);
        
        if(!isset($_POST['zapiszsemestr'])){
            @$_POST['dziensem1od'] = $sem1od[1];
            @$_POST['miesiacsem1od'] = $sem1od[0];
            @$_POST['dziensem1do'] = $sem1do[1];
            @$_POST['miesiacsem1do'] = $sem1do[0];
            
            @$_POST['dziensem2od'] = $sem2od[1];
            @$_POST['miesiacsem2od'] = $sem2od[0];
            @$_POST['dziensem2do'] = $sem2do[1];
            @$_POST['miesiacsem2do'] = $sem2do[0];
        }
        else{
            if($klasa->wykonajpytanie()->rowCount() == 0){
            $pytanie = new ZapytaniaMysql();
            $pytanie->insert('semestry_podzial', 'Semestr1_Od, Semestr1_Do, Semestr2_Od, Semestr2_Do, Id_Szkola', "".$_POST['miesiacsem1od'].'-'.$_POST['dziensem1od'].","
                    . "".$_POST['miesiacsem1do'].'-'.$_POST['dziensem1do'].",".$_POST['miesiacsem2od'].'-'.$_POST['dziensem2od'].",".$_POST['miesiacsem2do'].'-'.$_POST['dziensem2do'].",".$_SESSION['UserId']."");
            if(!$pytanie->wykonajpytanie()){
                $this->setBlad('Wprowadzono niepoprawne wartości');
            }
        }
        else{
            $klasa2 = new ZapytaniaMysql();
            $klasa2->update('semestry_podzial');
            $klasa2->setmysql('Semestr1_Od', $_POST['miesiacsem1od'].'-'.$_POST['dziensem1od']);
            $klasa2->setmysql('Semestr1_Do', $_POST['miesiacsem1do'].'-'.$_POST['dziensem1do']);
            $klasa2->setmysql('Semestr2_Od', $_POST['miesiacsem2od'].'-'.$_POST['dziensem2od']);
            $klasa2->setmysql('Semestr2_Do', $_POST['miesiacsem2do'].'-'.$_POST['dziensem2do']);
            $klasa2->where('Id_Szkola', $_SESSION['UserId']);
            $klasa2->wykonajpytanie();
        }
        }
    }
    function promocjeklasy(){
        $pytanie3 = new ZapytaniaMysql();
        $pytanie4 = new ZapytaniaMysql();
        $pytanie2 = new ZapytaniaMysql();
        $pytanie2->select('okresy_promocyjne');
        $pytanie2->where('Id_Szkola', $_SESSION['UserId']);
        if(isset($_POST['cofnij'])){
            /*$pytanie2->update('klasy');
            $pytanie2->setmysql('Koniec_Promocji', 0);
            $pytanie2->where('Id_Klasa', $_POST['ktoraklasa']);
            $pytanie2->andmysql('Id_Szkola', $_SESSION['UserId']);
            $pytanie2->wykonajpytanie();*/
            
        }
        if(isset($_POST['rozpocznij'])){
            if($pytanie2->wykonajpytanie()->rowCount() == 1){
                $pytanie3->update('okresy_promocyjne');
                $pytanie3->setmysql('Udzielanie_Promocji', 1);
                $pytanie3->where('Id_Szkola', $_SESSION['UserId']);
            }
            if($pytanie2->wykonajpytanie()->rowCount() == 0){
                $pytanie3->insert('Okresy_Promocyjne', 'Udzielanie_Promocji, Id_Szkola', "1,".$_SESSION['UserId']."");
            }
            
            $pytanie4->update('klasy');
            $pytanie4->setmysql('Koniec_Promocji', 0);
            $pytanie4->where('Id_Szkola', $_SESSION['UserId']);
            $pytanie4->wykonajpytanie();
            
            $pytanie3->wykonajpytanie();
        }
        if(isset($_POST['anuluj'])){
            $pytanie3->select('uczniowie_nieklasyfikowani');
            $pytanie3->where('Id_Szkola', $_SESSION['UserId']);
            
            if($pytanie3->wykonajpytanie()->rowCount() == 0){
                
                $pytanie4->update('klasy');
            $pytanie4->setmysql('Koniec_Promocji', 1);
            $pytanie4->where('Id_Szkola', $_SESSION['UserId']);
            $pytanie4->wykonajpytanie();
            
            $pytanie5 = new ZapytaniaMysql();
            $pytanie5->update('okresy_promocyjne');
                $pytanie5->setmysql('Udzielanie_Promocji', 0);
                $pytanie5->where('Id_Szkola', $_SESSION['UserId']);
                $pytanie5->wykonajpytanie();
                
            }
            else{
                $this->setBlad('Nie można anulować procesu gdyż istnieją nieklasyfikowani uczniowie');
            }
        }
        $pytanie2->andmysql('Udzielanie_Promocji', 1);
        if($pytanie2->wykonajpytanie()->rowCount() == 1){
            
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('klasy');
        $pytanie->where('Id_Szkola', $_SESSION['UserId']);
        
        if(isset($_POST['zakoncz'])){
            $pytanie4->select('uczniowie_nieklasyfikowani');
            $pytanie4->where('Id_Szkola', $_SESSION['UserId']);
            if($pytanie4->wykonajpytanie()->rowCount() == 0){
            $pytanie->andmysql('Koniec_Promocji', 0);
            if($pytanie->wykonajpytanie()->rowCount() == 0){
            $pytanie3->update('okresy_promocyjne');
                $pytanie3->setmysql('Udzielanie_Promocji', 0);
                $pytanie3->where('Id_Szkola', $_SESSION['UserId']);
                $pytanie3->wykonajpytanie();
                
                $pytanie7 = new ZapytaniaMysql();
                $pytanie7->select('klasy');
                $pytanie7->where('Id_Szkola', $_SESSION['UserId']);
                $pytanie7->andmysql('Koniec_Promocji', 1);
                
                foreach($pytanie7->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC) as $klasa){
                    $tnijdane = substr($klasa['Klasa_Nazwa'],1,strlen($klasa['Klasa_Nazwa'])-1);
                    $zwiekszpoziom = $klasa['Klasa_Nazwa'][0]+1;
                    
                    $laczznaki = $zwiekszpoziom.$tnijdane;
                    $pytanie8 = new ZapytaniaMysql();
                    $pytanie8->update('klasy');
                    $pytanie8->setmysql('Klasa_Nazwa', $laczznaki);
                    $pytanie8->where('Id_Klasa', $klasa['Id_Klasa']);
                    $pytanie8->wykonajpytanie();
                }
            }
             else{
                 $this->setBlad('Nie wszyscy nauczyciele zakończyli proces promocyjny');
             } 
        }
        else{
                 $this->setBlad('Nie można zakończyć procesu gdyż istnieją nieklasyfikowani uczniowie');
             } 
        }
        return $pytanie->wykonajpytanie(PDO::FETCH_ASSOC);
        }
        else{
            return array();
        }
    }
    function otwarciepromocja(){
        
        $pytanie = new ZapytaniaMysql();
        $pytanie->update('klasy');
        $pytanie->setmysql('Koniec_Promocji', 0);
        $pytanie->where('Id_Klasa', $this->url[2]);
        $pytanie->andmysql('Id_Szkola', $_SESSION['UserId']);
        
        return $pytanie->wykonajpytanie();
        
    }
}

?>