<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <?php
    
    if(isset($_SESSION['przedmiot'])){
    ?>
    <div class="pasek_informacje">
        <div class="dziel_informacje">Wykaz ocen klasy <?php echo $_SESSION['klasadane']['Klasa_Nazwa']; ?>
        </div>
        <div class="dziel_informacje">Przedmiot <?php echo $_SESSION['przedmiot']['Przedmiot_Nazwa']; ?>
        </div>
        <?php 
        echo '<div id="nauczyciel_opcje">
        Semestr: 
        <form action="'.$this->dolacz.'dziennik.html/listaocen" method="Post">
        <select name="data">';
            foreach($this->getOpcje()['wyswietlsemestry'] as $semestrdane){
            if($semestrdane['Zakres_Semestr'] == $_SESSION['przedzialoceny'][0].'/'.$_SESSION['przedzialoceny'][1]){
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
        <div class="lista_ocen_osoba belka_kolor">Imię i nazwisko</div>
        <div class="lista_ocen_oceny belka_kolor">Oceny</div>
        <div class="lista_ocen_podsumowanie belka_kolor">Śr.</div>
        <div class="lista_ocen_podsumowanie belka_kolor">O.p.</div>
        <div class="lista_ocen_podsumowanie belka_kolor">O.k.</div>
        </p>
<?php 
foreach($this->getOpcje()['listauczniow'] as $uczen){
    
    $sumujoceny = 0;
        echo '<p>
        <div class="lista_ocen_osoba">'.$uczen['Nazwisko'].' '.$uczen['Imie'].'</div>
        <div class="lista_ocen_oceny">';
        if(isset($_SESSION['przedzialoceny'])){
foreach($this->getOpcje()['ocenyucznia'] as $uczenocena){
    if($uczenocena['Id_Uczen'] == $uczen['Id_Uczen']){
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
            echo '<div class="inline"><a href="'.$this->dolacz.'dziennik.html/edytujocene/'.$uczen['Id_Uczen'].'/'.$uczenocena['Id_Ocena_Ucznia'].'" '.$dane.'>'.$uczenocena['Wartosc_Ocena'].'</a></div>';
    
              
    }
}
}
else{
    echo 'brak ocen lub nie wybrano semestru';
}
            echo '<div class="inline"><a href="'.$this->dolacz.'dziennik.html/dodajocene/'.$uczen['Id_Uczen'].'" style="color:#096fec">dodaj</a></div>

        </div>
        <div class="lista_ocen_podsumowanie">'.round($this->wolajfunkcja('liczsrednia', $uczen['Id_Uczen'])['Wynik'], 2).'</div>';
            
        echo '<div class="lista_ocen_podsumowanie">'.$this->wolajfunkcja('ocenapropozycja', round($this->wolajfunkcja('liczsrednia', $uczen['Id_Uczen'])['Wynik'], 2)).'</div>
        <div class="lista_ocen_podsumowanie"><a href="'.$this->dolacz.'dziennik.html/ocenakoncowa/'.$uczen['Id_Uczen'].'">';
        if($this->wolajfunkcja('ocenakoncowa', $uczen['Id_Uczen']) != null){
           echo $this->wolajfunkcja('ocenakoncowa', $uczen['Id_Uczen'])['Wartosc_Ocena'];
        }
        else{
            echo 'dodaj';
        }
        echo '</a></div>
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
    
    <div id="nauczyciel_opcje">
        Typ średniej: 
        <form action="<?php echo $this->dolacz; ?>dziennik.html/listaocen" method="Post">
        <select name="sredniarodzaj">
            <?php 
            $tablica = array(1=>"Arytmetyczna", 2=>"Ważona");
            foreach($tablica as $id=>$wartosc){
                if($id == $this->getOpcje()['sredniarodzaj']['Wartosc']){
                    $zaznacz = 'selected';
                }
                else{
                    $zaznacz = '';
                }
                echo '<option value="'.$id.'" '.$zaznacz.'>'.$wartosc.'</option>';
            }
            ?>
        </select>
            <input type="submit" name="zapiszsrednia" value="ok" />
        </form>
    </div>
    
    <?php
    }
    else{
        echo '<div class="pasek_informacje">
        <div class="dziel_informacje" style="text-align:center;">Najpierw wybierz przedmiot</div></div>';
    }
    ?>
</div>
