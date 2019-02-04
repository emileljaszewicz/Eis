<div id="szkoly_kontener">
    <div id="podmenu">
       <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="szkoly_lista">
        <?php
        if(sizeof($this->getOpcje()['wyswietlogloszenia']) > 0){
        foreach($this->getOpcje()['wyswietlogloszenia'] as $dane){
        echo '<div class="powiadomienie_kontener">
            <div class="powiadomienie_belka">
            <div class="powiadomienie_tytul">'.$dane['Ogloszenie_Tytul'].'</div>
            <div class="powiadomienie_data">Przez: '.$dane['Ranga_Nazwa'].' <div style="display:inline-block; margin-left:1vw;">Dnia '.$dane['Data_Wyslania'].'</div></div>';
            if($dane['Id_Ranga_Nadawca'] == $_SESSION['RangaId']){
        echo '<a href="'.$this->dolacz.'ogloszenia.html/ogloszenieusun/'.$dane['Id_Ogloszenie'].'" style="float:right; margin: 0.5vw 1vw 0vw 0vw;">usuń</a>';
            }
echo '</div>
            <div class="powiadomienie_tresc">'.$dane['Ogloszenie_Tresc'].'</div>
        </div>';
        }
        foreach($this->getOpcje()['linkistron'] as $strona){
             echo '<a href="'.$this->dolacz.'ogloszenia.html/strona/'.$strona.'" class="linkstrona">'.$strona.'</a>';
        }
        }
        else{
            echo 'Brak ogłoszeń.';
        }
                ?>
    </div>
</div>