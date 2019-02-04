
<div id="szkoly_kontener" style="width:50%; margin:2vw auto;border: 1px solid #d3d3d3;padding:0.5vw;">
    
    <?php echo $this->wyswietl(); ?>
    <form action="<?php echo $this->dolacz; ?>logowanie_do_aplikacji.html" method="post">
        <div id="formularz_pole">
            <p><h1>Podaj login :</h1></p>
            <p><input type="text" name="login" value = "<?php echo $_POST['login']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Podaj hasło :</h1></p>
            <p><input type="password" name="haslo" value = "<?php echo $_POST['haslo']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Powtórz hasło :</h1></p>
            <p><input type="password" name="haslopowtorz" value = "<?php echo $_POST['haslopowtorz']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Adres Email :</h1></p>
            <p><input type="text" name="email" value = "<?php echo $_POST['email']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Podaj imie :</h1></p>
            <p><input type="text" name="imie" value = "<?php echo $_POST['imie']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Podaj nazwisko :</h1></p>
            <p><input type="text" name="nazwisko" value = "<?php echo $_POST['nazwisko']; ?>"/></p>
        </div>
        <input type="submit" value="Zapisz" name="zapisz"/>
    </form>
</div>