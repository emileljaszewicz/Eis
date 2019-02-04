

<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div class="pasek_informacje">
        <div class="dziel_informacje">Szczegóły obecności użytkownika <b><?php echo $this->getOpcje()['daneuzytkownik']['Kto'] ?></b> z dnia 
            <?php echo date("d.m.Y", strtotime($this->getOpcje()['daneuzytkownik']['Data_Listy'])) ?>
        </div>
        <div class="dziel_informacje">Przedmiot: <?php echo $_SESSION['przedmiot']['Przedmiot_Nazwa'] ?>
        </div>
    </div>
    <div id="nowy_dzien_kontener">
        <form action="<?php echo $this->dolacz.'dziennik.html/obecnoscedycja/'.$this->getOpcje()['daneuzytkownik']['Id_Lista_Nieobecnosc'].'/'.$this->getOpcje()['daneuzytkownik']['Id_Uczen'];?>" method="Post">
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
                <input type="submit" name="zapiszobecnosc" value="zapisz"/> <a href="<?php echo $this->dolacz.'dziennik.html/wyswietldzienlista/'.$this->getOpcje()['daneuzytkownik']['Id_Lista_Nieobecnosc'];?>">anuluj</a>
        </form>
    </div>
</div>
