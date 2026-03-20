<?php
    session_start();

    if(!isset($_SESSION['radnik_id'])) {
        header("Location: ../index.php");
        exit();
    }

    require_once __DIR__ . '/../autoload.php';
    require_once __DIR__ . '/../connections/pdo.php';

    $db = getDBConnection();
    $repo = new Repository($db);

    $svaObuca = $repo->svaObuca();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Butik</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../moduli/header.php'; ?>
    
    <main style="padding: 20px;">
        <div class="title-holder">
            <a href="articles.php">Odeća</a> | 
            <a href="footwear.php">Obuća</a>
            <h2>Inventar obuće:</h2>
            <input type="text" id="search" placeholder="Pretraga">
        </div>
        <div id="items-list">
            <?php foreach($svaObuca as $proizvod): ?>
                <?php
                    $naziv = $proizvod->getNaziv();
                    $klasa = get_class($proizvod);
                    $brend = $proizvod->getBrend();
                    $cena = $proizvod->getCena();
                    $kolicina = $proizvod->getStanjeNaLageru(); 
                    $id = $proizvod->getId();
                ?>
                <?php include '../moduli/item_holder.php'; ?>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        document.querySelectorAll('.dodaj').forEach(button => {
            button.addEventListener('click', function() {
                let proizvodId = this.getAttribute('data-id');
                let kolicinaElement = this.previousElementSibling;
                
                fetch('../php/actions/add.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + proizvodId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        kolicinaElement.textContent = data.nova_kolicina;
                    } else {
                        alert('Greška: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Greška:', error);
                    alert('Došlo je do greške pri ažuriranju količine.');
                });
            });
        });

        document.querySelectorAll('.smanji').forEach(button => {
            button.addEventListener('click', function() {
                let proizvodId = this.getAttribute('data-id');
                let kolicinaElement = this.nextElementSibling;
                
                fetch('../php/actions/remove.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + proizvodId
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        kolicinaElement.textContent = data.nova_kolicina;
                    } else {
                        alert('Greška: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Greška:', error);
                    alert('Došlo je do greške pri ažuriranju količine.');
                });
            });
        });

        document.querySelectorAll('.obrisi').forEach(button => {
            button.addEventListener('click', function() {
                let proizvodId = this.getAttribute('data-id');
                let itemHolder = this.closest('.item-holder');
                
                if(confirm('Da li ste sigurni da želite da obrišete ovaj proizvod?')) {
                    fetch('../php/actions/delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + proizvodId
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            itemHolder.remove();
                        } else {
                            alert('Greška: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Greška:', error);
                        alert('Došlo je do greške pri brisanju proizvoda.');
                    });
                }
            });
        });

        document.getElementById('search').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            let items = document.querySelectorAll('.item-holder');
            
            items.forEach(item => {
                let naziv = item.querySelector('.naziv').textContent.toLowerCase();
                let brend = item.querySelector('.brend').textContent.toLowerCase();
                
                if(naziv.includes(searchTerm) || brend.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>