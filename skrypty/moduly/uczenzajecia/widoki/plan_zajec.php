
<div id="szkoly_kontener">
    <?php  echo $this->wyswietl(); ?>
   
    <div id="plan_zajec_kontener" style="width:100%">
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
            echo 'nie można wyświetlić planu zajęć';
        }
    ?>
        
        </p>
        
        <?php
        
        
        if(sizeof($this->getOpcje()['zajeciadnityg']) > 0){
        foreach ($this->getOpcje()['zajeciadnityg'] as $dzientyg){
            
        echo '<p>';
        echo '<div class="plan_zajec_komorka"><h2>
            '.dzientygodnia($dzientyg['Dzien_Tygodnia']).'</h2>
            
        </div> ';
        foreach ($this->getOpcje()['godzinyzajec'] as $godzinazajec){
            
            
            foreach ($this->getOpcje()['przedmioty'] as $przedmiot){
               
            if(($godzinazajec['Id_Godzina_Zajec'] == $przedmiot['Id_Godzina_Zajec']) && ($przedmiot['Dzien_Tygodnia'] == $dzientyg['Dzien_Tygodnia'])){
                $jakiprzedmiot =  $przedmiot['Przedmiot_Nazwa'].'<br>';
                $nauczyciel =  "( ".$przedmiot['Kto']." )";
                
                break;
            }
            else{
                $jakiprzedmiot = null;
                $nauczyciel = null;
            }
            }
            
            
            echo '   
        <div class="plan_zajec_komorka">';
             
            echo $jakiprzedmiot;
            echo $nauczyciel;
            
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
    
</div>
