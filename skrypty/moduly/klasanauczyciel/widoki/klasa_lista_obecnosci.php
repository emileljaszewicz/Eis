<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl();?>
    <?php
    if(!empty($_SESSION['wychowawca'])){
    ?>
    <div id="nauczyciel_opcje">
        Listy nieobecności klasy: <?php echo $_SESSION['danezalogowany']['Klasa_Nazwa'] ?>. Przedmiot: 
        <form action="<?php echo $this->dolacz; ?>twoja_klasa.html/index" method="Post">
        <select name="przedmiotid">
            <?php
            foreach($this->getOpcje()['przedmiotynauczyciel'] as $listaprzedmiotow){
            if($listaprzedmiotow['Id_Przedmiot'] == $_SESSION['klasaprzedmiot']['Id_Przedmiot']){
                    $opcja = 'selected';
                }
                else{
                    $opcja = '';
                }
            echo '<option value="'.$listaprzedmiotow['Id_Przedmiot'].'" '.$opcja.'>'.$listaprzedmiotow['Przedmiot_Nazwa'].'</option>';
            }
            ?>
        </select>
            <input type="submit" name="sesjaprzedmiot" value="ok" />
        </form>
    </div>
    <?php
    if(isset($_SESSION['klasaprzedmiot'])){
         echo '<div id="nauczyciel_opcje">
        Semestr: 
        <form action="'.$this->dolacz.'twoja_klasa.html/index" method="Post">
        <select name="data">';
            foreach($this->getOpcje()['wyswietlsemestry'] as $semestrdane){
            if($semestrdane['Zakres_Semestr'] == $_SESSION['wychowawcaklasaobecnosc'][0].'/'.$_SESSION['wychowawcaklasaobecnosc'][1]){
                $opcja = 'selected';
            } 
            else{
                $opcja = '';
            }
            echo '<option value="'.$semestrdane['Zakres_Semestr'].'" '.$opcja.'>'.$semestrdane['Przedzial_Semestr'].' '.$semestrdane['Nazwa_Semestr'].'</option>';
            
            }
            
        echo '</select>
            <input type="submit" name="sesjasemestr" value="ok" />
        </form>
    </div>';
    ?>
    <div class="pasek_informacje">
        
        <div id="pozycja">
            <div class="dziel_informacje">
                <div class="oznacz_obecny inline">ob</div> - obecny 
                <div class="oznacz_spozniony inline">s</div> - spóźniony
                <div class="oznacz_nieobecny inline ">nb</div> - nieobecny  
                <div class="oznacz_usprawiedliwiony inline">u</div> - usprawiedliwiony    
            </div>
    </div>
    </div>
<div id="lista_obecnosci_kontener">
    <p>
    <div class="lista_obecnosci_osoba belka_kolor">Imię i nazwisko</div>
    <div class="lista_obecnosci_obecnosci belka_kolor">Frekwencja</div>
    </p>
    <?php
    foreach($this->getOpcje()['listauczniow'] as $uczen){
        
    echo '<p>
    <div class="lista_obecnosci_osoba">'.$uczen['Nazwisko'].' '.$uczen['Imie'].'</div>
    <div class="lista_obecnosci_obecnosci">';
    
        $dane = null;
        $idnieobecnosc = null;
        if(!isset($_SESSION['wychowawcaklasaobecnosc'])){
            echo 'brak obecności bądź nie wybrano żadnego semestru';
        }
    foreach($this->getOpcje()['listanieobecnych'] as $nieobecnosc){
        if($uczen['Id_Uczen'] == $nieobecnosc['Id_Uczen']){
            
        switch($nieobecnosc['Rodzaj_Nieobecnosci']){
            case 0:
                $css = "oznacz_nieobecny";
                $opcja = "nb";
             
                break;
            case 1:
                $css = "oznacz_spozniony";
                $opcja= "s";
                
                break;
            case 2:
                $css = "oznacz_usprawiedliwiony";
                $opcja = "u";
                
                break;
        }
            
       echo '<div class="inline"><a href="'.$this->dolacz.'twoja_klasa.html/obecnoscedycja/'.$nieobecnosc['Id_Nieobecnosc'].'/'.$uczen['Id_Uczen'].'" class="'.$css.'">'.$opcja.'</a></div>';
        }
        
    }
    
    echo '</div>
    </p>';
    }
    ?>
</div>
    <div id="dzienrozklad_opcje" >
        <a href="<?php echo $this->dolacz.'twoja_klasa.html/sesjausun' ?>">wyczyść sesję</a>
    </div>
    <?php
    }
    else{
        echo 'Wybierz przedmiot i wciśnik ok';
    }
    ?>
    <?php
    }
    else{
        echo 'nie jesteś wychowawcą żadnej z klas';
    }
    ?>
</div>
