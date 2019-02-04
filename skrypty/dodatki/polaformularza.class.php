<?php
class Formularz{
    private $poleformularz;
    function __construct($nazwaakcji, $nazwakontenera, $nazwaformularza){
        $this->nazwa = $nazwaakcji;
        $this->nazwakontenera = $nazwakontenera;
        $this->nazwaformularza = $nazwaformularza;
    }
    function dodajpole($opis,$typ, $nazwapola){
        switch($typ){
            case 'text':
                $forma = 
                    '<div id="formularz_pole">'
                    . '<p><h1>'.$opis.'</h1></p>'
                    . '<p><input type="text" name="'.$nazwapola.'" /></p>'
                    . '</div>';
                break;
            case 'radio':
                $forma = '<input type="radio" name="'.$nazwapola.'" />';
                break;
            case 'select':
                $forma = '<input type="select" name="'.$nazwapola.'" />';
                break;
            case 'submit':
                $forma = '<input type="submit" name="'.$nazwapola.'" value="'.$opis.'"/>';
                break;
        }
        $this->poleformularz .= $forma;
    }
    function zwrocpole(){
        return $this->poleformularz;
    }
    function wysfietlformularz(){
        return '<div id="'.$this->nazwakontenera.'"><div id="formularz_nazwa">'.$this->nazwaformularza.'</div>'.$this->zwrocpole().'</div></div>';
    }
}
?>

