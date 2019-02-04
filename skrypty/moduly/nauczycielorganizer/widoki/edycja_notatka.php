<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div style="margin-top:3vw">
    <form action="<?php echo $this->dolacz.'organizer.html/edytujnotatka/'.$this->getOpcje()['danenotatka']['Id_Notatka'] ?>" method="post">
        
        <div id="formularz_pole">
            <p><h1>Tytuł notatki :</h1></p>
            <p><input type="text" name="tytul" value = "<?php echo $_POST['tytul']; ?>"/></p>
        </div>   
        <div id="formularz_pole">
            <p><h1>Treść notatki :</h1></p>
        <p><textarea name="tresc" /><?php echo $_POST['tresc']; ?></textarea></p>
        </div>
        <div id="dzienrozklad_opcje" >
        <input type="submit" value="zapisz" name="zapisznotatka" /> 
        <a href="<?php echo $this->dolacz.'organizer.html' ?>">anuluj</a>
        <a href="<?php echo $this->dolacz.'organizer.html/notatkausun/'.$this->getOpcje()['danenotatka']['Id_Notatka'] ?>">usuń</a>
    </div>
    </form>
    </div>
</div>