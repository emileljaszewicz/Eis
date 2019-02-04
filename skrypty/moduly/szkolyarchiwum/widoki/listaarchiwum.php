
<div id="szkoly_kontener">
    <div id="szkoly_lista">
        <?php
        if(sizeof($this->getOpcje()['wyswietlszkoly']) > 0){
        foreach($this->getOpcje()['wyswietlszkoly'] as $szkola){
            echo '<a href = "'.$this->dolacz.'listaszkol.html/szkolapokaz/'.$szkola['Id_Szkola'].'" class="linkszkola">'.$szkola['Nazwa_Szkoly'].'</a><br>';
        }
        foreach($this->getOpcje()['linkistron'] as $strony){
            echo '<a href="'.$this->dolacz.'archiwum.html/strona/'.$strony.'" class="linkstrona">'.$strony.'</a>';
        }
        }
        else{
            echo 'Brak zarchiwizowanych szkół.';
        }
                ?>
    </div>
</div>