<?php
class UwierzytelnianieKontroler extends Kontroler{
	function __construct($kontroler, $url){
		parent:: __construct($kontroler, $url);
		
	}
        function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        if($model->walidujdane()){
            $this->przekierowanie('.');
        }
        else{
            $widok->wyswietlbledy($model->getBlad());
        }
        $widok->index();
    }
}