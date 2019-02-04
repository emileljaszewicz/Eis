<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="kategorie_lista">
        <div id="input_kontener2">
            <div id="nazwa">Nazwa oceny</div>
            <div id="wprowadzanie">
                <form action="<?php echo $this->dolacz.'kategorie.html/ocenaedycja/'.$this->getOpcje()['daneocena']['Id_Ocena'];?>" method="post">
            <input type="text" name="nazwa_oceny" value="<?php echo $this->getOpcje()['daneocena']['Ocena_Nazwa'] ?>"/>
            <select name="ocenaid">
                <option value="Null">wybierz ocenę</option>
                <?php
                $dane = array(1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6);
                
                foreach($dane as $ocena){
                    if($ocena == $this->getOpcje()['daneocena']['Wartosc_Ocena']){
                        $opcja = 'selected';
                    }
                    else{
                        $opcja = '';
                    }
                    echo '<option value="'.$ocena.'" '.$opcja.'>'.$ocena.'</option>';
                }
                ?>
            </select>
            <input type="submit" value="zapisz" name="zapisz" />
                </form>
            </div>
        </div>
        
    </div>
</div>