

<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div class="pasek_informacje">
        <div class="dziel_informacje">Dodawanie oceny dla ucznia <b><?php echo $this->getOpcje()['daneuczen']['Imie'].' '.$this->getOpcje()['daneuczen']['Nazwisko']  ?></b>
        </div>
        <div class="dziel_informacje">Przedmiot: <?php echo $_SESSION['przedmiot']['Przedmiot_Nazwa'] ?>
        </div>
    </div>
    <div id="nowy_dzien_kontener">
        <form action="<?php echo $this->dolacz.'dziennik.html/edytujocene/'.$this->getOpcje()['ocenaedycja']['Id_Uczen'].'/'.$this->getOpcje()['ocenaedycja']['Id_Ocena_Ucznia'];?>" method="Post">
<p><div class="nazwa_pola">Ocena:</div>
            <div class="opcje"><select name="uczenocena">
                   
                    <?php
                    foreach ($this->getOpcje()['listaocen'] as $ocena) {
                        if($ocena['Id_Ocena'] == $this->getOpcje()['ocenaedycja']['Id_Ocena']){
                            $zaznacz = 'selected';
                        }
                        else{
                            $zaznacz = '';
                        }
                        echo '<option value="' . $ocena['Id_Ocena'] . '" '.$zaznacz.'>' . $ocena['Ocena_Nazwa'] . '</option>';
                        $licz++;
                        
                    }
                    ?>
                </select></div></p>
                <p><div class="nazwa_pola">Rodzaj oceny:</div>
               
            <div class="opcje"><select name="ocena_za_co">
                   
                    <?php
                    $rodzajoceny = array(1=>"odpowiedź", 2=>"zadanie domowe", 3=>"kartkówka", 4=>"sprawdzian");
                    foreach ($rodzajoceny as $rodzaj=>$opis) {
                        if($rodzaj == $this->getOpcje()['ocenaedycja']['Za_Co']){
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
                <p><div class="nazwa_pola">Waga:</div>
            <div class="opcje"><select name="ocenawaga">
                   <option value="0" >brak</option>
                    <?php
                    foreach ($this->getOpcje()['listawag'] as $waga) {
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
                        if($waga['Waga'] == $this->getOpcje()['ocenaedycja']['Ocena_Waga']){
                            $zaznacz = 'selected';
                        }
                        else{
                            $zaznacz = '';
                        }
                        echo '<option value="' . $waga['Waga'] . '" '.$zaznacz.'>' . $waga['Waga'] .' - '.$dane. '</option>';
                        $licz++;
                        
                    }
                    ?>
                </select></div></p>
                <p><div class="nazwa_pola">Opis:</div>

                <div class="opcje"><input type="text" name="ocenaopis" value="<?php echo $this->getOpcje()['ocenaedycja']['Ocena_Opis'] ?>"/></div></p>
                <div id="nowy_dzien_kontener">
                <input type="submit" name="zapiszocena" value="zapisz"/> 
                <a href="<?php echo $this->dolacz.'dziennik.html/listaocen'?>" style="margin:0vw 1vw 0vw 1vw;">anuluj</a>
                <input type="submit" name="usunocena" value="usuń"/> 
                </div>
        </form>
    </div>
</div>
