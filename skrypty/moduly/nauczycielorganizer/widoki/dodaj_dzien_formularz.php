
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); 
    if(sizeof($this->getOpcje()['bladdodajdane']) >= 1){
        $nauczyciel = $this->getOpcje()['bladdodajdane'];
        echo '<div id="bladprzedmiot_szczegoly">';
        echo '<p>Nauczyciel: '.$nauczyciel['Imie'].' '.$nauczyciel['Nazwisko'].'</p>';
        echo '<p>Uczy w sali: '.$nauczyciel['Sala_Uczy'].'</p>';
        echo '<p>Przedmiot: '.$nauczyciel['Przedmiot_Nazwa'].' w sali '.$nauczyciel['Sala_Numer'].'</p>';
        echo '</div>';
    }
?>
    <?php 
    
    if(($this->getOpcje()['dziennr'] > 0 && $this->getOpcje()['dziennr']<= 7) or isset($_SESSION['godzinadane'])){
        ?>
    <div id="nowy_dzien_kontener">
        <?php
        echo '<p>Plan zajęć na dzień ';
        if(!isset($_SESSION['godzinadane'])){
            echo $this->getOpcje()['dziennr'];
        }
        if(isset($_SESSION['godzinadane'])){
            echo dzientygodnia($_SESSION['godzinadane']['Dzien_Tygodnia']).', godzina ' . $_SESSION['godzinadane']['Od'].' - '.$_SESSION['godzinadane']['Do']; 
        }
        echo '</p>'
        ?>
        <form action="<?php echo $this->dolacz; ?><?php echo $this->getOpcje()['formlink']; ?><?php echo $this->getOpcje()['dziennr']; ?>" method="Post">
        <p><div class="nazwa_pola">Nazwa klasy:</div>
            <div class="opcje"><select name="klasa">
                    <option value="null">--</option>
                    <?php
                    foreach ($this->getOpcje()['listaklas'] as $klasadane) {
                        if($_POST['klasa'] == $klasadane['Id_Klasa']){
                            $opcja = 'selected';
                        }
                        else{
                            $opcja = '';
                        }
                        echo '<option value=' . $klasadane['Id_Klasa'] . ' '.$opcja.'>' . $klasadane['Klasa_Nazwa'] . '</option>';
                    }
                    ?>
                </select></div></p>
        <p><div class="nazwa_pola">Godzina zajęć:</div>
            <div class="opcje"><select name="godzinazajec">
                    <option value="null">--</option>
                    <?php
                    foreach ($this->getOpcje()['godzinyzajecia'] as $godzinydane) {
                        if($_POST['godzinazajec'] == $godzinydane['Id_Godzina_Zajec']){
                            $opcja = 'selected';
                        }
                        else{
                            $opcja = '';
                        }
                        echo '<option value=' . $godzinydane['Id_Godzina_Zajec'] . ' '.$opcja.'>' . $godzinydane['Godzina_Przedzial'] . '</option>';
                    }
                    ?>
                </select></div></p>
        <p><div class="nazwa_pola">Przedmiot:</div>
            <div class="opcje"><select name="przedmiot">
                    <option value="null">--</option>
                    <?php
                    foreach ($this->getOpcje()['przedmiotyszkola'] as $przedmiotydane) {
                       if($_POST['przedmiot'] == $przedmiotydane['Id_Przedmiot']){
                            $opcja = 'selected';
                        }
                        else{
                            $opcja = '';
                        }
                        
                        echo '<option value=' . $przedmiotydane['Id_Przedmiot'] . ' '.$opcja.'>' . $przedmiotydane['Przedmiot_Nazwa'] . '</option>';
                    }
                    ?>
                </select></div></p>
        <p><div class="nazwa_pola">Numer sali:</div>
        <div class="opcje">
            <input type="text" name="salanr" value="<?php echo $_POST['salanr']; ?>"/>
        </div></p>
        <input type="submit" name="dodajdzien" value="zapisz"/> <a href="<?php echo $this->dolacz; ?>organizer.html/anulujedycje">anuluj</a>
        <?php
        if(isset($_SESSION['godzinadane'])){
           echo '<a href="'.$this->dolacz.'organizer.html/godzinausun">usuń</a>'; 
        }
        ?>
        </form>
    </div>
<?php
    }
    else{
        echo 'Wybrano nieprawidłowy dzień';
    }
    ?>
</div>
