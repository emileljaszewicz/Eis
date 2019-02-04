<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    
    <form action="<?php echo $this->dolacz;?>wiadomosci.html/nowawiadomosc" method="post">
        <div id="formularz_pole">
            <p><h1>Odbiorca :</h1></p>
            <p><select name="typ_szkoly">
                   
                    <option value="null">--</option>
                    <?php
                    
                     foreach($this->getOpcje()['selectopcje'] as $dane){
                    
                         if(($dane['Id'] != $_SESSION['UserId']) || ($dane['Nazwa_Rangi'] != $_SESSION['Ranga'])){
                        echo '<option value="'.$dane['Id'].'=>'.$dane['Id_Ranga'].'">' .$dane['Nazwa']. ' ('.$dane['Nazwa_Rangi'].')</option>';
                         }
                     }
                    
                    ?>
                </select>
            </p>
        </div>
        <div id="formularz_pole">
            <p><h1>Tytuł wiadomości :</h1></p>
            <p><input type="text" name="wiadomosc_tytul" value = "<?php echo $_POST['wiadomosc_tytul']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Treść wiadomości :</h1></p>
        <p><textarea name="wiadomosc_tresc" /><?php echo $_POST['wiadomosc_tresc']; ?></textarea></p>
        </div>
        
        <input type="submit" value="Wyślij" name="wyslij"/>
    </form>
</div>