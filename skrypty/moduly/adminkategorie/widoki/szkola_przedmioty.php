<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="kategorie_lista">
        <div id="input_kontener">
            <div id="nazwa">Nazwa przedmiotu</div>
            <div id="wprowadzanie">
                <form action="<?php echo $this->dolacz;?>kategorie.html/szkolaprzedmioty" method="post">
            <input type="text" name="nazwa_przedmiotu" />
            <input type="submit" value="dodaj" name="zapisz" />
                </form>
            </div>
        </div>
        <?php
        if (sizeof($this->getOpcje()['listaprzedmiotow']) > 0) {
        echo '<div id="kategorie_tytul">Lista przedmiotów</div>';
            $licz = 1;
            foreach ($this->getOpcje()['listaprzedmiotow'] as $daneprzedmiot) {
                echo '<div class="katkontener"><div class="katid">' . $licz . '</div><div class="katnazwa">' . $daneprzedmiot['Przedmiot_Nazwa'] . '</div>
                    <div class="katopcje">
                    <a href="'.$this->dolacz.'kategorie.html/przedmiotedycja/'.$daneprzedmiot['Id_Przedmiot'].'">edytuj</a>
                    <a href="'.$this->dolacz.'kategorie.html/przedmiotusun/'.$daneprzedmiot['Id_Przedmiot'].'">usuń</a></div></div>';
                $licz++;
            }
            foreach ($this->getOpcje()['przedmiotylinki'] as $strony) {
                echo '<a href="' . $this->dolacz . 'kategorie.html/szkolaprzedmioty/przedmiotystrona/' . $strony . '" class="linkstrona">' . $strony . '</a>';
            }
        } else {
            echo 'Brak przedmiotów do wyświetlenia';
        }
        ?>
    </div>
</div>