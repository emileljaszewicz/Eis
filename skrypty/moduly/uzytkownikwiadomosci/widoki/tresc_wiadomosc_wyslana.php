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
            <div id="szczegoly_wiadomosci">';
            echo '
            <div id="data_wiadomosci">
                <p>Wysłano dnia:</p>
                <p>'.$dane['Data_Wyslania'].'</p>
            </div>
            </div>
        </div>';
        
    }
        else{
            echo 'Nie ma takiej wiadomości';
        }
     ?>
        <a href="<?php echo $this->dolacz;?>wiadomosci.html/wiadwyslane">powrót</a>
    </div>
</div>