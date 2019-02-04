
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php  echo $this->wyswietl(); ?>
   
    <div id="plan_zajec_kontener">
        <p>
        <div class="plan_zajec_komorka">
            Godzina zajęć
        </div> 
        <?php
        if(sizeof($this->getOpcje()['godzinyzajec']) > 0){
    foreach ($this->getOpcje()['godzinyzajec'] as $godzinazajec){
        
        echo "<div class='plan_zajec_komorka'><h2>".$godzinazajec['Od']." - ".$godzinazajec['Do']."</h2></div> ";
        
    }
        } 
        else{
            echo 'nie można dodać planu zajęć';
        }
    ?>
        
        </p>
        
        <?php
        
        
        if(sizeof($this->getOpcje()['zajeciadnityg']) > 0){
        foreach ($this->getOpcje()['zajeciadnityg'] as $dzientyg){
            
        echo '<p>';
        echo '<div class="plan_zajec_komorka"><h2>
            <a href="'.$this->dolacz.'organizer.html/edytujdzien/'.$dzientyg['Dzien_Tygodnia'].'">'.dzientygodnia($dzientyg['Dzien_Tygodnia']).'</a></h2>
            
        </div> ';
        foreach ($this->getOpcje()['godzinyzajec'] as $godzinazajec){
            
            
            foreach ($this->getOpcje()['przedmioty'] as $przedmiot){
               
            if(($godzinazajec['Id_Godzina_Zajec'] == $przedmiot['Id_Godzina_Zajec']) && ($przedmiot['Dzien_Tygodnia'] == $dzientyg['Dzien_Tygodnia'])){
                $jakiprzedmiot =  $przedmiot['Przedmiot_Nazwa'];
                
                break;
            }
            else{
                $jakiprzedmiot = null;
                
            }
            }
            
            
            echo '   
        <div class="plan_zajec_komorka">';
             
            echo $jakiprzedmiot;
            
        echo '</div> 
            
        ';
        }
        echo '</p>';
        echo '<p>';
        echo '<div class="plan_zajec_komorka">
                </div>';
        foreach ($this->getOpcje()['godzinyzajec'] as $godzinazajec){
            foreach ($this->getOpcje()['przedmioty'] as $przedmiot){
               
            if(($godzinazajec['Id_Godzina_Zajec'] == $przedmiot['Id_Godzina_Zajec']) && ($przedmiot['Dzien_Tygodnia'] == $dzientyg['Dzien_Tygodnia'])){
                
                $jakaklasa = $przedmiot['Klasa_Nazwa'];
                
                break;
            }
            else{
                
                $jakaklasa = null;
            }
            }
            
            
        echo '<div class="plan_zajec_komorka">'.$jakaklasa.'</div>';
            
        }
        echo '</p>';
        echo '<p>';
        echo '<div class="plan_zajec_komorka">
                </div>';
        foreach ($this->getOpcje()['godzinyzajec'] as $godzinazajec){
            foreach ($this->getOpcje()['przedmioty'] as $przedmiot){
               
            if(($godzinazajec['Id_Godzina_Zajec'] == $przedmiot['Id_Godzina_Zajec']) && ($przedmiot['Dzien_Tygodnia'] == $dzientyg['Dzien_Tygodnia'])){
                
                $sala = $przedmiot['Sala_Numer'];
                
                break;
            }
            else{
                
                $sala = null;
            }
            }
            
            
        echo '<div class="plan_zajec_komorka">'.$sala.'</div>';
            
        }
        echo '</p>';
        }
        }
        
        ?>
        
    </div>
    <?php
    if(sizeof($this->getOpcje()['zajeciadnityg']) == 0){
    echo 'Brak planu zajęć';
    }
        ?>
    <div id="nauczyciel_opcje">
        Dodaj plan zajęć na: 
        <form action="<?php echo $this->dolacz; ?>organizer.html/nauczycielzajecia" method="Post">
        <select name="dzientyg">
            <option value="1">Poniedziałek</option>
            <option value="2">Wtorek</option>
            <option value="3">Środa</option>
            <option value="4">Czwartek</option>
            <option value="5">Piątek</option>
            <option value="6">Sobota</option>
            <option value="7">Niedziela</option>
            <input type="submit" name="dodajdzien" value="dodaj" />
        </select>
        </form>
    </div>
</div>
