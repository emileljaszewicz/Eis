
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <?php
    if(isset($_SESSION['przedmiot'])){
        ?>
    <div id="opislisty">
    Lista obecności klasy: <?php echo $_SESSION['klasadane']['Klasa_Nazwa']; ?>. Przedmiot:
    <?php echo $_SESSION['przedmiot']['Przedmiot_Nazwa']; ?>
    </div>
    <?php
    if(sizeof($this->getOpcje()['listauczniow']) > 0){
       ?>
    <div id="lista_szczegoly">
    <?php echo '<p>Nowa lista obecności ('.date('d.m.Y').')';
    ?>
    </div>
    <form action="<?php echo $this->dolacz; ?>dziennik.html/dodajliste" method="Post">
    <div id="rozklad_dnia_kontener">
        <p>
        <div class="dzienrozklad_komorka" id="belka_kolor">Imię i nazwisko</div>
        <div class="dzienrozklad_komorka" id="belka_kolor">Nieobecność</div>
        </p>
        <?php
        foreach($this->getOpcje()['listauczniow'] as $daneuczen){
           
        echo '<p>
        <div class="dzienrozklad_komorka obecnosc_komorka" ><a href="#">'.$daneuczen['Nazwisko'].' '.$daneuczen['Imie'].'</a></div>
        <div class="dzienrozklad_komorka"><input type="checkbox" value="'.$daneuczen['Id_Uczen'].'" name="osoba[]"/></div>
        </p>';
                }
        ?>
        
    </div>
    <div id="dzienrozklad_opcje" >
        <input type="submit" value="zapisz" name="zapiszlista"/> <a href="<?php echo $this->dolacz; ?>dziennik.html/listyobecnosci">anuluj</a>
    </div>
    </form>
    <?php
    }
    else{
        echo '<div>Brak przypisanych uczniów do tej klasy</div>';
    }
    }
    else{
        echo '<div id="lista_szczegoly">Najpierw wybierz przedmiot</div>';
    }
    ?>
</div>
