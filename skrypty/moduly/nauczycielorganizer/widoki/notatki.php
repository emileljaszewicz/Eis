
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    
    <div class="notatki_kontener">
        <a href="<?php echo $this->dolacz ?>organizer.html/nowanotatka"><div class="notatka_ramka" style="text-align:center;">
                dodaj nową notatkę</div></a>
        <?php
        foreach($this->getOpcje()['notatki'] as $notatka){
        echo '<a href="'.$this->dolacz.'organizer.html/edytujnotatka/'.$notatka['Id_Notatka'].'"><div class="notatka_ramka">
            <div class="notatka_tytul">'.$notatka['Notatka_Tytul'].'</div>
            <div class="notatka_tresc">'. nl2br(tnijtekst($notatka['Notatka_Tresc'])).'</div>
            </div></a>';
        }
        ?>
        
    </div>
    <?php
    echo '<div id="stronicowanie">';
        foreach($this->getOpcje()['linki'] as $strony){
            echo '<a href="'.$this->dolacz.'organizer.html/notatkastrona/'.$strony.'" class="linkstrona">'.$strony.'</a>';
        }
        echo '</div>';
    ?>
</div>