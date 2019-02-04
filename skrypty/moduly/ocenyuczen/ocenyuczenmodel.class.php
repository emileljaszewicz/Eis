<?php

class OcenyuczenModel extends Model {

    private $blad;

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }
    function pobierzprzedmioty(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('plany_zajec_nauczyciele', 'distinct(plany_zajec_nauczyciele.Id_Przedmiot), Przedmiot_Nazwa');
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'plany_zajec_nauczyciele', 'Id_Przedmiot');
        $pytanie->leftjoin('konta_uczniowie', 'Id_Klasa', 'plany_zajec_nauczyciele', 'Id_Klasa');
        $pytanie->where('konta_uczniowie.Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $pytanie->andmysql('konta_uczniowie.Id_Uczen', $_SESSION['UserId']);
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
    }
    function ocenyuczen(){
        if (!isset($_SESSION['uczenoceny'])) {
                 $_SESSION['uczenoceny'] = null;
             }
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('oceny_uczniow');
        $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
        $pytanie->where('Id_Uczen', $_SESSION['UserId']);
        $kopiujpytanie = clone $pytanie;
            $this->setLiczsemestry($kopiujpytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC), 'Data_Wystawienia', 'uczenoceny');
            if($kopiujpytanie->wykonajpytanie()->rowCount() > 0 && $_SESSION['uczenoceny'] != null){
            $pytanie->andmysql('Data_Wystawienia', $_SESSION['uczenoceny'][0], ">=");
            $pytanie->andmysql('Data_Wystawienia', $_SESSION['uczenoceny'][1], "<=");
            }
            
        return $pytanie->wykonajpytanie()->fetchAll();
    }
    function rodzajsredniej($przedmiotid) {
        
            $pytanie = new ZapytaniaMysql();
            $pytanie->select('przedmioty_rodzaje_srednich', 'distinct(przedmioty_rodzaje_srednich.Id_Przedmiot),przedmioty_rodzaje_srednich.Id_Nauczyciel, Wartosc');
            $pytanie->leftjoin('oceny_uczniow', 'Id_Przedmiot', 'przedmioty_rodzaje_srednich', 'Id_Przedmiot');
            $pytanie->leftjoin('uczen_dane', 'Id_Uczen', 'oceny_uczniow', 'Id_Uczen');
            $pytanie->where('oceny_uczniow.Id_Przedmiot', $przedmiotid);
            $pytanie->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        
            return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        
    }
    function liczsrednia($dane) {
        $dziel = explode(',', $dane);
        $dane = $this->rodzajsredniej($dziel[1])['Wartosc'];
        
        if (sizeof($dane) == 0) {
            $dane = 1;
        }
        $pytanie = new ZapytaniaMysql();
        switch ($dane) {
            case 1:
                $pytanie->select('oceny_uczniow', '(sum(lista_ocen.Wartosc_Ocena)/count(Id_Ocena_Ucznia)) As Wynik');
                $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
                $pytanie->where('oceny_uczniow.Id_Przedmiot', $dziel[1]);
                $pytanie->andmysql('oceny_uczniow.Id_Uczen', $dziel[0]);
                $pytanie->andmysql('Data_Wystawienia', @$_SESSION['uczenoceny'][0], ">=");
                $pytanie->andmysql('Data_Wystawienia', @$_SESSION['uczenoceny'][1], "<=");
                return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                break;
            case 2:
                $pytanie->select('oceny_uczniow', '(sum(lista_ocen.Wartosc_Ocena*oceny_uczniow.Ocena_Waga)/sum(oceny_uczniow.Ocena_Waga)) As Wynik');
                $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
                $pytanie->where('oceny_uczniow.Id_Przedmiot', $dziel[1]);
                $pytanie->andmysql('oceny_uczniow.Id_Uczen', $dziel[0]);
                $pytanie->andmysql('Data_Wystawienia', $_SESSION['uczenoceny'][0], ">=");
            $pytanie->andmysql('Data_Wystawienia', $_SESSION['uczenoceny'][1], "<=");
                return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
                break;
        }
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

    function ocenakoncowa($dane) {
        $dziel = explode(',', $dane);
        $pytanie1 = new ZapytaniaMysql();
        $pytanie1->select('oceny_semestralne');
        $pytanie1->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_semestralne', 'Id_Ocena');
        $pytanie1->where('Id_Uczen', $dziel[0]);
        $pytanie1->andmysql('Id_Przedmiot', $dziel[1]);
        $pytanie1->andmysql('Data_Oceny', @$_SESSION['uczenoceny'][0], ">=");
            $pytanie1->andmysql('Data_Oceny', @$_SESSION['uczenoceny'][1], "<=");
        if ($pytanie1->wykonajpytanie()->rowCount() == 1) {
            return $pytanie1->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        } else {
            echo null;
        }
    }
    function wyswietlbledy() {
        return $this->getBlad();
    }
    function pobierzocene(){
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('oceny_uczniow', 'distinct(Id_Ocena_Ucznia), Wartosc_Ocena, Ocena_Waga, Za_Co, concat(Imie, " ", Nazwisko) as Kto, Ocena_Opis, Data_Wystawienia, Przedmiot_Nazwa');
        $pytanie->leftjoin('lista_ocen', 'Id_Ocena', 'oceny_uczniow', 'Id_Ocena');
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'oceny_uczniow', 'Id_Przedmiot');
        $pytanie->leftjoin('plany_zajec_nauczyciele', 'Id_Przedmiot', 'oceny_uczniow', 'Id_Przedmiot');
        $pytanie->leftjoin('konta_nauczyciele', 'Id_Nauczyciel', 'plany_zajec_nauczyciele', 'Id_Nauczyciel');
        $pytanie->where('Id_Ocena_Ucznia', $this->url[2]);
        $pytanie->andmysql('Id_Uczen', $_SESSION['UserId']);
        $pytanie->andmysql('plany_zajec_nauczyciele.Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        
        return $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
    }
    function setLiczsemestry($tablica, $kolumnadaty, $nazwasesji) {
       $tab = array();
        
             
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('semestry_podzial');
        $pytanie->where('Id_Szkola', $_SESSION['danezalogowany']['Id_Szkola']);

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
      if(isset($_POST['sesjasemestr'])){
          
          $dzielprzedzial = explode("/", $_POST['data']);
          $_SESSION[$nazwasesji] = $dzielprzedzial;
      } 
        
        
        $this->tab = $tab;
    }
 function getLiczsemestry(){
     return $this->tab;
 }
}

?>