<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    
    <form action="<?php echo $this->dolacz;?>ogloszenia.html/dodajnowe" method="post">
        <div id="formularz_pole">
            <p><h1>Odbiorcy :</h1></p>
            <p><select name="danewysylka">
                   
                    <option value="null">--</option>
                    <?php
                    
                     foreach($this->getOpcje()['selectopcje'] as $dane){
                         if($_SESSION['Ranga'] == 'Administrator_serwis'){
                    if($dane['Nazwa_Rangi'] == 'Administrator_serwis'){
                        $dane['Id_Rekord'] = '0.1';
                    }
                    if($dane['Nazwa_Rangi'] == 'Szkola'){
                        $dane['Id_Rekord'] = '0';
                    }
                         }
                         
                        echo '<option value="'.$dane['Id_Rekord'].'=>'.$dane['Id_Ranga'].'">' .$dane['Nazwa_Rangi']. '</option>';
                         
                     }
                    
                    ?>
                </select>
            </p>
        </div>
        <div id="formularz_pole">
            <p><h1>Odczyt :</h1></p>
            <p><select name="daneodczyt"> 
                    <option value="1">Nauczyciele i administracja</option>
                    <option value="0">Wszyscy</option>
                </select>
            </p>
        </div>
        
        <div id="formularz_pole">
            <p><h1>Tytuł ogłoszenia :</h1></p>
            <p><input type="text" name="ogloszenie_tytul" value = "<?php echo $_POST['ogloszenie_tytul']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Treść ogłoszenia :</h1></p>
        <p><textarea name="ogloszenie_tresc" /><?php echo $_POST['ogloszenie_tresc']; ?></textarea></p>
        </div>
        
        <input type="submit" value="Wyślij" name="wyslij"/>
    </form>
</div>