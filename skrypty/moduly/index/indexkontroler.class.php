<?php
class IndexKontroler extends Kontroler{
	function __construct($kontroler, $url){
		parent:: __construct($kontroler, $url);
                $widok = new IndexWidok($kontroler, $url);
	}
        function index(){
            $widok = $this->ladujwidok();
            $model = $this->ladujmodel()->wyswietldane();
             $widok->index();
        }
        function wyslijformularz(){
            $model = $this->ladujmodel()->dodajdane();
             $this->przekierowanie("wyslanoform");
        }
        function wyslanoform(){
            $widok = $this->ladujwidok();
            $widok->danewyslane();
        }
}