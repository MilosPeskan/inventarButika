<div class="item-holder" data-id="<?php echo $id; ?>">
    <h3 class="naziv"><?php echo htmlspecialchars($naziv); ?></h3>
    <p class="klasa"><?php echo htmlspecialchars($klasa); ?></p>
    <p class="brend"><?php echo htmlspecialchars($brend); ?></p>
    <p class="cena"><?php echo number_format($cena, 2); ?> RSD</p>
    <button class="smanji" data-id="<?php echo $id; ?>">-</button>
    <p class="kolicina"><?php echo $kolicina; ?></p>
    <button class="dodaj" data-id="<?php echo $id; ?>">+</button>
    <button class="obrisi" data-id="<?php echo $id; ?>">x</button>
</div>