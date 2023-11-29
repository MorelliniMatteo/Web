<?php foreach($templateParams["articoli"] as $articolo): ?>
    <article>
        <header>
            <img src="<?php echo UPLOAD_DIR.$articolo["imgarticolo"]; ?>" alt="">
            <h2><?php echo $articolo["titoloarticolo"] ?></h2>
            <p><?php echo $articolo["dataarticolo"]; ?> - <?php echo $articolo["nome"]; ?></p>
        </header>
        <section lang="zxx">
            <p><?php echo $articolo["anteprimaarticolo"]; ?></p>
        </section>
        <footer>
            <a href="#">Leggi tutto</a>
        </footer>
    </article>

<?php endforeach; ?>