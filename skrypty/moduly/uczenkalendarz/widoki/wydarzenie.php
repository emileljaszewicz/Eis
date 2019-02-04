<div id="szkoly_kontener">
    <?php
      if(sizeof($this->getOpcje()['danewydarzenie']) > 0){
          ?>
  <div class="pasek_informacje">
        <div class="dziel_informacje">Szczegóły wydarzenia
        </div>
        <div class="dziel_informacje">Data: 
            <?php echo $this->getOpcje()['danewydarzenie'][0]['Data_Wydarzenia']; ?>
        </div>
    </div>  
    
    <div class="wydarzenie_kontener">
        <p>
        <div class="komorka belka_kolor" style="width:30%">Nazwa wydarzenia</div>
        <div class="komorka belka_kolor" style="width:25%">Treść wydarzenia</div>
        <div class="komorka belka_kolor"style="width:20%">Przedmiot</div>
        <div class="komorka belka_kolor" style="width:15%">Nauczyciel</div>
        <div class="komorka belka_kolor" style="width:10%">Sala</div>
        </p>
        
    </div>
    <?php foreach($this->getOpcje()['danewydarzenie'] as $wydarzenie){
    echo '<div class="wydarzenie_kontener">
        <p>
        <div class="komorka" style="width:30%">'.$wydarzenie['Wydarzenie_Nazwa'].'</div>
        <div class="komorka" style="width:25%">'.$wydarzenie['Wydarzenie_Tresc'].'</div>
        <div class="komorka"style="width:20%">'.$wydarzenie['Przedmiot_Nazwa'].'</div>
        <div class="komorka" style="width:15%">'.$wydarzenie['Imie'].' '.$wydarzenie['Nazwisko'].'</div>
            <div class="komorka" style="width:10%">'.$wydarzenie['Sala'].'</div>
        </p>
        
    </div>';
    }
    ?>
    <?php
      }
      else{
          echo 'brak wydarzeń na ten dzień';
      }
    ?>
    <div id="nowy_dzien_kontener" style="margin-top:0vw"> 
                <a href="<?php echo $this->dolacz . 'terminy.html' ?>" style="margin-top:0vw;">anuluj</a>
            </div>
    
</div>
