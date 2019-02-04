<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <?php
    echo '<form action="'.$this->dolacz.'kategorie.html/promocje" method="Post" >';
    if(sizeof($this->getOpcje()['listaklas']) > 0){
    echo '<div id="promocje_kontener">
    <p>
        <div class="kategoria belka_kolor">Klasa</div>
        <div class="akcja belka_kolor">Status</div>
        <div class="akcja belka_kolor">Akcja</div>
    </p>';
    
    
    foreach($this->getOpcje()['listaklas'] as $klasa){
        echo '<p>
        <div class="kategoria">'.$klasa['Klasa_Nazwa'].'</div>
        <div class="akcja">';
        if($klasa['Koniec_Promocji'] == 1){
            echo 'zakończono';
        }
        else{
            echo 'czeka';
        }
        echo '</div>
        <div class="akcja">';
        if($klasa['Koniec_Promocji'] == 1){
            
            echo '<a href="'.$this->dolacz.'kategorie.html/cofnijzamkniecie/'.$klasa['Id_Klasa'].'">cofnij</a>';
        }
        
        echo '</div>
    </p>';
    }
    
    echo '</div>';
    }
    ?>
    <div id="promocje_opcje">
        
        <?php
        if(sizeof($this->getOpcje()['listaklas']) == 0){
    echo '<input type="submit" value="rozpocznij okres promocyjny" name="rozpocznij"/>';
        }
        else{
            echo '<input type="submit" value="zakończ okres promocyjny" name="zakoncz"/>';
            echo '<input type="submit" value="anuluj" name="anuluj" style="margin-left:2vw;"/>';
        }
        echo '</form>';
        ?>
    </div>
</div>
