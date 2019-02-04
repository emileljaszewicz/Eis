<?php 
class Widok{
    private $wysw;
	private $cssglowny;
	private $cssdodatkowy = array(); 
        private $danezfunkcji = array();
        private $szablonglowny;
        public $widokhtml;
	function __construct($kontroler, $url){
		$this->kontroler = $kontroler;
                $this->url = $url;
                $this->licz_podkatalogi = new UrlTranslator($this->url);
                $this->dolacz = $this->licz_podkatalogi->katalog_gora();
		$this->cssglowny ='szablonglowny/style/style.css';
	}
	        function getTytulstrony(){
            return $this->tytulstrony;
        }
        function getCssdodatkowy(){
            return $this->cssdodatkowy;
        }
        function setTytulstrony($zmienna){
            $this->tytulstrony = $zmienna;
        }
        function setCssdodatkowy($plikcss){
            $this->cssdodatkowy[] = $plikcss;
        }
        function setSzablonglowny($plikszablon){
            
            $this->szablonglowny = $plikszablon;
        }
        function getSzablonglowny(){
            return $this->szablonglowny;
        }
        function setWidokmodul($linkszablon, $link = "widoki"){
            $this->widokhtml = 'skrypty/moduly/'.$this->kontroler.'/'.$link.'/'.$linkszablon.'.php';
        }
        function getWidokmodul(){
            return include($this->widokhtml);
        }
        function wolajfunkcja($nazwafunkcji, $parametry = null){
            $ob = $this->kontroler.'model';
             $dane = new $ob($this->url);
             return $dane->$nazwafunkcji($parametry);
        }
        function szablonglowny(){
            include($this->getSzablonglowny());
        }
        function wyswietlbledy($dane) {
        $this->wysw = $dane;
    }
function setOpcje($nazwaopcji, $danezfunkcji){
     $this->danezfunkcji[$nazwaopcji] = $danezfunkcji;
 }
 function getOpcje(){
     return $this->danezfunkcji;
 }
    function wyswietl() {
        return $this->wysw;
    }
}
?>