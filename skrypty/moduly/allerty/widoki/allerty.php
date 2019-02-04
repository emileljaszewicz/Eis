
<div id="szkoly_kontener">
    <div id="podmenu">
       <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div id="szkoly_lista">
        <?php
        if(sizeof($this->getOpcje()['wyswietlszkoly']) > 0){
        foreach($this->getOpcje()['wyswietlszkoly'] as $dane){
        echo '<div class="powiadomienie_kontener">
            <div class="powiadomienie_belka">
            <div class="powiadomienie_tytul">Nowa rejestracja</div>
            <div class="powiadomienie_data">Dnia '.$dane['Data_Rejestracji'].'</div>
            </div>
            <div class="powiadomienie_tresc"><a href="'.$this->dolacz.'listaszkol.html/szkolapokaz/'.$dane['Id_Szkola'].'">'.$dane['Nazwa_Szkoly'].'</a>prosi o rejestrację.</div>
        </div>';
        }
        foreach($this->getOpcje()['linkistron'] as $strona){
             echo '<a href="'.$this->dolacz.'powiadomienia.html/strona/'.$strona.'" class="linkstrona">'.$strona.'</a>';
        }
        }
        else{
            echo 'Brak nowych rejestracji.';
        }
                ?>
    </div>
</div>