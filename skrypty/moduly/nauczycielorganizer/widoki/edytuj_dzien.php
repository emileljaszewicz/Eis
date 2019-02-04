
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php
    if(sizeof($this->getOpcje()['listazajec']) > 0){
        ?>
    
    Plan zajęć na: <?php echo dzientygodnia($this->getOpcje()['dziennr'])?>
    <form action="<?php echo $this->dolacz; ?>organizer.html/edytujdzien/<?php echo $this->getOpcje()['dziennr'];?>" method="Post">
    <div id="rozklad_dnia_kontener">
        <p>
        <div class="dzienrozklad_komorka" id="belka_kolor">Godzina zajęć</div>
        <div class="dzienrozklad_komorka" id="belka_kolor">Przedmiot</div>
        <div class="dzienrozklad_komorka" id="belka_kolor">Sala</div>
        <div class="dzienrozklad_komorka" id="belka_kolor">Klasa</div>
        <div class="dzienrozklad_komorka" id="belka_kolor"></div>
        </p>
        <?php
        foreach($this->getOpcje()['listazajec'] as $godzinazajec){
           
        echo '<p>
        <div class="dzienrozklad_komorka">'.$godzinazajec['Od'].' - '.$godzinazajec['Do'].'</div>
        <div class="dzienrozklad_komorka">'.$godzinazajec['Przedmiot_Nazwa'].'</div>
        <div class="dzienrozklad_komorka">'.$godzinazajec['Sala_Numer'].'</div>
        <div class="dzienrozklad_komorka">'.$godzinazajec['Klasa_Nazwa'].'</div>
        <div class="dzienrozklad_komorka"><input type="radio" value="'.$godzinazajec['Id_Godzina_Zajec'].'" name="godzinanr"/></div>
        </p>';
                }
        ?>
        
    </div>
    <div id="dzienrozklad_opcje" >
        <input type="submit" value="edytuj" name="godzinaedycja"/> <a href="<?php echo $this->dolacz.'organizer.html/dodajdzien/'.$this->getOpcje()['dziennr'];?>">dodaj</a> <a href="<?php echo $this->dolacz; ?>organizer.html/nauczycielzajecia">anuluj</a>
    </div>
    </form>
    <?php
    }
    else{
        echo 'nie ma takiego dnia';
    }
    ?>
</div>
