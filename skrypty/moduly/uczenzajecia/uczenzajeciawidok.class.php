<?php

class UczenzajeciaWidok extends Widok {


    function __construct($kontroler, $url) {
        $this->setTytulstrony("Plan zajęć");
        parent:: __construct($kontroler, $url);
        $this->setSzablonglowny('szablonglowny/indexszablon.php');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/menu.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/wyswietlanie.css');
        $this->setCssdodatkowy('szablonglowny/style/dodatkowe/formularz.css');
    }

    function planzajec() {
     
        $this->setWidokmodul("plan_zajec");
        $this->szablonglowny();
    }

}

?>