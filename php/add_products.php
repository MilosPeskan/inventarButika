<?php
    session_start();

    require_once __DIR__ . '/../autoload.php';
    require_once __DIR__ . '/../connections/pdo.php';

    $db = getDBConnection();
    $repo = new Repository($db);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        try {
            // Validacija i sanitizacija osnovnih polja
            $type = filter_var(trim($_POST["tip"] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
            $type = ucfirst($type);
            
            $name = filter_var(trim($_POST["naziv"] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
            $name = ucfirst($name);
            
            $price = filter_var($_POST["cena"] ?? 0, FILTER_VALIDATE_FLOAT);
            if ($price === false) {
                throw new Exception("Cena mora biti validan broj!");
            }
            
            $brand = filter_var(trim($_POST["brend"] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
            $brand = ucfirst($brand);
            
            $quantity = filter_var($_POST["kolicina"] ?? 0, FILTER_VALIDATE_INT);
            if ($quantity === false) {
                throw new Exception("Količina mora biti validan broj!");
            }

            if (empty($type) || empty($name) || $price <= 0 || empty($brand) || $quantity < 0) {
                throw new Exception("Sva obavezna polja moraju biti popunjena!");
            }


            if($type === "Odeca"){
                $size = filter_var(trim($_POST["velicina"] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
                
                $clothingType = filter_var(trim($_POST["vrsta"] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
                $clothingType = ucfirst($clothingType);

                if (empty($size) || empty($clothingType)) {
                    throw new Exception("Sva polja za odeću moraju biti popunjena!");
                }

                $odeca = new Odeca ($name, $price, $brand, $quantity, $size, $type);
                $id = $repo->dodajOdecu($odeca);
            
                $_SESSION['success'] = "Odeća uspešno dodata! ID: $id";
                
            } elseif ($type === "Obuca"){
                $shoeSize = filter_var($_POST["broj"] ?? 0, FILTER_VALIDATE_INT);
                if ($shoeSize === false) {
                    throw new Exception("Broj obuće mora biti validan broj!");
                }
                
                $shoeType = filter_var(trim($_POST["tipo"] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
                $shoeType = ucfirst($shoeType);
                
                $gender = filter_var(trim($_POST["pol"] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
                $gender = ucfirst($gender);

                if ($shoeSize <= 0 || empty($shoeType) || empty($gender)) {
                    throw new Exception("Sva polja za obuću moraju biti popunjena!");
                }

                $obuca = new Obuca ($name, $price, $brand, $quantity, $shoeSize, $shoeType, $gender);
                $id = $repo->dodajObucu($obuca);
            
                $_SESSION['success'] = "Obuća uspešno dodata! ID: $id";
                
            } else {
                throw new Exception("Nevažeći tip proizvoda!" . $type);
            }

            header("Location: ../pages/order.php");
            exit;
            
        } catch (Exception $e) {
            // Uhvati greške i prikaži poruku
            $_SESSION['error'] = $e->getMessage();
            header("Location: ../pages/order.php");
            exit;
        }
        
    } else {
        // Ako forma nije poslata, vrati nazad
        header("Location: ../pages/order.php");
        exit;
    }

?>