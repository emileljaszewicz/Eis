<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="kategorie_lista">
        <div id="input_kontener2">
            <div id="nazwa">Nazwa klasy</div>
            <div id="wprowadzanie">
                <form action="<?php echo $this->dolacz;?>kategorie.html/dodajklase" method="post">
            <input type="text" name="nazwa_klasy"/>
            <select name="nauczycielid">
                <option value="Null">wybierz wychowawcę</option>
                <?php
                foreach ($this->getOpcje()['nauczyciele'] as $nauczyciel) {
                    echo '<option value="'.$nauczyciel['Id_Nauczyciel'].'">'.$nauczyciel['Imie'].' '.$nauczyciel['Nazwisko'].'</option>';
                }
                ?>
            </select>
            <input type="submit" value="dodaj" name="zapisz" />
                </form>
            </div>
        </div>
        <div id="kategorie_tytul">Lista klas</div>
        <?php
        if (sizeof($this->getOpcje()['listakategorii']) > 0) {
            $licz = 1;
            foreach ($this->getOpcje()['listakategorii'] as $dane) {
                echo '<div class="katkontener"><div class="katid">' . $licz . '</div><div class="katnazwa">' . $dane['Klasa_Nazwa'] . '</div>
                    <div class="katopcje">
                    <a href="'.$this->dolacz.'kategorie.html/klasaedycja/'.$dane['Id_Klasa'].'">edytuj</a>
                    <a href="'.$this->dolacz.'kategorie.html/klasausun/'.$dane['Id_Klasa'].'">usuń</a></div></div>';
                $licz++;
            }
            foreach ($this->getOpcje()['linkistron'] as $strony) {
                echo '<a href="' . $this->dolacz . 'kategorie.html/strona/' . $strony . '" class="linkstrona">' . $strony . '</a>';
            }
        } else {
            echo 'Brak klas do wyświetlenia';
        }
        
        ?>
    </div>
</div>