<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="kategorie_lista">
        <div id="input_kontener">
            <div id="nazwa">Nazwa kategorii</div>
            <div id="wprowadzanie">
                <form action="<?php echo $this->dolacz;?>listaszkol.html/szkolykategorie" method="post">
            <input type="text" name="nazwa_kategorii" />
            <input type="submit" value="dodaj" name="zapisz" />
                </form>
            </div>
        </div>
        <div id="kategorie_tytul">Lista kategorii</div>
        <?php
        if (sizeof($this->getOpcje()['listakategorii']) > 0) {
            $licz = 1;
            foreach ($this->getOpcje()['listakategorii'] as $id => $szkola) {
                echo '<div class="katkontener"><div class="katid">' . $licz . '</div><div class="katnazwa">' . $szkola . '</div>
                    <div class="katopcje">
                    <a href="'.$this->dolacz.'listaszkol.html/katedycja/'.$id.'">edytuj</a>
                    <a href="'.$this->dolacz.'listaszkol.html/katusun/'.$id.'">usuń</a></div></div>';
                $licz++;
            }
            foreach ($this->getOpcje()['kategoriestrony'] as $strony) {
                echo '<a href="' . $this->dolacz . 'listaszkol.html/szkolykategorie/katstrona/' . $strony . '" class="linkstrona">' . $strony . '</a>';
            }
        } else {
            echo 'Brak szkół do wyświetlenia';
        }
        ?>
    </div>
</div>