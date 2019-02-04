
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="szkoly_lista">
        <form action="<?php echo $this->dolacz;?>kategorie.html/zajeciagodziny" method="post">
            <span>godzina</span><span>od: <input type="text" name="godzinaod"> Do: <input type="text" name="godzinado">
                <input type="submit" value="dodaj" name="zapisz" style="width:4vw; font-size:0.7vw; padding:0.3vw;"/></span>
        </form>
        <?php 
        if (sizeof($this->getOpcje()['godziny']) > 0) {
        echo '<div id="kategorie_tytul">Godziny zajęć</div>';
            $licz = 1;
            foreach ($this->getOpcje()['godziny'] as $godzina) {
                echo '<div class="katkontener"><div class="katid">' . $licz . '</div><div class="katnazwa">' . number_format($godzina['Od'],2,':','').' - '.number_format($godzina['Do'],2,':',''). '</div>
                    <div class="katopcje">
                    <a href="'.$this->dolacz.'kategorie.html/godzinaedycja/'.$godzina['Id_Godzina_Zajec'].'">edytuj</a>
                    <a href="'.$this->dolacz.'kategorie.html/godzinausun/'.$godzina['Id_Godzina_Zajec'].'">usuń</a></div></div>';
                $licz++;
            }
            foreach ($this->getOpcje()['linkistron'] as $strony) {
                echo '<a href="' . $this->dolacz . 'kategorie.html/zajeciagodziny/godzinystrona/' . $strony . '" class="linkstrona">' . $strony . '</a>';
            }
        } else {
            echo 'Brak danych do wyświetlenia';
        }
        ?>
    </div>
</div>