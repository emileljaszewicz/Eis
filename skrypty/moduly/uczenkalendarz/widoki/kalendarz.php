<div id="kalendarz_data">
    <form action ="terminy.html" method="Post" >
    <h1>Idź do daty:</h1>
    <select name="miesiac"> 
                    <?php
                    echo $_POST['miesiac'];
                   for($i = 1; $i <= date('n'); $i++){
                       if($_POST['miesiac'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                    ?>
                </select>
    <select name="rok"> 
                    <?php
                   for($i = date('Y'); $i <= date('Y')+1; $i++){
                       if($_POST['rok'] == $i){
                           $opcja = 'selected';
                       }
                       else{
                           $opcja = '';
                       }
                    echo '<option value="'.$i.'" '.$opcja.'>'.$i.'</option>';
                   }
                    ?>
                </select>
    <input type="submit" value="ok" name="idzdata"/>
    </form>
</div>
<?php
$this->wolajfunkcja('kalendarz', "".date('m').",".date('Y')."");

?>