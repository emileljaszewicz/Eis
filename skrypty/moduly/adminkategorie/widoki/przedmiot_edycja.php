<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="kategorie_lista">
        <?php
        if(sizeof($this->getOpcje()['przedmiotdane']) > 0){
        echo '<div id="input_kontener">
            <div id="nazwa">Nazwa przedmiotu</div>
            <div id="wprowadzanie">
                <form action="'.$this->dolacz.'kategorie.html/przedmiotedycja/'.$this->getOpcje()['przedmiotdane']['Id_Przedmiot'].'" method="post">
            <input type="text" name="nazwa_przedmiotu" value="'.$this->getOpcje()['przedmiotdane']['Przedmiot_Nazwa'].'"/>
            <input type="submit" value="zapisz" name="zapisz" />
                </form>
            </div>
        </div>';
        }
        else{
            echo 'nie ma takiego przedmiotu';
        }
        ?>
    </div>
</div>