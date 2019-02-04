<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <form action="<?php echo $this->dolacz.$this->getOpcje()['formlink'];?>" method="post">
        <div id="formularz_pole">
            <p><h1>Rodzaj szkoły :</h1></p>
            <p><select name="typ_szkoly">
                    <option value="null">--</option>
                    <?php
                    
                     foreach($this->getOpcje()['selectopcje'] as $id=>$rodzaj){
                         if($id == $_POST['typ_szkoly']){
                             $opcja = ' selected=selected';
                         }
                         else{
                             $opcja = '';
                         }
                        echo '<option value='.$id.$opcja.'>' .$rodzaj. '</option>';
                     }
                    
                    ?>
                </select>
            </p>
        </div>
        <div id="formularz_pole">
            <p><h1>Nazwa uczelni :</h1></p>
            <p><input type="text" name="nazwa_uczelni" value = "<?php echo $_POST['nazwa_uczelni']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Adres email :</h1></p>
            <p><input type="text" name="adres_email" value = "<?php echo $_POST['adres_email']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Ulica :</h1></p>
            <p><input type="text" name="uczelnia_ulica" value = "<?php echo $_POST['uczelnia_ulica']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Numer budynku :</h1></p>
            <p><input type="text" name="budynek" value = "<?php echo $_POST['budynek']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Kod pocztowy :</h1></p>
            <p><input type="text" name="kod" value = "<?php echo $_POST['kod']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Miejscowość :</h1></p>
            <p><input type="text" name="miejscowosc" value = "<?php echo $_POST['miejscowosc']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Województwo :</h1></p>
            <p><input type="text" name="wojewodztwo" value = "<?php echo $_POST['wojewodztwo']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Numer identyfikacji podatkowej (NIP) :</h1></p>
            <p><input type="text" name="nip" value = "<?php echo $_POST['nip']; ?>"/></p>
        </div>
        <input type="submit" value="Zapisz" name="zapisz"/>
    </form>
</div>