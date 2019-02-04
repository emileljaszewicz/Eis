<?php
class IndexModel extends Model{
	function __construct($url){
            $this->url = $url;
            parent::__construct($this->url);
	}
        function dodajdane(){
           $_POST['dane'];
        }
        function wyswietldane(){
            echo 'działanie dla index';
        }
        function costam(){
            
        }
}
?>