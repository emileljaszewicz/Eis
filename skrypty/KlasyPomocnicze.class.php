<?php

class ZnajdzString {

    function __construct($ciagznakow = null, $szukanyciag) {
        $this->ciagznakow = $ciagznakow;
        $this->szukanyciag = $szukanyciag;
    }

    function szukajciag() {

        $licz = 0;
        $tablica = array();
        foreach ($this->ciagznakow as $wartosci) {
            if ($this->szukanyciag == trim($wartosci)) {
                $tablica[$licz] = $this->szukanyciag;
            }
            $licz++;
        }

        return $tablica;
    }

    function wyciagnijwartosc($nrindeks = null) {
        if ($nrindeks != null) {
            $licz = 1;
            $zwrocwartosc = null;
            foreach ($this->szukajciag() as $indeks => $wartosc) {
                if ($licz == $nrindeks) {
                    $zwrocwartosc = $wartosc;
                    break;
                }
                $licz++;
            }
            return $zwrocwartosc;
        }
        
    }

}

class ZapytaniaMysql {

    private $dodaj;
    private $tab = array();
    private $jointab = array();
    private $uniontab = array();
    private $unionselectalltab = array();
    private $nulltab = array();
    function insert($tabela, $kolumny, $danedokolumn) {
        $tablica = array();
        //$danedokolumn = str_replace(' ', '', $danedokolumn);
        if(!is_array($danedokolumn)){
        $dzieldane = explode(',', $danedokolumn);
        }
        else{
          $dzieldane = $danedokolumn;  
        }
        foreach ($dzieldane as $wartosci) {
            
            $tablica[] = "'" . $wartosci . "'";
        }
        $this->dodaj .= "Insert Into $tabela ($kolumny) Values(" . implode(',', $tablica) . ");";
        return $this->dodaj;
    }

    function select($tabela, $kolumny = '*') {
        $this->dodaj .= "Select $kolumny From $tabela";
        return $this->dodaj;
    }
function selectdistinct($tabela, $kolumny = '*') {
        $this->dodaj .= "Select Distinct $kolumny From $tabela";
        return $this->dodaj;
    }
    function where($kolumna, $wartosc, $znak = '=') {
        $wartosc = str_replace(array(",",";","'", "%"), '', $wartosc);
        $this->dodaj .= " Where $kolumna $znak '$wartosc'";
        return $this->dodaj;
    }
function isnull($kolumna){
    $this->dodaj .= " And $kolumna Is Null";
    return $this->dodaj;
}
    function andmysql($kolumna, $wartosc, $znakporownania = '=') {
        $this->dodaj .= " And $kolumna $znakporownania '$wartosc'";
        return $this->dodaj;
    }
    function porownajkolumny($warunek, $kolumna1, $kolumna2){
        $this->dodaj .= " $warunek $kolumna1 = $kolumna2";
        return $this->dodaj;
    }
    function ormysql($kolumna, $wartosc) {
        $this->dodaj .= " Or $kolumna = '$wartosc'";
        return $this->dodaj;
    }

    function limit($od, $do) {
        $this->dodaj .= " Limit $od,$do";
        return $this->dodaj;
    }

    function offset($ile) {
        $this->dodaj .= " Offset $ile";
        return $this->dodaj;
    }

    function update($tabela) {
        $this->dodaj .= "Update $tabela Set";
        return $this->dodaj;
    }

