

<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="nowy_dzien_kontener">
        <form action="<?php echo $this->dolacz.'dziennik.html/dodajwagi'?>" method="Post">

<p><div class="nazwa_pola">Waga:</div>

<div class="opcje"><input type="text"  name="nauczycielwaga" /></div></p>
        <p><div class="nazwa_pola">Opis wagi:</div>

            <div class="opcje"><select name="wagarodzaj">
                   <option value="1">odpowiedź</option>
                   <option value="2">zadanie domowe</option>
                   <option value="3">kartkówka</option>
                   <option value="4">sprawdzian</option>
                </select></div></p>
                <input type="submit" name="zapiszwaga" value="zapisz"/> 
        </form>
        <br>
        <div id="wagi_kontener">
        <div class="waga_dane_kontener" style="margin-bottom:2vw;"><div class="waga_lewa">Waga</div><div id="waga_prawa">Opis</div></div>
        <?php 
        foreach($this->getOpcje()['nauczycielwagi'] as $waga){
            switch($waga['Waga_Opis']){
                case 1:
                    $dane = "odpowiedź";
                    break;
                case 2:
                    $dane = "zadanie domowe";
                    break;
                case 3:
                    $dane = "kartkówka";
                    break;
                case 4:
                    $dane = "sprawdzian";
                    break;
            }
        echo '<div class="waga_dane_kontener" style="margin-bottom:1vw;clear:both;"><div class="waga_lewa">'.$waga['Waga'].'</div><div class="waga_prawa">'.$dane.'</div>
                <div class="waga_link"><a href="'.$this->dolacz.'dziennik.html/edytujwage/'.$waga['Id_Waga_Nauczyciel'].'">edytuj</a></div>
             <div class="wyrownaj"></div></div>';
        }
        ?>
        </div>
    </div>
</div>
