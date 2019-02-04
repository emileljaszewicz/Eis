<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div class="pasek_informacje">
        <div class="dziel_informacje">Dodawanie wydarzenia dla klasy <b><?php echo $_SESSION['klasadane']['Klasa_Nazwa'] ?></b>
        </div>
        <div class="dziel_informacje">Przedmiot: <?php echo $_SESSION['przedmiot']['Przedmiot_Nazwa'] ?>
        </div>
    </div>
    <div style="margin-top:3vw">
    <form action="<?php echo $this->dolacz.$this->getOpcje()['linkformularz'];?>" method="post">
        
        <div id="formularz_pole">
            <p><h1>Nazwa Wydarzenia :</h1></p>
            <p><input type="text" name="wydarzenie_tytul" value = "<?php echo $_POST['wydarzenie_tytul']; ?>"/></p>
        </div>
        
        <div id="formularz_pole">
            <p><h1>Data wydarzenia :</h1></p>
        <div id="data_formularz">
            <select name="dzien"> 
                    <option value="null">dzień</option>
                    <?php
                   for($i = 1; $i <= date('t'); $i++){
                       if($_POST['dzien'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                    ?>
                </select>
            <select name="miesiac"> 
                    <option value="null">miesiąc</option>
                    <?php
                   for($i = 1; $i <= date('n'); $i++){
                       if($_POST['miesiac'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                   ?>
                </select>
            <select name="rok"> 
                    <option value="null">rok</option>
                    <?php
                   for($i = date('Y'); $i <= date('Y')+1; $i++){
                       if($_POST['rok'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                    ?>
                </select>
        </div>
        </div>
        
        <div id="formularz_pole">
            <p><h1>Treść wydarzenia :</h1></p>
        <p><textarea name="wydarzenie_tresc" /><?php echo $_POST['wydarzenie_tresc']; ?></textarea></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Sala :</h1></p>
            <p><input type="text" name="wydarzenie_sala" value = "<?php echo $_POST['wydarzenie_sala']; ?>"/></p>
        </div>
        <div id="dzienrozklad_opcje" >
        <input type="submit" value="zapisz" name="zapisztermin" /> <a href="<?php echo $this->dolacz.'dziennik.html/terminarz' ?>">anuluj</a>
        
    </div>
    </form>
    </div>
</div>