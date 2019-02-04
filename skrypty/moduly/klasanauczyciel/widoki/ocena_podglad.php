

<div id="szkoly_kontener">
    <div id="podmenu">
        <?php echo $this->getOpcje()['podmenu']; ?>
    </div>
    <div class="pasek_informacje">
        <div class="dziel_informacje">Szczegóły oceny ucznia <b><?php echo $this->getOpcje()['uczenocena']['Imie'] . ' ' . $this->getOpcje()['uczenocena']['Nazwisko'] ?></b>
        </div>
        <div class="dziel_informacje">Przedmiot: <?php echo $_SESSION['klasaprzedmiot']['Przedmiot_Nazwa'] ?>
        </div>
    </div>
    <div id="lista_ocen_kontener" style="margin-top:2vw;">
        <p>
        <div class="lista_ocen_podsumowanie belka_kolor">Ocena</div>
        <div class="lista_ocen_podsumowanie belka_kolor">Za co</div>
        <div class="lista_ocen_podsumowanie belka_kolor">Rodzaj oceny</div>
        <div class="lista_ocen_podsumowanie belka_kolor">Waga</div>
        <div class="lista_ocen_podsumowanie belka_kolor">Komentarz</div>
        </p>
        <p>
        <div class="lista_ocen_podsumowanie">
            <?php
                echo $this->getOpcje()['uczenocena']['Wartosc_Ocena'];
                ?>
        </div>
        <div class="lista_ocen_podsumowanie">
            <?php
                    $rodzajoceny = array(1 => "odpowiedź", 2 => "zadanie domowe", 3 => "kartkówka", 4 => "sprawdzian");
                    foreach ($rodzajoceny as $rodzaj => $opis) {
                        if ($rodzaj == $this->getOpcje()['uczenocena']['Za_Co']) {
                            echo $opis;
                        } else {
                            $zaznacz = '';
                        }
                        
                    }
                    ?>
        </div>
        <div class="lista_ocen_podsumowanie">
            <?php
                echo $this->getOpcje()['uczenocena']['Ocena_Nazwa'];
                ?>
        </div>
        <div class="lista_ocen_podsumowanie">
            <?php
            if($this->getOpcje()['sredniarodzaj']['Wartosc'] == 2){
                echo $this->getOpcje()['uczenocena']['Ocena_Waga'];
            }
            else{
                echo 'brak';
            }
                ?>
        </div>
        <div class="lista_ocen_podsumowanie">
            <?php echo $this->getOpcje()['uczenocena']['Ocena_Opis'] ?>
        </div>
        </p>
        </div>
    <div id="nowy_dzien_kontener"> 
                <a href="<?php echo $this->dolacz . 'twoja_klasa.html/oceny' ?>" style="margin:0vw 1vw 0vw 1vw;">anuluj</a>
            </div>
</div>
