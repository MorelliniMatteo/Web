<?php if(count($templateParams["articolo"])==0): ?>
<article>
    <p>Articolo non presente</p>
</article>
<?php
    else
        $articolo = $templateParams["articolo"][0];
?>
<article>
    <header>
        <img src="<?php echo UPLOAD_DIR.$articolo["imgarticolo"]; ?>" alt=""/>
        <h2><?php eco $articolo["titoloarticolo"]; ?></h2>
        <p><?php echo $articolo["dataarticolo"]; ?> - <?php echo $articolo["nome"]; ?></p>
    </header>
    <section>
        <p><?php echo $articolo["testoarticolo"]; ?></p>
    </section>
</article>

<?php endif; ?>