<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <form action="<?php echo $this->dolacz.$this->getOpcje()['formlink'];?>" method="post">
        <div id="formularz_pole">
            <p><h1>Imię :</h1></p>
            <p><input type="text" name="imie" value = "<?php echo $_POST['imie']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Nazwisko :</h1></p>
            <p><input type="text" name="nazwisko" value = "<?php echo $_POST['nazwisko']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Ulica :</h1></p>
            <p><input type="text" name="ulica" value = "<?php echo $_POST['ulica']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Numer budynku :</h1></p>
            <p><input type="text" name="budynek" value = "<?php echo $_POST['budynek']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Numer mieszkania :</h1></p>
            <p><input type="text" name="mieszkanie" value = "<?php echo $_POST['mieszkanie']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Kod pocztowy :</h1></p>
            <p><input type="text" name="kod" value = "<?php echo $_POST['kod']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Miejscowość :</h1></p>
            <p><input type="text" name="miejscowosc" value = "<?php echo $_POST['miejscowosc']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Województwo :</h1></p>
            <p><input type="text" name="wojewodztwo" value = "<?php echo $_POST['wojewodztwo']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Numer pesel :</h1></p>
            <p><input type="text" name="pesel" value = "<?php echo $_POST['pesel']; ?>"/></p>
        </div>
        <div id="formularz_pole">
            <p><h1>Uczy w sali :</h1></p>
            <p><input type="text" name="salanr" value = "<?php echo $_POST['salanr']; ?>"/></p>
        </div>
        
        <?php
        if(isset($this->getOpcje()['dane'])){
           ?>
        <div id="formularz_pole">
            <p><h1>Przedmioty :</h1></p>
        <p>
            <div id="checkbox_kontener">
                
                    <?php
                    
                    for($i = 0; $i < sizeof($this->getOpcje()['listaprzedmiotow']); $i++){
                        if($i%4 == 0){
                            echo '<div class="dzielcheckbox">';
                            for($y = $i; $y < $i+4; $y++){
                                $opcja = null;
                                for($z = 0; $z < sizeof($this->getOpcje()['nauczycielprzedmioty']); $z++){
                                    if(!empty($this->getOpcje()['listaprzedmiotow'][$y])){
                                    if($this->getOpcje()['listaprzedmiotow'][$y]['Id_Przedmiot'] == $this->getOpcje()['nauczycielprzedmioty'][$z]['przedmioty_Id_Przedmiot']){
                                        $opcja = $this->getOpcje()['nauczycielprzedmioty'][$z]['przedmioty_Id_Przedmiot'];
                                    }
                                    } 
                                }
                                if(!empty($this->getOpcje()['listaprzedmiotow'][$y])){
                                if($this->getOpcje()['listaprzedmiotow'][$y]['Id_Przedmiot'] == $opcja){
                                    $checked = "checked";
                                }
                                else{
                                    $checked = '';
                                }
                                }
                                if(!empty($this->getOpcje()['listaprzedmiotow'][$y])){
                                echo '<div class="pole_checkbox">
                    <div class="input"><input type="checkbox" name="przedmiotnr[]" value="'.$this->getOpcje()['listaprzedmiotow'][$y]['Id_Przedmiot'].'" '.$checked.'/></div><div class="nazwa_checkbox">'.$this->getOpcje()['listaprzedmiotow'][$y]['Przedmiot_Nazwa'].'</div>
                        <div id="wyrownaj"></div>
                </div> ';
                                }
                            }
                            echo '</div>';
                        }
                    }
                    
                        ?>
                
            </div>
        </p>
        </div>
    <?php
        }
        ?>
        <input type="submit" value="Zapisz" name="zapisz"/>
    </form>
</div>