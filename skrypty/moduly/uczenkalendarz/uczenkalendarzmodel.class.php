<?php

class UczenkalendarzModel extends Model {

    private $blad;

    function __construct($url) {
        $this->url = $url;
        parent::__construct($this->url);
    }
    function kalendarz($dane){
        $dziel = explode(',', $dane);
        if(isset($_POST['miesiac']) && isset($_POST['rok'])){
            $dziel[0] = $_POST['miesiac'];
            $dziel[1] = $_POST['rok'];
        }
       
        $dane = new Kalendarz($dziel[0], $dziel[1]);
        
        
        return $dane->tworz_kalendarz();
    }
    function databierzaca(){
        if(!isset($_POST['miesiac'])){
        $_POST['miesiac'] = date('m');
        $_POST['rok'] = date('Y');
        }
    }
    function wydarzeniedata(){
        $dane = explode("-", $this->url[2]);
        $pytanie = new ZapytaniaMysql();
        $pytanie->select('kalendarz_wydarzenia');
        $pytanie->leftjoin('konta_nauczyciele', 'Id_Nauczyciel', 'kalendarz_wydarzenia', 'Id_Nauczyciel');
        $pytanie->leftjoin('przedmioty', 'Id_Przedmiot', 'kalendarz_wydarzenia', 'Id_Przedmiot');
        $pytanie->where('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
        $pytanie->andmysql('Data_Wydarzenia', "".$dane[2]."-".$dane[1]."-".$dane[0]."");
        
        return $pytanie->wykonajpytanie()->fetchAll(PDO::FETCH_ASSOC);
        
    }
}
class Kalendarz{
	function __construct($miesiac, $rok){
		$this->miesiac = $miesiac;
		$this->rok = $rok;
	}
	function ile_dni_w_miesiacu(){
		return date("t", mktime(0,0,0,$this->miesiac,1,$this->rok));
	}
	function dni_do_pierwszego_dnia_miesiaca(){
		return date("N", mktime(0,0,0,$this->miesiac,1,$this->rok))-1;
	}
	function dzien_tygodnia($dzienmiesiaca){
            
            if(($this->dni_do_pierwszego_dnia_miesiaca()+$dzienmiesiaca)%7 == 1){
                echo '<p>';
            }
            
		if(($this->dni_do_pierwszego_dnia_miesiaca()+$dzienmiesiaca)%7 == 0){
		echo $this->ostatni_dzien_miesiaca($dzienmiesiaca).'</p>';
	}
        else{
            echo $this->ostatni_dzien_miesiaca($dzienmiesiaca);
        }
	
	}
        function ostatni_dzien_miesiaca($dzien){
            if($dzien <= $this->ile_dni_w_miesiacu()){
                return $this->sprawdz_wydarzenie($dzien);
            }
            else{
                return '&nbsp;';
            }
        }
        function sprawdz_wydarzenie($dzien){
            $pytanie = new ZapytaniaMysql();
            $pytanie->select('kalendarz_wydarzenia');
            $pytanie->where('Data_Wydarzenia', "".$this->rok."-".$this->miesiac."-".$dzien."");
            $pytanie->andmysql('Id_Klasa', $_SESSION['danezalogowany']['Id_Klasa']);
            
            if($pytanie->wykonajpytanie()->rowCount() > 0){
                return '<div class="kalendarz_pole" style="background: #fecbcb"><a href="terminy.html/idzdodaty/'.$dzien.'-'.$this->miesiac.'-'.$this->rok.'" style="display:inline-block">'.$dzien.'</a></div>';
            }
            else{
                return '<div class="kalendarz_pole" >'.$dzien.'</div>';
            }
        }
        
        function dodaj_dni_iteracji(){
            return 7-date("N",strtotime($this->rok."-".$this->miesiac."-".$this->ile_dni_w_miesiacu()));
        }
	function tworz_kalendarz(){
		$licz = 1;
		$dni_przed_pierwszym = 1;
                echo '<div id="kalendarz_kontener">';
                echo '<div id="dni_tygodnia">
        <p>
        <div class="dzien_tygodnia">Pn</div>
        <div class="dzien_tygodnia">Wt</div>
        <div class="dzien_tygodnia">Śr</div>
        <div class="dzien_tygodnia">Czw</div>
        <div class="dzien_tygodnia">Pt</div>
        <div class="dzien_tygodnia">So</div>
        <div class="dzien_tygodnia">Nd</div>
        </p>
    </div>';
                echo '<div id="dni_miesiaca">';
		while($licz <= $this->ile_dni_w_miesiacu()+$this->dodaj_dni_iteracji()){
			if($dni_przed_pierwszym-$this->dni_do_pierwszego_dnia_miesiaca() <= 0){
                            echo '<div class="kalendarz_pole" >&nbsp;</div>';
				
				$dni_przed_pierwszym++;
			}
			else{
			 $this->dzien_tygodnia($licz);
			$licz++;
		}
			
		}
                echo '</div></div>';
	}
}
?>