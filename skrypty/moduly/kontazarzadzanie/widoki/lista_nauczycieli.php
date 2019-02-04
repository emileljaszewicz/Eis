
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div id="szkoly_lista">
        <?php 
        if(sizeof($this->getOpcje()['listanauczycieli']) > 0){
        foreach($this->getOpcje()['listanauczycieli'] as $dane){
            echo '<a href = "'.$this->dolacz.'konta_nauczyciele.html/nauczycielpokaz/'.$dane['Id_Nauczyciel'].'" class="linkszkola">'.$dane['Nazwa'].'</a><br>';
        }
        foreach($this->getOpcje()['linkistron'] as $strony){
            echo '<a href="'.$this->dolacz.'konta_nauczyciele.html/strona/'.$strony.'" class="linkstrona">'.$strony.'</a>';
        }
        }
        else{
            echo 'Brak nauczycieli do wyświetlenia';
        }
        ?>
    </div>
</div>