<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div id="wiadomosc_wyswietl">
        
    <?php if(is_array($this->getOpcje()['czytajwiadomosc'])){
        $dane = $this->getOpcje()['czytajwiadomosc'];
        echo '<div id="temat_wiadomosci">'.$dane['Wiadomosc_Tytul'].'</div>
        <div id="tresc_wiadomosci"> 
        '.nl2br($dane['Wiadomosc_Tresc']).'
            <div id="szczegoly_wiadomosci">
            <div id="autor_wiadomosci">
                <p>Wysłane przez:</p>
                <p>';
        
        switch($this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Ranga_Nazwa']){
                case 'Szkola':
                    echo $this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Nazwa_Szkoly'].''
                        . ' ( '
                        . $this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Ranga_Nazwa'].' )';
                    break;
                default:
                    echo $this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Imie'].' '
                        . ''.$this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Nazwisko'].' ( '
                        .$this->getOpcje()['wiadomoscszczegoly'][$dane['Id_Wiadomosc']]['Ranga_Nazwa']. ' )';
                    break;
            }
        echo '</p>
            </div>
            <div id="data_wiadomosci">
                <p>Dnia:</p>
                <p>'.$dane['Data_Wyslania'].'</p>
            </div>
            </div>
        </div>';
        
    }
        else{
            echo 'Nie ma takiej wiadomości';
        }
     ?>
        <a href="<?php echo $this->dolacz;?>wiadomosci.html">powrót</a>
    </div>
</div>