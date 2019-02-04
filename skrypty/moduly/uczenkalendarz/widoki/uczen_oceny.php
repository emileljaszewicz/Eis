<div id="szkoly_kontener">
    
    
    <div class="pasek_informacje">
        <div id="pozycja">
            
            <div class="dziel_informacje">
                <div class="oznacz_obecny inline"><div class="kolor czarny"></div></div> - odpowiedź
                <div class="oznacz_spozniony inline"><div class="kolor zielony"></div></div> - zadanie domowe
                <div class="oznacz_nieobecny inline "><div class="kolor niebieski"></div></div> - kartkówka
                <div class="oznacz_usprawiedliwiony inline"><div class="kolor czerwony"></div></div> - sprawdzian
            </div>
        </div>
    </div>
    <div id="lista_ocen_kontener">
        <p>
        <div class="lista_ocen_osoba belka_kolor">Przedmiot</div>
        <div class="lista_ocen_oceny belka_kolor">Oceny</div>
        <div class="lista_ocen_podsumowanie belka_kolor">Śr.</div>
        <div class="lista_ocen_podsumowanie belka_kolor">O.p.</div>
        <div class="lista_ocen_podsumowanie belka_kolor">O.k.</div>
        </p>
<?php 
foreach($this->getOpcje()['listaprzedmiotow'] as $przedmiot){
    
    $sumujoceny = 0;
        echo '<p>
        <div class="lista_ocen_osoba">'.$przedmiot['Przedmiot_Nazwa'].'</div>
        <div class="lista_ocen_oceny">';
foreach($this->getOpcje()['listaocen'] as $uczenocena){
    if($przedmiot['Id_Przedmiot'] == $uczenocena['Id_Przedmiot']){
        switch($uczenocena['Za_Co']){
            case 1:
                    $dane = 'style="color:black"';
                    break;
                case 2:
                    $dane = 'style="color:green"';
                    break;
                case 3:
                    $dane = 'style="color:blue"';
                    break;
                case 4:
                    $dane = 'style="color:red"';
                    break;
        }
            echo '<div class="inline"><a href="'.$this->dolacz.'wykaz_ocen.html/podgladocena/'.$uczenocena['Id_Ocena_Ucznia'].'" '.$dane.'>'.$uczenocena['Wartosc_Ocena'].'</a></div>';
    
              
    }
}

        echo '</div>
        <div class="lista_ocen_podsumowanie">'.round($this->wolajfunkcja('liczsrednia', "".$_SESSION['UserId'].",".$przedmiot['Id_Przedmiot']."")['Wynik'], 2).'</div>';
            
        echo '<div class="lista_ocen_podsumowanie">'.$this->wolajfunkcja('ocenapropozycja', round($this->wolajfunkcja('liczsrednia', "".$_SESSION['UserId'].",".$przedmiot['Id_Przedmiot']."")['Wynik'], 2)).'</div>
        <div class="lista_ocen_podsumowanie">';
        if($this->wolajfunkcja('ocenakoncowa', "".$_SESSION['UserId'].",".$przedmiot['Id_Przedmiot']."") != null){
           echo $this->wolajfunkcja('ocenakoncowa', "".$_SESSION['UserId'].",".$przedmiot['Id_Przedmiot']."")['Wartosc_Ocena'];
        }
        else{
            echo 'dodaj';
        }
        echo '</div>
        </p>';
}
        ?>



    </div>
    
    <div class="pasek_informacje">
        
        <div id="pozycja">
            
            <div class="dziel_informacje">
                <div class="inline">Śr.</div> - średnia ocen ucznia
                <div class="inline">O.p.</div> - ocena proponowana
                <div class="inline ">O.k.</div> - ocena końcowa
                
            </div>
        </div>
    </div>
    
    
</div>
