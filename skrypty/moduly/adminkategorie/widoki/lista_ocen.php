<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="kategorie_lista">
        <div id="input_kontener2">
            <div id="nazwa">Nazwa oceny</div>
            <div id="wprowadzanie">
                <form action="<?php echo $this->dolacz;?>kategorie.html/listaocen" method="post">
            <input type="text" name="nazwa_oceny"/>
            <select name="ocenaid">
                <option value="Null">wybierz ocenę</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
            <input type="submit" value="dodaj" name="zapisz" />
                </form>
            </div>
        </div>
        <div id="kategorie_tytul">Lista ocen</div>
        <?php
        if (sizeof($this->getOpcje()['listaocen']) > 0) {
            $licz = 1;
            foreach ($this->getOpcje()['listaocen'] as $dane) {
                echo '<div class="katkontener"><div class="katid">' . $licz . '</div><div class="katnazwa">' . $dane['Ocena_Nazwa'] . '</div>
                    <div class="katopcje">
                    <a href="'.$this->dolacz.'kategorie.html/ocenaedycja/'.$dane['Id_Ocena'].'">edytuj</a>
                    <a href="'.$this->dolacz.'kategorie.html/ocenausun/'.$dane['Id_Ocena'].'">usuń</a></div></div>';
                $licz++;
            }
            
        } else {
            echo 'Brak klas do wyświetlenia';
        }
        
        ?>
    </div>
</div>