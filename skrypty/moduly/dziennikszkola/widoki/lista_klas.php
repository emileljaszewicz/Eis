
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div id="szkoly_lista">
        <div id="lista_klas">
           
        <?php 
        
        if(sizeof($this->getOpcje()['wyswietlklasy']) > 0){
            if(isset($_SESSION['klasadane'])){
                echo '<div id="klasa_oznacz">sesja klasy '.$_SESSION['klasadane']['Klasa_Nazwa'].'</div>';
            }
            echo ' <form action="'.$this->dolacz.'dziennik.html" method="Post">';
        foreach($this->getOpcje()['wyswietlklasy'] as $klasadane){
            if($klasadane['Id_Klasa'] == $_SESSION['klasadane']['Id_Klasa']){
                $opcje = 'checked';
            }
            else{
                $opcje = '';
            }
            echo '<div class="linkklasa_kontener"><div class="input_opcje"><input type="radio" '.$opcje.' value="'.$klasadane['Id_Klasa'].'" name="klasa"/></div><div class="link_pozycja">'.$klasadane['Klasa_Nazwa'].' (wych. '.$klasadane['Wychowawca_Klasa'].' )</div></div>';
        }
        echo '<div id="dzienrozklad_opcje" >
        <input type="submit" value="ustaw sesję" name="sesja"/> <a href="'.$this->dolacz.'dziennik.html/anulujsesje">wyczyść sesję</a>
    </div>';
        foreach($this->getOpcje()['linkistron'] as $strony){
            echo '<a href="'.$this->dolacz.'dziennik.html/strona/'.$strony.'" id="dzienrozklad_opcje">'.$strony.'</a>';
        }
        echo '</form>';
        }
        else{
            echo 'Brak klas do wyświetlenia';
        }
        ?>
        </div>
    </div>
</div>