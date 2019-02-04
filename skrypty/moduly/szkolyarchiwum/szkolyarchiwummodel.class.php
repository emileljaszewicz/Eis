<?php

class SzkolyArchiwumModel extends Model {

    private $blad;

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }
function pobierzszkoly($rekordownastrone, $url = null){
    if ($url == null or $url == 0) {
            $od = 0;
            $do = $rekordownastrone;
        } else {
            $od = $url * $rekordownastrone;
            $do = $rekordownastrone;
        }
    $pytanie = new ZapytaniaMysql();
    $pytanie->select('szkoly');
    $pytanie->where('Status', 2);
    $pytanie->limit($od, $do);
    return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
}
function kolejnestrony($rekordownastrone){
    return $this->pobierzszkoly($rekordownastrone, $this->url[2]);
}
function wyswietllinkistron($rekordownastrone, $url = null) {

        $klasa = new ZapytaniaMysql();
        $tab = array();
        $klasa->select('szkoly', 'Id_Szkola');
        $klasa->where('Status', 2);
        for ($i = $url * $rekordownastrone; $i < floor($klasa->wykonajpytanie()->rowCount() / $rekordownastrone); $i++) {
            $tab[] = $i;
        }


        return $tab;
    }
}

?>