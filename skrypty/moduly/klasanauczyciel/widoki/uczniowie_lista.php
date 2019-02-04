<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <?php
    
    if(sizeof($this->getOpcje()['listauczniow']) > 0){
    ?>
    
    
    <div id="lista_ocen_kontener" style="width:30%;">
        <p>
        <div class="lista_ocen_osoba belka_kolor">Imię i nazwisko</div>
        </p>
<?php 
foreach($this->getOpcje()['listauczniow'] as $uczen){
   
        echo '<p>
        <div class="lista_ocen_osoba"><a href="'.$this->dolacz.'twoja_klasa.html/uczenszczegoly/'.$uczen['Id_Uczen'].'">'.$uczen['Nazwisko'].' '.$uczen['Imie'].'</a></div>
        
        </p>';
}
echo '<p>
        
        </p>';
        ?>



    </div>
    <a href=" <?php echo $this->dolacz.'dziennik.html/dodajucznia'; ?>">dodaj ucznia</a>
    <?php
    if($this->getOpcje()['promocjeaktywne']['Udzielanie_Promocji'] == 1){
        if($this->getOpcje()['semestrzamkniety']['Koniec_Promocji'] == 0){
    ?>
    <div>
        <form action ="<?php echo $this->dolacz; ?>twoja_klasa.html/uczniowie" method="Post">
        <input type="submit" value="zamknij semestr" name="zamknijsemestr"/>
    </form>
    </div>
    <?php
    }
    else{
        echo '<div>Semestr Zamknięty</div>';
    }
    }
    ?>
    
    <?php
    }
    else{
        echo '<div class="pasek_informacje">
        <div class="dziel_informacje" style="text-align:center;">Brak uczniów <a href="'.$this->dolacz.'dziennik.html/dodajucznia">dodaj ucznia</a></div></div>';
    }
    ?>
</div>
