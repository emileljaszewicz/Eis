<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="obecnosci_lista">
        <?php
        if (isset($_SESSION['klasadane'])) {
          ?>
        <div id="nauczyciel_opcje" style="margin-bottom:0vw;">
        Listy obecności klasy: <?php echo $_SESSION['klasadane']['Klasa_Nazwa'] ?>. Przedmiot: 
        <form action="<?php echo $this->dolacz;?>dziennik.html/listyobecnosci" method="Post">
        <select name="przedmiotid">
            <?php
            foreach($this->getOpcje()['przedmiotynauczyciel'] as $listaprzedmiotow){
            if($listaprzedmiotow['Id_Przedmiot'] == $_SESSION['przedmiot']['Id_Przedmiot']){
                    $opcja = 'selected';
                }
                else{
                    $opcja = '';
                }
            echo '<option value="'.$listaprzedmiotow['Id_Przedmiot'].'" '.$opcja.'>'.$listaprzedmiotow['Przedmiot_Nazwa'].'</option>';
            }
            ?>
        </select>
            <input type="submit" name="sesjaprzedmiot" value="ok" />
        </form>
    </div>
      
        <?php
        if (isset($_SESSION['przedmiot']) && isset($_SESSION['klasadane'])) {
                echo '<div id="nauczyciel_opcje">
        Semestr: 
        <form action="'.$this->dolacz.'dziennik.html/listyobecnosci" method="Post">
        <select name="data">';
            foreach($this->getOpcje()['wyswietlsemestry'] as $semestrdane){
            if($semestrdane['Zakres_Semestr'] == $_SESSION['przedzialsemestr'][0].'/'.$_SESSION['przedzialsemestr'][1]){
                $opcja = 'selected';
            } 
            else{
                $opcja = '';
            }
            echo '<option value="'.$semestrdane['Zakres_Semestr'].'" '.$opcja.'>'.$semestrdane['Przedzial_Semestr'].' '.$semestrdane['Nazwa_Semestr'].'</option>';
            
            }
            
        echo '</select>
            <input type="submit" name="sesjasemestr" value="ok" />
        </form>
    </div>';
        if(sizeof($this->getOpcje()['listyobecnosci']) > 0){
                $licz = 1;
            foreach ($this->getOpcje()['listyobecnosci'] as $lista) {
                echo '<div class="katkontener"><div class="katid">' . $licz . '</div><div class="katnazwa"><a style="color:#096fec;" href="'.$this->dolacz.'dziennik.html/wyswietldzienlista/'.$lista['Id_Lista_Nieobecnosc'].'">Lista z dnia ' .date("d.m.Y", strtotime($lista['Data_Listy'])) . '</a></div></div>';
                $licz++;
            }
            foreach ($this->getOpcje()['linkistron'] as $strony) {
                echo '<a href="' . $this->dolacz . 'dziennik.html/listyobecnosci/stronalisty/' . $strony . '" class="linkstrona">' . $strony . '</a>';
            }
            }
            else{
                echo 'Wybierz semestr i wciśnij ok';
            }
            echo '<div id="link"><a href="'.$this->dolacz.'dziennik.html/dodajliste">nowa lista obecności</a></div>';
        } else {
            echo 'Wybierz przedmiot i wciśnik ok';
        }
        }
        else{
            echo 'Nie wybrano żadnej klasy';
        }
        ?>
    </div>
</div>