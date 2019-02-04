<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl();?>
    <?php
    if(sizeof($this->getOpcje()['dnizajec']) > 0){
    ?>
    <div class="pasek_informacje">
        <div class="dziel_informacje">Lista obecności klasy <?php echo $_SESSION['klasadane']['Klasa_Nazwa']; ?>
        </div>
        <div class="dziel_informacje">Przedmiot <?php echo $_SESSION['przedmiot']['Przedmiot_Nazwa']; ?>
        </div>
        <div id="pozycja">
            <div class="dziel_informacje">Lista z dnia <?php echo date("d.m.Y", strtotime($this->getOpcje()['dzienlista']['Data_Listy']))?></div>
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
        $licz = 0;
    echo '<p>
    <div class="lista_obecnosci_osoba">'.$uczen['Nazwisko'].' '.$uczen['Imie'].'</div>
    <div class="lista_obecnosci_obecnosci">';
    foreach($this->getOpcje()['dnizajec'] as $dzienzajec){
        $dane = null;
        $idnieobecnosc = null;
    foreach($this->getOpcje()['listanieobecnych'] as $nieobecnosc){
        
        if(($nieobecnosc['Id_Lista_Nieobecnosc'] == $dzienzajec['Id_Lista_Nieobecnosc']) && ($uczen['Id_Uczen'] == $nieobecnosc['Id_Uczen'])){
        $uczenid = $uczen['Id_Uczen'];
        $dane =  $nieobecnosc['Id_Lista_Nieobecnosc'];
        $rodzaj = $nieobecnosc['Rodzaj_Nieobecnosci'];
        }
        
        
    }
    if($dzienzajec['Id_Lista_Nieobecnosc'] == $dane){
        switch($rodzaj){
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
        
    }
    else{
        $css = "oznacz_obecny";
        $opcja = "ob";
        
    }
    echo '<div class="inline"><a href="'.$this->dolacz.'dziennik.html/obecnoscedycja/'.$dzienzajec['Id_Lista_Nieobecnosc'].'/'.$uczen['Id_Uczen'].'" class="'.$css.'">'.$opcja.'</a></div>';
    if($licz < sizeof($this->getOpcje()['dnizajec'])-1){
    echo ',';
    }
       $licz++;
    }
    echo '</div>
    </p>';
    }
    ?>
</div>
    <div id="dzienrozklad_opcje" >
        <form action="<?php echo $this->dolacz ?>dziennik.html/wyswietldzienlista/<?php echo $this->getOpcje()['dzienlista']['Id_Lista_Nieobecnosc']?>" method="Post">
        <input type="submit" value="usuń" name="listausun" /> <a href="<?php echo $this->dolacz.'dziennik.html/listyobecnosci' ?>">anuluj</a>
        </form>
    </div>
    <?php
    }
    ?>
</div>
