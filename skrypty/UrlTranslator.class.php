<?php
class UrlTranslator{
    private $przekazmodul;
    private $przekazadres;
    function __construct($url){
        $this->plik = "skrypty/translacjeadresow.txt";
        $this->plikotworz = file($this->plik);
        $this->url = $url;
    }
    function znajdzkontroler(){
        for($i = 0; $i < count($this->plikotworz); $i++){
           $dziellinia = explode(",", $this->plikotworz[$i]);
		if($dziellinia[0] == $this->url[0]){
			$this->przekazmodul = trim($dziellinia[1]);
			break;
		}
        }
        if($this->przekazmodul){
        return $this->przekazmodul;
        }
        else{
            return false;
        }
    }
    
    function katalog_gora(){
        $ile = count($this->url);
        $result = str_repeat('../', $ile-1);
        
        return $result;
       
    }
    function znajdz_metode($obiekt){
        if(method_exists($obiekt, $this->url)){
            echo 'ok';
        }
        return false;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

