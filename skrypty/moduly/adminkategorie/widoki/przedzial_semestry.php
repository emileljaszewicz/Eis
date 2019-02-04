<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu'];?>
    </div>
    <?php echo $this->wyswietl(); ?>
    
    <div style="margin-top:3vw">
    <form action="<?php echo $this->dolacz.'kategorie.html/semestry'?>" method="post">
        
        <div id="formularz_pole">
            <p><h1>Semestr 1:</h1></p>
        <div id="data_formularz">
            <select name="dziensem1od"> 
                    <option value="null">dzień</option>
                    <?php
                    $miesiac = array(1 => "stycznia", 2 => "lutego", 3 => "marca", 4 => "kwietnia", 5 => "maja", 6 => "czerwca", 7 => "lipca", 8 => "sierpnia",
                        9 => "września", 10 => "października", 11 => "listopada", 12 => "grudnia");
                   for($i = 1; $i <= 31; $i++){
                       if($_POST['dziensem1od'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                    ?>
                </select>
            <select name="miesiacsem1od"> 
                    <option value="null">miesiąc</option>
                    <?php
                   for($i = 1; $i <= 12; $i++){
                       if($_POST['miesiacsem1od'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$miesiac[$i].'</option>';
                   }
                   ?>
                </select>
            do 
            <select name="dziensem1do" style="margin-left:1vw"> 
                    <option value="null">dzień</option>
                    <?php
                   for($i = 1; $i <= 31; $i++){
                       if($_POST['dziensem1do'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                    ?>
                </select>
            <select name="miesiacsem1do"> 
                    <option value="null">miesiąc</option>
                    <?php
                   for($i = 1; $i <= 12; $i++){
                       if($_POST['miesiacsem1do'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$miesiac[$i].'</option>';
                   }
                   ?>
                </select>
            
        </div>
        </div>
       <div id="formularz_pole">
            <p><h1>Semestr 2:</h1></p>
        <div id="data_formularz">
            <select name="dziensem2od"> 
                    <option value="null">dzień</option>
                    <?php
                   for($i = 1; $i <= 31; $i++){
                       if($_POST['dziensem2od'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                    ?>
                </select>
            <select name="miesiacsem2od"> 
                    <option value="null">miesiąc</option>
                    <?php
                   for($i = 1; $i <= 12; $i++){
                       if($_POST['miesiacsem2od'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$miesiac[$i].'</option>';
                   }
                   ?>
                </select>
            do 
            <select name="dziensem2do" style="margin-left:1vw"> 
                    <option value="null">dzień</option>
                    <?php
                   for($i = 1; $i <= 31; $i++){
                       if($_POST['dziensem2do'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                    ?>
                </select>
            <select name="miesiacsem2do"> 
                    <option value="null">miesiąc</option>
                    <?php
                   for($i = 1; $i <= 12; $i++){
                       if($_POST['miesiacsem2do'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$miesiac[$i].'</option>';
                   }
                   ?>
                </select>
            
        </div>
        </div>
        <div id="dzienrozklad_opcje" >
        <input type="submit" value="zapisz" name="zapiszsemestr" />
        
    </div>
    </form>
    </div>
</div>