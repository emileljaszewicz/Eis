<?php 
        $dane = $this->getOpcje()['listaszkol'];
        ?>
<div id="szkoly_kontener">
    <div id="podmenu">
       <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div id="szkola_dane_kontener">
        <div class="dane_sekcja">
            <div class="dane_tresc" id="szkola_kontener_opis">
                Szczegóły rejestracji
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Data rejestracji:</div>
            <div class="dane_tresc">
                <?php echo $dane['Data_Rejestracji']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Data aktywacji:</div>
            <div class="dane_tresc">
                <?php echo $dane['Wazne_Od']; ?>
        </div> 
    </div>
    <div class="dane_sekcja">
            <div class="dane_opis">Nazwa uczelni:</div>
            <div class="dane_tresc">
                <?php echo $dane['Nazwa_Szkoly']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Typ uczelni:</div>
            <div class="dane_tresc">
                <?php echo $dane['Rodzaj_Szkoly']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Ulica:</div>
            <div class="dane_tresc">
                <?php echo $dane['Ulica']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Numer budynku:</div>
            <div class="dane_tresc">
                <?php echo $dane['Budynek_Numer']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Miejscowość:</div>
            <div class="dane_tresc">
                <?php echo $dane['Miejscowosc']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Województwo:</div>
            <div class="dane_tresc">
                <?php echo $dane['Wojewodztwo']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Numer identyfikacji podatkowej(Nip):</div>
            <div class="dane_tresc">
                <?php echo $dane['Numer_Identyfikacji_podatkowej']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Status:</div>
            <div class="dane_tresc">
                <?php echo ($dane['Status'] == 1) ? 'aktywna' : 'nieaktywna'; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Klucz licencyjny:</div>
            <div class="dane_tresc">
                <?php 
                    echo $dane['Licencja_Klucz'];            
                ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Termin upływu licencji:</div>
            <div class="dane_tresc">
                <?php echo $dane['Wazne_Do']; 
                
                if($dane['Wazne_Do'] != null){
                echo " / ";
                if($this->getOpcje()['licencjadlugosc'] > 0){
                echo "Pozostało ".$this->getOpcje()['licencjadlugosc']." dni";
                }
                else{
                    echo 'termin licencji upłynął';
                }
                if($this->getOpcje()['licencjadlugosc'] <= 5 or $this->getOpcje()['licencjadlugosc'] <= 0){
                        echo '<a href="'.$this->dolacz.'listaszkol.html/kluczreset/'.$dane['Id_Szkola'].'" id="resetuj">Odnów licencję</a>';
                }
                
                
                }
                ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Adres email:</div>
            <div class="dane_tresc">
                <?php echo $dane['Email']; ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_opis">Hasło:</div>
            <div class="dane_tresc">
                <?php 
                if(strlen($dane['Login']) == 0){
                echo $dane['Haslo']; 
                }
                ?>
                <?php 
                echo '<a href="'.$this->dolacz.'listaszkol.html/hasloreset/'.$dane['Id_Szkola'].'">resetuj hasło</a>';
                ?>
        </div> 
    </div>
        <div class="dane_sekcja">
            <div class="dane_tresc">
                <?php if($dane['Status'] == 0 or $dane['Status'] == 2){
                echo '<a href="'.$this->dolacz.'listaszkol.html/szkolaakceptuj/'.$dane['Id_Szkola'].'">aktywuj</a>';
                }
                if($dane['Status'] == 3){
                echo '<a href="'.$this->dolacz.'listaszkol.html/szkoladezaktywuj/'.$dane['Id_Szkola'].'">rejestruj</a>';
                }
                if($dane['Status'] == 1){
                echo '<a href="'.$this->dolacz.'listaszkol.html/szkolaarchiwum/'.$dane['Id_Szkola'].'">archiwizuj</a>';
                }?>
                <a href="<?php echo $this->dolacz;?>listaszkol.html/szkolaedytuj/<?php echo $dane['Id_Szkola']?>">edytuj</a>
                <a href="<?php echo $this->dolacz;?>listaszkol.html/szkolausun/<?php echo $dane['Id_Szkola']?>">usuń</a>
                <a href="<?php echo $this->dolacz;?>listaszkol.html">anuluj</a>
        </div> 
    </div>
</div>