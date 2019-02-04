<?php echo $this->wyswietl(); ?>
<div id="formularz_kontener">
    <div id="formularz_nazwa">Zarejestruj nowe konto</div>
    <div id="formularz_informacje">
        W przypadku rejestracji nowego konta należy podać wszystkie informacje.
        Po rejestracji należy czekać na email zwrotny od administratora.
    </div>
    <form action="rejestracja.html" method="post">
        <div id="formularz_pole">
            <p><h1>Rodzaj szkoły :</h1></p>
            <p><select name="typ_szkoly">
                    <option value="null">--</option>
                    <?php
                    foreach ($this->getWyswietlopcje() as $id => $nazwa) {
                        echo '<option value=' . $id . '>' . $nazwa . '</option>';
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
        <input type="submit" value="Zarejestruj" name="wyslij"/>
    </form>
</div>