    function setmysql($kolumna, $wartosc) {
        $dane = null;
        if (count($this->tab) == 0) {
            $this->tab[0] = " $kolumna= '$wartosc'";
        } else {
            $this->tab[count($this->tab)] = " $kolumna= '$wartosc'";
        }

        if (count($this->tab) > 1) {
            $dane .= ', ';
        }

        $this->dodaj .= $dane . $this->tab[count($this->tab) - 1];
        return $this->dodaj;
    }
function setnull($kolumna) {
    $dane = null;
        if (count($this->tab) == 0) {
            $this->tab[0] = " $kolumna= Null";
        } 
        else {
            $this->tab[count($this->tab)] = " $kolumna= Null";
        }
        if (count($this->tab) > 1) {
            $dane .= ', ';
        }
        $this->dodaj .= $dane . $this->tab[count($this->tab) - 1];
        return $this->dodaj;
    }
    function delete($nazwatabeli, $odniesienie = null) {
        $this->dodaj .= " Delete $odniesienie From $nazwatabeli";
        return $this->dodaj;
    }
    function deletein($tabela, $kolumna, $rekordy){
        $this->dodaj .= " Delete From $tabela Where $kolumna In (".implode(',', $rekordy).')';
        return $this->dodaj;
    }
    function deletenotin($tabela, $kolumna, $rekordy){
        $this->dodaj .= " Delete From $tabela Where $kolumna Not In (".implode(',', $rekordy).')';
        return $this->dodaj;
    }
    function leftjoin($tabela, $kolumna, $tabela2, $kolumna2){
       
            $this->jointab[count($this->tab)] = " Left Join ".$tabela." On ".$tabela2.".".$kolumna."=".$tabela.".".$kolumna2;

        $this->dodaj .= $this->jointab[count($this->jointab) - 1];
        return $this->dodaj;
    }
    function unionselect($tabela, $kolumna='*'){
       
            $this->uniontab[count($this->uniontab)] = " Union Select ".$kolumna." From ".$tabela;

        $this->dodaj .= $this->uniontab[count($this->uniontab) - 1];
        return $this->dodaj;
    }
    function unionall($selectkolumny, $zktorejtabeli){
        $this->unionselectalltab[count($this->unionselectalltab)] = " Union All Select ".$selectkolumny." From ".$zktorejtabeli;
       
       $this->dodaj .= $this->unionselectalltab[count($this->unionselectalltab) - 1];
        return $this->dodaj; 
    }
    function orderby($nazwapola, $opcja){
        $this->dodaj .= "Order by ".$nazwapola." ".$opcja;
        return $this->dodaj; 
    }
function innerjoin($tabela, $tab1kol1, $tab2kol2){
    $this->dodaj .= " Inner Join".$tabela." On ".$tab1kol1."=".$tab2kol2;
    return $this->dodaj;
}
    function wykonajpytanie() {
        //echo $this->dodaj;
       try{
        $pytanie = laczzbaza()->prepare($this->dodaj);
        $pytanie->execute();
            return $pytanie;
       }
       catch (PDOException $e){
           $this->setMysqlblad($e->getMessage());
          $this->setMysqlerrorinfo($e->errorInfo[1]);
       }
        return false;
        
    }
    private function setMysqlblad($blad){
        $this->blad = $blad;
    }
    function getMysqlblad(){
        return $this->blad;
    }
    private function setMysqlerrorinfo($blad){
        $this->blad2 = $blad;
    }
    function getMysqlerrorinfo(){
        return $this->blad2;
    }
    
}
class LiczSemestr{
    
    function __construct($rokbierzacy){
        $this->rok = $rokbierzacy;
    }
    function ktorysemestr(){
        
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('semestry_podzial');
        $pytanie->where('Id_Szkola', $_SESSION['klasadane']['Id_Szkola']);
        
        $dane = $pytanie->wykonajpytanie()->fetch(PDO::FETCH_ASSOC);
        $roksem1 = date('Y');
        $roksem2 = $roksem1+1;
        $roksemestr1od = $roksem1.'-'.$dane['Semestr1_Od'];
        $roksemestr2od = $roksem2.'-'.$dane['Semestr2_Od'];
        
        $sem1od = strtotime($roksemestr1od);
        $sem2od = strtotime($roksemestr2od);
        
        if($sem1od < $sem2od){
            echo 'semestr1 do '.$dane['Semestr1_Do'];
        }
        else{
            echo 'semestr2 do '.$dane['Semestr2_Do'];
        }
        $czas1 = mktime(0, 0, 0, 12, 0, 2017);
        $czas2 = mktime(0, 0, 0, 12, 0, 2017);
        
    }
}
