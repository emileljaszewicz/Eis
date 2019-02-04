

<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php
    if(!empty($this->getOpcje()['daneuzytkownik']['Id_Uczen'])){
        ?>
    <div class="pasek_informacje">
        <div class="dziel_informacje">Szczegóły obecności użytkownika <b><?php echo $this->getOpcje()['daneuzytkownik']['Imie'].' '.$this->getOpcje()['daneuzytkownik']['Nazwisko'] ?></b> z dnia 
            <?php echo date("d.m.Y", strtotime($this->getOpcje()['daneuzytkownik']['Data_Listy'])) ?>
        </div>
        <div class="dziel_informacje">Przedmiot: <?php echo $this->getOpcje()['daneuzytkownik']['Przedmiot_Nazwa'] ?>
        </div>
    </div>
    <div id="nowy_dzien_kontener">
        <form action="<?php echo $this->dolacz.'twoja_klasa.html/obecnoscedycja/'.$this->getOpcje()['daneuzytkownik']['Id_Nieobecnosc'].'/'.$this->getOpcje()['daneuzytkownik']['Id_Uczen'];?>" method="Post">
<p><div class="nazwa_pola">Status:</div>

            <div class="opcje"><select name="uczenobecnosc">
                   
                    <?php
                    
                    $tab = array(1=>"spóźniony", 0=>"nieobecny", 2=>"usprawiedliwiony", null=>"obecny");
                    foreach ($tab as $id=>$rodzajnieobecnosc) {
                        if(($id == $this->getOpcje()['daneuzytkownik']['Rodzaj_Nieobecnosci']) ){
                            $opcja = 'selected';
                        }
                        else{
                            $opcja = '';
                        }
                        echo '<option value="' . $id . '" '.$opcja.'>' . $rodzajnieobecnosc . '</option>';
                    }
                    ?>
                </select></div></p>
                <input type="submit" name="zapiszobecnosc" value="zapisz"/> <a href="<?php echo $this->dolacz.'twoja_klasa.html'?>">anuluj</a>
        </form>
    </div>
    <?php
    }
    else{
        echo 'nie ma takiego ucznia';
    }
    ?>
</div>
