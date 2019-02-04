

<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="nowy_dzien_kontener">
        <form action="<?php echo $this->dolacz.'dziennik.html/edytujwage/'.$this->getOpcje()['wagaedycja']['Id_Waga_Nauczyciel']?>" method="Post">

<p><div class="nazwa_pola">Waga:</div>

<div class="opcje"><input type="text"  name="nauczycielwaga" value="<?php echo $this->getOpcje()['wagaedycja']['Waga'] ?>"/></div></p>
        <p><div class="nazwa_pola">Opis wagi:</div>

            <div class="opcje"><select name="wagarodzaj">
                    <?php
                    $rodzajoceny = array(1=>"odpowiedź", 2=>"zadanie domowe", 3=>"kartkówka", 4=>"sprawdzian");
                    foreach ($rodzajoceny as $rodzaj=>$opis) {
                        if($rodzaj == $this->getOpcje()['wagaedycja']['Waga_Opis']){
                            $zaznacz = 'selected';
                        }
                        else{
                            $zaznacz = '';
                        }
                        echo '<option value="' . $rodzaj . '" '.$zaznacz.'>' . $opis . '</option>';
                        $licz++;
                        
                    }
                    ?>
                </select></div></p>
                <input type="submit" name="zapiszwaga" value="zapisz"/> <a href="<?php echo $this->dolacz ?>dziennik.html/dodajwagi">anuluj</a>
                <a href="<?php echo $this->dolacz.'dziennik.html/usunwage/'.$this->getOpcje()['wagaedycja']['Id_Waga_Nauczyciel']?>">usuń</a>
        </form>
        
    </div>
</div>
