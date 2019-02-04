
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div id="rozklad_dnia_kontener">
        <p>
        <div class="dzienrozklad_komorka" id="belka_kolor" style="width:60%">Imię i nazwisko</div>
        <div class="dzienrozklad_komorka" id="belka_kolor" style="width:10%">sala</div>
        <div class="dzienrozklad_komorka" id="belka_kolor" style="width:20%">wychowawca klasy</div>
        </p>
        <?php
        foreach($this->getOpcje()['nauczyciele'] as $nauczyciel){
        echo '<p>
        <div class="dzienrozklad_komorka" id="belka_kolor" style="width:60%">'.$nauczyciel['Nazwisko'].' '.$nauczyciel['Imie'].'</div>
        <div class="dzienrozklad_komorka" id="belka_kolor" style="width:10%">'.$nauczyciel['Sala_Uczy'].'</div>
        <div class="dzienrozklad_komorka" id="belka_kolor" style="width:20%">'.$nauczyciel['Klasa_Nazwa'].'</div>
        </p>';
        }
        ?>
    </div>
        
        
    
</div>