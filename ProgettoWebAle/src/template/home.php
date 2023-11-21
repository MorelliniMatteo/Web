<?php foreach($templateParams["generi"] as $genere): ?>
    <section>
	    <h2><a href="prodotti.php?<?php echo toTag($genere["nome"])?>=1"><?php echo $genere["nome"]?></a></h2>
                <div>
                    <a href="prodotti.php?<?php echo toTag($genere["nome"])?>=1">
                        <img <?php isActive("prodotti.php");?> src="<?php echo $IMG_DIR?>Prodotti<?php echo $genere["nome"]?>.jpg" alt="prodotti <?php echo toTag($genere["nome"])?>" />
                    </a>
                </div>
            </section>
<?php endforeach; ?>
