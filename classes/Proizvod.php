<?php

abstract class Proizvod {
    protected $id;
    protected $naziv;
    protected $cena;
    protected $brend;
    protected $stanje_na_lageru;
    
    public function __construct($naziv, $cena, $brend, $stanje_na_lageru = 0) {
        $this->naziv = $naziv;
        $this->cena = $cena;
        $this->brend = $brend;
        $this->stanje_na_lageru = $stanje_na_lageru;
    }
    
    abstract public function prikaziDetalje();
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getNaziv() {
        return $this->naziv;
    }
    
    public function setNaziv($naziv) {
        $this->naziv = $naziv;
    }
    
    public function getCena() {
        return $this->cena;
    }
    
    public function setCena($cena) {
        $this->cena = $cena;
    }
    
    public function getBrend() {
        return $this->brend;
    }
    
    public function setBrend($brend) {
        $this->brend = $brend;
    }
    
    public function getStanjeNaLageru() {
        return $this->stanje_na_lageru;
    }
    
    public function setStanjeNaLageru($stanje) {
        $this->stanje_na_lageru = $stanje;
    }
    
    public function proveriDostupnost() {
        return $this->stanje_na_lageru > 0;
    }
}

?>