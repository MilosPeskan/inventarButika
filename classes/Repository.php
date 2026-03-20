<?php

class Repository {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function dodajOdecu(Odeca $odeca) {
        try {
            $this->db->beginTransaction();
            
            $sql = "INSERT INTO proizvodi (tip_proizvoda, naziv, cena, brend, stanje_na_lageru)
                    VALUES ('odeca', :naziv, :cena, :brend, :stanje)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':naziv' => $odeca->getNaziv(),
                ':cena' => $odeca->getCena(),
                ':brend' => $odeca->getBrend(),
                ':stanje' => $odeca->getStanjeNaLageru()
            ]);
            
            $proizvod_id = $this->db->lastInsertId();
            
            $sql = "INSERT INTO odeca (id, velicina, tip_odece)
                    VALUES (:id, :velicina, :tip)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $proizvod_id,
                ':velicina' => $odeca->getVelicina(),
                ':tip' => $odeca->getTipOdece()
            ]);
            
            $this->db->commit();
            $odeca->setId($proizvod_id);
            
            return $proizvod_id;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Greška pri dodavanju odeće: " . $e->getMessage());
        }
    }
    
    public function dodajObucu(Obuca $obuca) {
        try {
            $this->db->beginTransaction();
            
            $sql = "INSERT INTO proizvodi (tip_proizvoda, naziv, cena, brend, stanje_na_lageru)
                    VALUES ('obuca', :naziv, :cena, :brend, :stanje)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':naziv' => $obuca->getNaziv(),
                ':cena' => $obuca->getCena(),
                ':brend' => $obuca->getBrend(),
                ':stanje' => $obuca->getStanjeNaLageru()
            ]);
            
            $proizvod_id = $this->db->lastInsertId();
            
            $sql = "INSERT INTO obuca (id, broj, tip_obuce, pol)
                    VALUES (:id, :broj, :tip, :pol)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $proizvod_id,
                ':broj' => $obuca->getBroj(),
                ':tip' => $obuca->getTipObuce(),
                ':pol' => $obuca->getPol()
            ]);
            
            $this->db->commit();
            $obuca->setId($proizvod_id);
            
            return $proizvod_id;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Greška pri dodavanju obuće: " . $e->getMessage());
        }
    }
    
    
    public function svaOdeca() {
        $sql = "SELECT p.*, o.velicina, o.tip_odece
                FROM proizvodi p
                JOIN odeca o ON p.id = o.id
                ORDER BY p.naziv";
        
        $stmt = $this->db->query($sql);
        $rezultat = [];
        
        while ($row = $stmt->fetch()) {
            $odeca = new Odeca(
                $row['naziv'],
                $row['cena'],
                $row['brend'],
                $row['stanje_na_lageru'],
                $row['velicina'],
                $row['tip_odece']
            );
            $odeca->setId($row['id']);
            $rezultat[] = $odeca;
        }
        
        return $rezultat;
    }
    
    public function svaObuca() {
        $sql = "SELECT p.*, o.broj, o.tip_obuce, o.pol
                FROM proizvodi p
                JOIN obuca o ON p.id = o.id
                ORDER BY p.naziv";
        
        $stmt = $this->db->query($sql);
        $rezultat = [];
        
        while ($row = $stmt->fetch()) {
            $obuca = new Obuca(
                $row['naziv'],
                $row['cena'],
                $row['brend'],
                $row['stanje_na_lageru'],
                $row['broj'],
                $row['tip_obuce'],
                $row['pol']
            );
            $obuca->setId($row['id']);
            $rezultat[] = $obuca;
        }
        
        return $rezultat;
    }
    
    public function obrisiProizvod($id) {
        $sql = "DELETE FROM proizvodi WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
            
    public function povecajStanje($id, $kolicina) {
        try {
            $sql = "UPDATE proizvodi 
                    SET stanje_na_lageru = stanje_na_lageru + :kolicina 
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':kolicina' => $kolicina
            ]);
            
            return $stmt->rowCount() > 0;
            
        } catch (Exception $e) {
            throw new Exception("Greška pri povećanju stanja: " . $e->getMessage());
        }
    }
    
    public function smanjiStanje($id, $kolicina) {
        try {
            $sql = "SELECT stanje_na_lageru FROM proizvodi WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $trenutnoStanje = $stmt->fetchColumn();
            
            if ($trenutnoStanje < $kolicina) {
                throw new Exception("Nema dovoljno proizvoda na lageru!");
            }
            
            $sql = "UPDATE proizvodi 
                    SET stanje_na_lageru = stanje_na_lageru - :kolicina 
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':kolicina' => $kolicina
            ]);
            
            return $stmt->rowCount() > 0;
            
        } catch (Exception $e) {
            throw new Exception("Greška pri smanjenju stanja: " . $e->getMessage());
        }
    }
        
    public function primeniPopustNaSve($procenat, $tip_proizvoda = null) {
        try {
            $sql = "UPDATE proizvodi 
                    SET cena = cena * (1 - :procenat / 100)";
            
            $params = [':procenat' => $procenat];
            
            if ($tip_proizvoda) {
                $sql .= " WHERE tip_proizvoda = :tip";
                $params[':tip'] = $tip_proizvoda;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->rowCount(); 
            
        } catch (Exception $e) {
            throw new Exception("Greška pri primeni popusta: " . $e->getMessage());
        }
    }
    public function dodajKolicinu($id) {
        try {
            $this->povecajStanje($id, 1);
            
            $sql = "SELECT stanje_na_lageru FROM proizvodi WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetchColumn();
            
        } catch (Exception $e) {
            throw new Exception("Greška pri dodavanju količine: " . $e->getMessage());
        }
    }

    public function smanjiKolicinu($id) {
        try {
            $sql = "SELECT stanje_na_lageru FROM proizvodi WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $trenutnoStanje = $stmt->fetchColumn();
            
            if ($trenutnoStanje <= 0) {
                throw new Exception("Količina ne može biti manja od 0!");
            }
            
            $this->smanjiStanje($id, 1);
            
            $stmt->execute([':id' => $id]);
            return $stmt->fetchColumn();
            
        } catch (Exception $e) {
            throw new Exception("Greška pri smanjenju količine: " . $e->getMessage());
        }
    }
}

?>