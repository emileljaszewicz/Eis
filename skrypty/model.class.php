<?php

Class Model {
    
    private $wypiszblad;
private $zwrocdane;
    function __construct($url) {
        
        $this->url = str_replace(array(",",";","'", "%"), '', $url);
        
        $this->klasa = new UrlTranslator($this->url[count($this->url) - 1]);
        $this->licz_podkatalogi = new UrlTranslator($this->url);
        $this->dolacz = $this->licz_podkatalogi->katalog_gora();
        /* $this->klasa->znajdz_metode($this) */
        
        if(isset($this->url[1])){
             $this->url[1];
        }
        else{
            $this->url[1] = null;
        }
        if(isset($this->url[2])){
             $this->url[2];
        }
        else{
            $this->url[2] = null;
        }
        if(isset($this->url[3])){
             $this->url[2];
        }
        else{
            $this->url[3] = null;
        }
    }

    function tworzmenu($rangauzytkownik) {
        $moduly = miedzytagi('skrypty/moduly_dostep.txt', $rangauzytkownik);
        $plikotworz = file("skrypty/translacjeadresow.txt");
        $menulinki = file("skrypty/uzytkownikmenu.txt");
        $licz = 0;

        foreach ($plikotworz as $linia) {
            $link = explode(",", $linia);
            foreach ($moduly as $linki) {
                if (strstr($linia, trim($linki))) {
                    foreach ($menulinki as $nazwastrony) {
                        $linknazwa = explode("=>", $nazwastrony);
                        if(strstr($linknazwa[0], trim($link[0]))){
                    echo '<a href="'.$this->dolacz.$link[0].'">'.$linknazwa[1].'</a>';
                        }
                    }
                }
            }
            $licz++;
        }
    }
    function tworzstopke(){
        return '&copy Projekt autorstwa Emil Eljaszewicz';
    }
    function walidujformularz($tablicapost, $rodzajpola) {
        $ciag = null;
        $tablica = explode(",", $rodzajpola);
        foreach ($tablica as $dane) {
            switch ($dane) {
                case 'tekst':
                    $ciag .= 'a-zA-ZąęółżźńśćĄĘÓŁŻŹŃŚĆ\ ';
                    break;
                case 'cyfry':
                    $ciag .= '0-9';
                    break;
                case 'nip':
                    if(preg_match('/^[0-9]{11}+$/',$tablicapost)){
                        return true;
                    }
                    else{
                        return false;
                    }
                case 'kodpoczta':
                    if(preg_match('/^[0-9]{2}-[0-9]{3}+$/',$tablicapost)){
                        return true;
                    }
                    else{
                        return false;
                    }
                    break;
                case 'email':
                    if(preg_match('/^[a-zA-Z0-9.\-]+@[a-z0-9]+\.[a-z]{2,4}/',$tablicapost)){
                        return true;
                    }
                    else{
                        return false;
                    }
                    break;
                    
            }
        }
        if (preg_match('/^[' . $ciag . ']+$/', $tablicapost)) {
            return true;
        }
        return false;
    }

    function setBlad($blad) {
        if (strlen($blad) > 0) {
            $this->wypiszblad = '<div id="blad_komunikat">'.$blad.'</div>';
        }
    }

    function getBlad() {
        return $this->wypiszblad;
    }
    function setDane($zmiennazdanymi){
        $this->zwrocdane = $zmiennazdanymi;
    }
function getDane(){
    return $this->zwrocdane;
}
    
    function nullpost($tablica){
        foreach($tablica as $post){
            $_POST[$post] = null;
        }
        return false;
    }
   
}

?>