<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="obecnosci_lista">
        <?php
        if (isset($_SESSION['klasadane'])) {
          ?>
        <div id="nauczyciel_opcje">
        Terminy zaliczeń klasy: <?php echo $_SESSION['klasadane']['Klasa_Nazwa'] ?>. Przedmiot: 
        <form action="<?php echo $this->dolacz; ?>dziennik.html/terminarz" method="Post">
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
        foreach ($this->getOpcje()['powiadomienia'] as $info) {
        echo '<div class="powiadomienie_kontener">
            <div class="powiadomienie_belka">
            <div class="powiadomienie_data">'.date('d.m.Y', strtotime($info['Data_Wydarzenia'])).'</div>
            <div class="powiadomienie_tytul">- '.$info['Wydarzenie_Nazwa'].'</div>';
        echo '<div style="float:right; margin: 0.5vw 1vw 0vw 0vw;"><a href="'.$this->dolacz.'dziennik.html/edytujtermin/'.$info['Id_Wydarzenie'].'" style="margin-right:1vw;">edytuj</a>
        <a href="'.$this->dolacz.'dziennik.html/usuntermin/'.$info['Id_Wydarzenie'].'">usuń</a></div>';
            
echo '</div>
            <div class="powiadomienie_tresc">'.$info['Wydarzenie_Tresc'].'</div>
        </div>';
        }
        echo '<a href="'.$this->dolacz.'dziennik.html/nowytermin">dodaj nowy termin</a>';
        }
        else {
            echo 'Wybierz przedmiot i wciśnik ok';
        }
        
                ?>
        <?php
        
        }
        else{
            echo 'Nie wybrano żadnej klasy';
        }
        ?>
    </div>
</div>