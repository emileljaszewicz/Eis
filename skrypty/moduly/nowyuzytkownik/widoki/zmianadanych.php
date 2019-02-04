<div id="szkoly_kontener">
    
    <?php echo $this->wyswietl(); ?>
    <form action="<?php echo $this->dolacz; ?>nowedane.html" method="post">
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
        <input type="submit" value="Zapisz" name="zapisz"/>
    </form>
</div>