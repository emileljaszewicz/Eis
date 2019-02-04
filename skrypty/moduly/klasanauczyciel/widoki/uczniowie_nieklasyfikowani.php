
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    
    <div id="opislisty">
    Lista osób nieklasyfikowanych: 
    </div>
    <?php
    if($this->getOpcje()['semestrzamkniety']['Koniec_Promocji'] == 0){
    if(sizeof($this->getOpcje()['listauczniow']) > 0){
       ?>
    
    <form action="<?php echo $this->dolacz; ?>twoja_klasa.html/nieklasyfikowani" method="Post">
    <div id="rozklad_dnia_kontener">
        <p>
        <div class="dzienrozklad_komorka" id="belka_kolor">Imię i nazwisko</div>
        <div class="dzienrozklad_komorka" id="belka_kolor">Przyjmij do klasy</div>
        </p>
        <?php
        foreach($this->getOpcje()['listauczniow'] as $daneuczen){
           
        echo '<p>
        <div class="dzienrozklad_komorka obecnosc_komorka" >'.$daneuczen['Nazwisko'].' '.$daneuczen['Imie'].'</div>
        <div class="dzienrozklad_komorka"><a href="'.$this->dolacz.'twoja_klasa.html/uczenprzyjmij/'.$daneuczen['Id_Uczen'].'">przyjmij</a></div>
        </p>';
                }
        ?>
        
    </div>
    <div id="dzienrozklad_opcje" >
        <input type="submit" value="zapisz" name="zapiszlista"/>
    </div>
    </form>
    <?php
    }
    else{
        echo '<div>Brak listy uczniów nieklasyfikowanych</div>';
    }
    }
    
    
    ?>
</div>
