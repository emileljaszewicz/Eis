<?php
class NowyUzytkownikKontroler extends Kontroler{
	function __construct($kontroler, $url){
		parent:: __construct($kontroler, $url);
		
	}
        function index() {
        $widok = $this->ladujwidok();
        $model = $this->ladujmodel();
        if($model->walidujdane()){
            $widok->wyswietlbledy('Dane zostały zapisane. Wyloguj się i zaloguj podając login i hasło');
        }
        else{
            $widok->wyswietlbledy($model->getBlad());
        }
        $widok->index();
    }
}