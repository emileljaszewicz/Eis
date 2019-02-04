<?php
function laczzbaza(){
    $ciag = null;
		try {
			$polaczenie = new PDO('mysql:host=nazwa_hosta;dbname=nazwa_bazy_danych', '_login_do_bazy_danych', 'haslo_do_bazy_danych');
			$polaczenie->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch (PDOException $blad) {
                                    $ciag .= "Brak połączenia z bazą danych!!<br>";
                                    $ciag .= "#przyczyna: ";
                                switch($blad->getCode()){
                                    case 1045:
                                        $ciag .= "błędny login lub hasło.<br>";
                                        break;
                                    case 1049:
                                        $ciag .= "Wprowadzono błędną nazwę bazy danych<br>";
                                        break;
                                    default:
                                        $ciag = $blad->getMessage();
                                        break;
                                }
                                $ciag .= "#kod błędu: ".$blad->getCode()."<br>";
                                $ciag .= "#ścieżka: ".$blad->getTrace()[0]['file'];
                       die($ciag);
		}
		
                return $polaczenie;
		
	}
function miedzytagi($plik, $ciag){
	if(is_file($plik)){
		$file = fopen($plik, "r");
  $plikotworz =  file($plik);
$licz = 0;
$tab2 = array();
$tab3 = array();
  for($i = 0; $i < sizeof($plikotworz); $i++){
	  if(strstr(trim($plikotworz[$i]), $ciag)){
		  $tab[] = $i;
		  if(sizeof($tab)%2 == 0){
			  $dzieltablica = implode(',',$tab);
			  $tab2[] = $dzieltablica;
			  $tab = null;
		  }
	  }
	  
  }
  foreach($tab2 as $dane){
	  $dziel = explode(",", $dane);
	 for($y = $dziel[0]+1; $y < $dziel[1]; $y++){
		 $tab3[$y] = $plikotworz[$y];
	 }
  }
	}
	else{
		return false;
	}
	return $tab3;
}
function tablicawartosc($tablica, $nrindex){
    
    $licz = 1;
    foreach($tablica as $index=>$wartosc){
        if($licz == $nrindex){
            $wartoscwybrana = $wartosc;
            break;
        }
            $licz++;
    }
    return $wartoscwybrana;
}
function kodybledow($bladkod){
    $plik = file('skrypty/kodybledow.txt');
    $licz = 0;
    for($i = 0; $i < sizeof($plik); $i++){
        $dziellinia = explode('=>',$plik[$i]);
        if($dziellinia[0] == $bladkod){
            return $dziellinia[1];
            break;
        }
    }
}
function dzientygodnia($int){
    switch($int){
        case 1: $dziennazwa = "Poniedziałek";
            break;
        case 2: $dziennazwa = "Wtorek";
            break;
        case 3: $dziennazwa = "Środa";
            break;
        case 4: $dziennazwa = "Czwartek";
            break;
        case 5: $dziennazwa = "Piątek";
            break;
        case 6: $dziennazwa = "Sobota";
            break;
        case 7: $dziennazwa = "Niedziela";
            break;
    }
    return $dziennazwa;
}
function tnijtekst($string, $znakinawiersz = 18, $dlugosctekstu = 150){
    return substr(chunk_split($string, $znakinawiersz), 0, $dlugosctekstu);
}
?>