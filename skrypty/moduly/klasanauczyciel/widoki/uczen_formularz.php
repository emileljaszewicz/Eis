<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <form action="<?php echo $this->dolacz.'twoja_klasa.html/uczenedycja/'.$this->getOpcje()['linkid']['Id_Uczen'];?>" method="post">
        <div id="formularz_pole">
            <p><h1>Imię :</h1></p>
            <p><input type="text" name="imie" value = "<?php echo $_POST['imie']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Nazwisko :</h1></p>
            <p><input type="text" name="nazwisko" value = "<?php echo $_POST['nazwisko']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Adres email :</h1></p>
            <p><input type="text" name="email" value = "<?php echo $_POST['email']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Ulica :</h1></p>
            <p><input type="text" name="ulica" value = "<?php echo $_POST['ulica']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Numer budynku :</h1></p>
            <p><input type="text" name="budynek" value = "<?php echo $_POST['budynek']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Numer mieszkania :</h1></p>
            <p><input type="text" name="mieszkanie" value = "<?php echo $_POST['mieszkanie']; ?>"/></p>
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
            <p><h1>Numer pesel :</h1></p>
            <p><input type="text" name="pesel" value = "<?php echo $_POST['pesel']; ?>"/></p>
        </div>
        
        <input type="submit" value="Zapisz" name="zapisz"/>
    </form>
</div>