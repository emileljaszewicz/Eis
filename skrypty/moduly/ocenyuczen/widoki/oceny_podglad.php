<div id="szkoly_kontener">
  <div class="pasek_informacje">
        <div class="dziel_informacje">Szczegóły oceny ucznia
        </div>
      <?php
      if(is_array($this->getOpcje()['ocenaszczegoly'])){
          ?>
        <div class="dziel_informacje">Przedmiot: 
            <?php echo $this->getOpcje()['ocenaszczegoly']['Przedmiot_Nazwa'] ?>
        </div>
    </div>  
    
    <div id="lista_ocen_kontener">
        <p>
        <div class="lista_ocen_osoba belka_kolor">Ocena</div>
        <div class="lista_ocen_oceny"><?php echo $this->getOpcje()['ocenaszczegoly']['Wartosc_Ocena'] ?></div>
        </p>
        <p>
        <div class="lista_ocen_osoba belka_kolor">Za co</div>
        <div class="lista_ocen_oceny"><?php 
                switch($this->getOpcje()['ocenaszczegoly']['Za_Co']){
            case 1:
                    $dane = 'odpowiedź';
                    break;
                case 2:
                    $dane = 'zadanie domowe';
                    break;
                case 3:
                    $dane = 'kartkówka';
                    break;
                case 4:
                    $dane = 'sprawdzian';
                    break;
            default:
                $dane = null;
                    break;
        }
                echo $dane; ?></div>
        </p>
        <p>
        <div class="lista_ocen_osoba belka_kolor">Data wystawienia</div>
        <div class="lista_ocen_oceny"><?php echo $this->getOpcje()['ocenaszczegoly']['Data_Wystawienia'] ?></div>
        </p>
        <p>
        <div class="lista_ocen_osoba belka_kolor">Nauczyciel</div>
        <div class="lista_ocen_oceny"><?php echo $this->getOpcje()['ocenaszczegoly']['Kto'] ?></div>
        </p>
        <p>
        <div class="lista_ocen_osoba belka_kolor">Przedmiot</div>
        <div class="lista_ocen_oceny"><?php echo $this->getOpcje()['ocenaszczegoly']['Przedmiot_Nazwa'] ?></div>
        </p>
        <p>
        <div class="lista_ocen_osoba belka_kolor">Waga</div>
        <div class="lista_ocen_oceny"><?php echo $this->getOpcje()['ocenaszczegoly']['Ocena_Waga'] ?></div>
        </p>
        <p>
        <div class="lista_ocen_osoba belka_kolor">Komentarz</div>
        <div class="lista_ocen_oceny"><?php echo $this->getOpcje()['ocenaszczegoly']['Ocena_Opis'] ?></div>
        </p>


    </div>
    <?php
      }
    ?>
    <div id="nowy_dzien_kontener" style="margin-top:0vw"> 
                <a href="<?php echo $this->dolacz . 'wykaz_ocen.html' ?>" style="margin-top:0vw;">anuluj</a>
            </div>
    
</div>
