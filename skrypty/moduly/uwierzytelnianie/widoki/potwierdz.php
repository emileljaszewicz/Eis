<?php echo $this->wyswietl(); ?>
<div id="formularz_kontener">
    <div id="formularz_nazwa"> Zaloguj się do systemu</div>
    <div id="formularz_informacje">
        W formularzu podaj identyfikator, który otrzymałeś od administratora.
    </div>
    <form action="<?php echo $this->dolacz; ?>potwierdz_dane.html" method="post">
    <div id="formularz_pole">
        <p><h1>Podaj Identyfikator :</h1></p>
        <p><input type="text" name="login" /></p>
    </div>
    <input type="submit" name ="logowanie" value="Zaloguj" />
    </form>
</div>