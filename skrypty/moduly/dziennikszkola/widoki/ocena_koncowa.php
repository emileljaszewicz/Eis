

<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div class="pasek_informacje">
        <div class="dziel_informacje">Dodawanie oceny semestralnej dla ucznia <b><?php echo $this->getOpcje()['daneuczen']['Imie'].' '.$this->getOpcje()['daneuczen']['Nazwisko']  ?></b>
        </div>
        <div class="dziel_informacje">Przedmiot: <?php echo $_SESSION['przedmiot']['Przedmiot_Nazwa'] ?>
        </div>
    </div>
    <div id="nowy_dzien_kontener">
        <form action="<?php echo $this->dolacz.'dziennik.html/ocenakoncowa/'.$this->getOpcje()['daneuczen']['Id_Uczen'];?>" method="Post">
<p><div class="nazwa_pola">Ocena:</div>

            <div class="opcje"><select name="uczenocena">
                   <option value= null >brak</option>
                    <?php
                    foreach ($this->getOpcje()['listaocen'] as $ocena) {
                        if($ocena['Id_Ocena'] == $this->getOpcje()['ocenakoncowa']['Id_Ocena']){
                            $opcja = 'selected';
                        }
                        else{
                            $opcja = '';
                        }
                        echo '<option value="' . $ocena['Id_Ocena'] . '" '.$opcja.'>' . $ocena['Ocena_Nazwa'] . '</option>';
                        $licz++;
                    }
                    ?>
                </select></div></p>
                
                <input type="submit" name="zapiszocena" value="zapisz"/> <a href="<?php echo $this->dolacz.'dziennik.html/listaocen'?>">anuluj</a>
        </form>
    </div>
</div>
