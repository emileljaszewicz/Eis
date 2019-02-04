

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
        <form action="<?php echo $this->dolacz.'dziennik.html/dodajocene/'.$this->getOpcje()['daneuczen']['Id_Uczen'];?>" method="Post">
<p><div class="nazwa_pola">Ocena:</div>

            <div class="opcje"><select name="uczenocena">
                   
                    <?php
                    foreach ($this->getOpcje()['listaocen'] as $ocena) {
                        echo '<option value="' . $ocena['Id_Ocena'] . '">' . $ocena['Ocena_Nazwa'] . '</option>';
                        $licz++;
                    }
                    ?>
                </select></div></p>
                <p><div class="nazwa_pola">Rodzaj oceny:</div>

            <div class="opcje"><select name="ocena_za_co">
                   <option value="1">odpowiedź</option>
                   <option value="2">zadanie domowe</option>
                   <option value="3">kartkówka</option>
                   <option value="4">sprawdzian</option>
                </select></div></p>
<p><div class="nazwa_pola">Waga:</div>

            <div class="opcje"><select name="ocenawaga">
                   <option value="0">brak</option>
                    <?php
                    foreach ($this->getOpcje()['pobierzwagi'] as $waga) {
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
                        
                        echo '<option value="' . $waga['Waga'] . '">' . $waga['Waga'] .' - '.$dane. '</option>';
                        $licz++;
                    }
                    ?>
                </select></div></p>
                <p><div class="nazwa_pola">Opis:</div>

                <div class="opcje"><input type="text" name="wagaopis" /></div></p>
                <input type="submit" name="zapiszocena" value="zapisz"/> <a href="<?php echo $this->dolacz.'dziennik.html/listaocen'?>">anuluj</a>
        </form>
    </div>
</div>
