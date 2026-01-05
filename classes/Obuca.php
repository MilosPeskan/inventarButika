<?php

require_once __DIR__ . '/Proizvod.php';

class Obuca extends Proizvod {
    private $broj;
    private $tip_obuce;
    private $pol;
    
    public function __construct($naziv, $cena, $brend, $stanje_na_lageru, $broj, $tip_obuce, $pol) {
        parent::__construct($naziv, $cena, $brend, $stanje_na_lageru);
        $this->broj = $broj;
        $this->tip_obuce = $tip_obuce;
        $this->pol = $pol;
    }
    
    public function prikaziDetalje() {
        return "Obuća: {$this->naziv}\n" .
               "Brend: {$this->brend}\n" .
               "Tip: {$this->tip_obuce}\n" .
               "Broj: {$this->broj}\n" .
               "Pol: {$this->pol}\n" .
               "Cena: {$this->cena} RSD\n" .
               "Na lageru: {$this->stanje_na_lageru}";
    }
    
    public function getBroj() {
        return $this->broj;
    }
    
    public function setBroj($broj) {
        $this->broj = $broj;
    }
    
    public function getTipObuce() {
        return $this->tip_obuce;
    }
    
    public function setTipObuce($tip_obuce) {
        $this->tip_obuce = $tip_obuce;
    }
    
    public function getPol() {
        return $this->pol;
    }
    
    public function setPol($pol) {
        $this->pol = $pol;
    }
}

?>