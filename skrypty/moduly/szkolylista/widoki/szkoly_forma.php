
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <div id="szkoly_lista">
        <?php 
        if(sizeof($this->getOpcje()['listaszkol']) > 0){
        foreach($this->getOpcje()['listaszkol'] as $id=>$szkola){
            echo '<a href = "'.$this->dolacz.'listaszkol.html/szkolapokaz/'.$id.'" class="linkszkola">'.$szkola.'</a><br>';
        }
        foreach($this->getOpcje()['linkistron'] as $strony){
            echo '<a href="'.$this->dolacz.'listaszkol.html/strona/'.$strony.'" class="linkstrona">'.$strony.'</a>';
        }
        }
        else{
            echo 'Brak szkół do wyświetlenia';
        }
        ?>
    </div>
</div>