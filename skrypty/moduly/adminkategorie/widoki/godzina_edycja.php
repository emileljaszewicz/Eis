
<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    <div id="szkoly_lista">
        <form action="<?php echo $this->dolacz;?>kategorie.html/godzinaedycja/<?php echo $this->getOpcje()['godzinaedytuj']['Id_Godzina_Zajec'];?>" method="post">
            <span></span><span>od: <input type="text" name="godzinaod" value="<?php echo $this->getOpcje()['godzinaedytuj']['Od'];?>"> Do: <input type="text" name="godzinado" value="<?php echo $this->getOpcje()['godzinaedytuj']['Do'];?>">
                <input type="submit" value="zapisz" name="zapisz" style="width:4vw; font-size:0.7vw; padding:0.3vw;"/><a href="<?php echo $this->dolacz;?>kategorie.html/zajeciagodziny" class="przycisk_a">anuluj</a></span>
        </form>
    </div>
</div>