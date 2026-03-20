<?php
session_start();

if(!isset($_SESSION['radnik_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trebovanje - Butik</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../moduli/header.php'; ?>
    
    <main style="padding: 20px;">
        <h2>Trebovanje</h2>
        <br><br>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="greska">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="uspeh">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <form action="../php/add_products.php" class="form-group" method="post">
            <div id="trebovanje">
                <div id="primarno">
                    <label for="tip">Izaberite tip proizvoda</label>
                    <select name="tip" id="tip" required>
                        <option value="odeca" selected>Odeća</option>
                        <option value="obuca">Obuća</option>
                    </select>
                    <label for="naziv">Unesite naziv</label>
                    <input type="text" name="naziv" id="naziv" required>
                    <label for="cena">Unesite cenu proizvoda</label>
                    <input type="number" name="cena" step="0.01" id="cena" required>
                    <label for="brend">Unesite naziv brenda</label>
                    <input type="text" name="brend" id="brend" required>
                    <label for="kolicina">Unesite količinu</label>
                    <input type="text" name="kolicina" id="kolicina" required>
                </div>

                <div id="odecaPolja" style="display: none;">
                    <label for="velicina">Izaberite veličinu odeće</label>
                    <select name="velicina" id="velicina" required>
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                    <label for="vrsta">Izaberite vrstu odeće</label>
                    <select name="vrsta" id="vrsta" required>
                        <option value="majice">Majice</option>
                        <option value="jakne">Jakne</option>
                        <option value="pantalone">Pantalone</option>
                        <option value="trenerke">Trenerke</option>
                        <option value="duksevi">Duksevi</option>
                    </select>
                </div>

                <div id="obucaPolja" style="display: none;">
                    <label for="broj">Unesite broj obuće</label>
                    <input type="number" name="broj" id="broj" required>
                    <label for="tipo">Izaberite tip obuće</label>
                    <select name="tipo" id="tipo" required>
                        <option value="patike">Patike</option>
                        <option value="čizme">Čizme</option>
                        <option value="cipele">Cipele</option>
                    </select>
                    <label for="pol">Izaberite pol obuće</label>
                    <select name="pol" id="pol" required>
                        <option value="muška">Muška</option>
                        <option value="ženska">Ženska</option>
                        <option value="unisex">Unisex</option>
                    </select>
                </div>
            </div>
            <br>
            <button type="submit" name="submit_button">Dodaj</button>
        </form>
    </main>
    <script>
        function promeniPolja() {
            const tip = document.getElementById('tip').value;
            const odecaPolja = document.getElementById('odecaPolja');
            const obucaPolja = document.getElementById('obucaPolja');
            
            if (tip === 'odeca') {
                odecaPolja.style.display = 'block';
                obucaPolja.style.display = 'none';
                
                document.getElementById('velicina').required = true;
                document.getElementById('vrsta').required = true;
                
                document.getElementById('broj').required = false;
                document.getElementById('tip-obuce').required = false;
                document.getElementById('pol').required = false;
            } else {
                odecaPolja.style.display = 'none';
                obucaPolja.style.display = 'block';
                
                document.getElementById('velicina').required = false;
                document.getElementById('vrsta').required = false;
                
                document.getElementById('broj').required = true;
                document.getElementById('tip-obuce').required = true;
                document.getElementById('pol').required = true;
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            promeniPolja();
        });
        
        document.getElementById('tip').addEventListener('change', promeniPolja);
    </script>
</body>
</html>