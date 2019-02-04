<?php
class RejestracjaKontroler extends Kontroler{
	function __construct($kontroler, $url){
		parent:: __construct($kontroler, $url);
		
	}
        function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        $widok->wyswietlbledy($this->ladujmodel()->wyswietldane());
        /*$this->ladujmodel()->wyswietlbledy();*/
        $widok->setWyswietlopcje($model->wyswietlpola());
    
        $widok->index();
    }
        
}