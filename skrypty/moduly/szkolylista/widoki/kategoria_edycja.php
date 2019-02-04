<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="kategorie_lista">
        <?php
        
        if (sizeof($this->getOpcje()['kategoriaedycja']) > 0) {
            echo '
            <div id="input_kontener">
            <div id="nazwa">Nazwa kategorii</div>
            <div id="wprowadzanie">
                <form action="'.$this->dolacz.'listaszkol.html/kategoriaupdate/'.$this->getOpcje()['kategoriaedycja']['Id_Kategoria_Szkoly'].'" method="post">
            <input type="text" name="nazwa_kategorii" value="'.$this->getOpcje()['kategoriaedycja']['Rodzaj_Szkoly'].'"/>
            <input type="submit" value="zapisz" name="zapisz" />
                </form>
            </div>
        </div>';
            
        } else {
            echo 'Brak kategorii do wyświetlenia';
        }
        ?>
        
    </div>
</div>