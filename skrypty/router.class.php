<?php

require_once('skrypty/filtry/funkcje.php');
require_once('skrypty/UrlTranslator.class.php');
require_once('skrypty/KlasyPomocnicze.class.php');

Class Router {
 
    private $modulurl = "skrypty/moduly/";

    function __construct($url) {
        
        $this->laczzbaza = laczzbaza();
        $this->url = strtolower($url);
        $this->dzieladres = explode('/', $this->url);
        $this->translatorurl = new UrlTranslator($this->dzieladres);
        if (isset($_SESSION['Ranga'])) {
            $string = new ZnajdzString(miedzytagi('skrypty/moduly_dostep.txt', $_SESSION['Ranga']), $this->translatorurl->znajdzkontroler());
            if(isset($_SESSION['wychowawca']) && $_SESSION['wychowawca'] == 'Wychowawca'){ // Może sprawiać problemy
                $string2 = new ZnajdzString(miedzytagi('skrypty/moduly_dostep.txt', $_SESSION['wychowawca']), $this->translatorurl->znajdzkontroler());
            
            }
            else{
                $string2 = null;
            }
           
        } else {
            if(is_dir($this->modulurl.'stronakonfig')){
                $string = new ZnajdzString(miedzytagi('skrypty/moduly_dostep.txt', "Konfadmin"), $this->translatorurl->znajdzkontroler());
                $string2 = null;
            }
            else{
               
            $string = new ZnajdzString(miedzytagi('skrypty/moduly_dostep.txt', "Gosc"), $this->translatorurl->znajdzkontroler());
            $string2 = null;
            }
        }
        if ($this->url == null) {
            if(is_dir('skrypty/moduly/stronakonfig')){
                $ranga = "Konfadmin";  
            }
            if(!isset($_SESSION['Ranga']) && !is_dir('skrypty/moduly/stronakonfig')){
                $ranga = "Gosc";
            }
            if(isset($_SESSION['Ranga'])){
                $ranga = $_SESSION['Ranga'];
            }
            
            header('location:' . $this->tlumaczadres(trim(tablicawartosc(miedzytagi('skrypty/moduly_dostep.txt', $ranga), 1))));
        }
        
        if ($string->wyciagnijwartosc(1) or (is_object($string2) && $string2->wyciagnijwartosc(1))) { // $string2 ->problemy
            $link = 'skrypty/moduly/' . $this->translatorurl->znajdzkontroler() . '/' . $this->translatorurl->znajdzkontroler() . 'kontroler.class.php';
            if (file_exists($link)) {
                require_once($link);
                $ob = $this->translatorurl->znajdzkontroler() . 'kontroler';
                $kontroler = new $ob($this->translatorurl->znajdzkontroler(), $this->dzieladres);
            } else {
                include('404.html');
            }
        } else {
            echo "<b>Wpisałeś niepoprawny adres bądź nie masz uprawnień do tej strony!!</b>";
        }
    }

    private function tlumaczadres($modul) {
        $przekazmodul = null;
        $plik = file("skrypty/translacjeadresow.txt");
        for ($i = 0; $i < count($plik); $i++) {
            $dziellinia = explode(",", $plik[$i]);
            if (isset($dziellinia[1])) {
                if (trim($dziellinia[1]) == $modul) {
                    $przekazmodul = trim($dziellinia[0]);
                    break;
                }
            }
        }
        return $przekazmodul;
    }

}
