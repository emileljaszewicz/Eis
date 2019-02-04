<?php echo $this->wyswietl(); ?>
<div id="formularz_kontener">
    <div id="formularz_nazwa"> Zaloguj się do systemu</div>
    <form action="<?php echo $this->dolacz; ?>logowanie.html/wyslijdane" method="post">
        <div id="formularz_pole">
            <p><h1>Podaj login :</h1></p>
            <p><input type="text" name="login" /></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Podaj hasło :</h1></p>
            <p><input type="password" name="haslo" /></p>
        </div>
        <input type="submit" value="Zaloguj" name="wyslij"/>
        <div id="formularz_odnosniki">
            <a href="potwierdz_dane.html">Nowy użytkownik</a>
            <a href="rejestracja.html">Zarejestruj nowe konto</a>
        </div>
    </form>
</div>