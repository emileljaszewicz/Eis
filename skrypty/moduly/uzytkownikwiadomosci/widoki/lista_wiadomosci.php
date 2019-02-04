<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="wiadomosci">
        
    <?php
    if(sizeof($this->getOpcje()['wiadlista']) > 0){
        echo '<form action="'.$this->dolacz.'wiadomosci.html/wiadusun" method="post">';
        foreach($this->getOpcje()['wiadlista'] as $dane){
            echo '<div class="wiadomosc_kontener"><div class="opcja"><input type="checkbox" name="wiadomoscusun[]" value="'.$dane['Id_Wiadomosc'].'"/></div>
                    ';
            if($dane['Czyja_Wiadomosc'] == 1){
                
                echo '<a href="'.$this->dolacz.'wiadomosci.html/pokazwyslana/'.$dane['Id_Wiadomosc'].'">';
            }
            else{
                echo '<a href="'.$this->dolacz.'wiadomosci.html/wiadpokaz/'.$dane['Id_Wiadomosc'].'">';
            }
            if($dane['Stan'] == 0){
                echo '<div class="wiadomosc_nieprzeczytana">';
            }
            else{
                echo '<div class="wiadomosc_przeczytana">';
            }
            echo '<div class="wiadomosc_ikona">';
            if($dane['Stan'] == 0){
                echo '<img src="'.$this->dolacz.'szablonglowny/zdjecia/nieodebrane.png">';
            }
            else{
                echo '<img src="'.$this->dolacz.'szablonglowny/zdjecia/odebrane.png">';
            }
            echo '</div>';
            echo '<div class="wiadomosc_autor">';
            switch($this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Ranga_Nazwa']){
                case 'Szkola':
                    echo $this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Nazwa_Szkoly'];
                    break;
                default:
                    echo $this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Imie'];
                    break;
            }
            echo '</div>';
            echo '<div class="wiadomosc_temat">'.$dane['Wiadomosc_Tytul'].'</div>';
            echo '</div>';
            echo '</a></div>';
            
        }
        
        echo '<input type="submit" name="usunwiadomosci" value="usuń"/>';
        echo '</form>';
        echo '<div id="stronicowanie">';
        foreach($this->getOpcje()['wiadstrony'] as $strony){
            echo '<a href="'.$this->dolacz.'wiadomosci.html/wiadomoscstrona/'.$strony.'" class="linkstrona">'.$strony.'</a>';
        }
        echo '</div>';
    }
        else{
            echo 'Brak wiadomości';
        }
     ?>
    </div>
</div>