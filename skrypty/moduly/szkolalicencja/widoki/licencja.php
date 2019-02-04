<div id="szkoly_kontener">
    
    <?php echo $this->wyswietl(); ?>
    <?php 
    if(!isset($_POST['zapisz'])){
    if($this->getOpcje()['licencjadane']['Licencja_Status'] == 0){
        echo '<div style="color:red; padding:1vw; border: 1px solid red; width:20%; margin:2vw auto;">aktywuj licencję</div>';
    }
    if($this->getOpcje()['licencjadane']['Wazne_Do'] < date('Y-m-d')){
        echo '<div style="color:red; padding:1vw; border: 1px solid red; width:20%; margin:2vw auto;">Licencja jest nieważna. Wprowadź nowy klucz licencyjny</div>';
    }
    }
    ?>
    <form action="licencja.html" method="post">
        <div id="formularz_pole">
            <p><h1>Wprowadź klucz licencyjny :</h1></p>
            <p><input type="text" name="licencja" value = "<?php echo $_POST['licencja']; ?>"/></p>
        </div>
        
        
        <input type="submit" value="Zapisz" name="zapisz"/>
    </form>
    
</div>