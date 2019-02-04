<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="kategorie_lista">
        <div id="input_kontener2">
            <div id="nazwa">Nazwa klasy</div>
            <form action="<?php echo $this->dolacz;?>kategorie.html/klasaedycja/<?php echo $this->getOpcje()['url'];?>" method="post">
            <div id="wprowadzanie">
            <input type="text" name="nazwa_klasy" value="<?php echo $this->getOpcje()['daneklasa']['Klasa_Nazwa'] ?>"/>
            <select name="nauczycielid">
                <option value="Null">wybierz wychowawcę</option>
                <?php
                foreach ($this->getOpcje()['nauczyciele'] as $nauczyciel) {
                    if($nauczyciel['Id_Nauczyciel'] == $this->getOpcje()['daneklasa']['Id_Nauczyciel']){
                        $opcja = ' selected=selected';
                    }
                    else{
                        $opcja = '';
                    }
                    echo '<option value="'.$nauczyciel['Id_Nauczyciel'].'"'.$opcja.'>'.$nauczyciel['Imie'].' '.$nauczyciel['Nazwisko'].'</option>';
                }
                ?>
            </select>
                
            </div>
            <div id="formaprzyciski">
                <input type="submit" value="dodaj" name="zapisz" />
                <a href="<?php echo $this->dolacz;?>kategorie.html">anuluj</a>
            </div>
            </form>
        </div>
    </div>
</div>