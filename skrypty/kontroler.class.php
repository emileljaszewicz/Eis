<?php

class Kontroler {

    function __construct($kontroler, $url) {
        $this->plik = 'skrypty/moduly/';
        $this->kontroler = $kontroler;
        
        $this->url = str_replace(array(",",";","'", "%"), '', $url);
        
        $this->ladujmodel();
        
        
        
        if (isset($url[1])) {
            $metoda = $url[1];
            
            if(method_exists($this->kontroler.'Kontroler',$metoda)){
            $this->$metoda();
            }
            else{
                echo '<b>Adres wybranej strony nie istnieje!!</b>';
            }
        }
        else {
            $this->index();
        }
        
    
        
    }

    function ladujmodel() {
        require_once($this->plik . '/' . $this->kontroler . '/' . $this->kontroler . 'model.class.php');
        $ob = $this->kontroler . 'model';
        $model = new $ob($this->url);
        return $model;
    }

    function ladujwidok() {
        require_once($this->plik . '/' . $this->kontroler . '/' . $this->kontroler . 'widok.class.php');
        $ob = $this->kontroler . 'widok';
        $widok = new $ob($this->kontroler, $this->url);
        return $widok;
    }
    function wyloguj(){
        session_destroy();
        $this->przekierowanie('..');
    }

    /*function widokmodul($widoknazwa) {
        $this->ladujwidok()->$widoknazwa();
    }*/
    function przekierowanie($url) {
        header('location:' . $url);
    }

}

?>