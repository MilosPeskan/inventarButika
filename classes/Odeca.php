<?php

require_once __DIR__ . '/Proizvod.php';

class Odeca extends Proizvod {
    private $velicina;
    private $tip_odece;
    
    public function __construct($naziv, $cena, $brend, $stanje_na_lageru, $velicina, $tip_odece) {
        parent::__construct($naziv, $cena, $brend, $stanje_na_lageru);
        $this->velicina = $velicina;
        $this->tip_odece = $tip_odece;
    }
    
    public function prikaziDetalje() {
        return "Odeća: {$this->naziv}\n" .
                "Brend: {$this->brend}\n" .
                "Tip: {$this->tip_odece}\n" .
                "Veličina: {$this->velicina}\n" .
                "Cena: {$this->cena} RSD\n" .
                "Na lageru: {$this->stanje_na_lageru}";
    }
    
    public function getVelicina() {
        return $this->velicina;
    }
    
    public function setVelicina($velicina) {
        $this->velicina = $velicina;
    }
        
    public function getTipOdece() {
        return $this->tip_odece;
    }
    
    public function setTipOdece($tip_odece) {
        $this->tip_odece = $tip_odece;
    }
}

?>