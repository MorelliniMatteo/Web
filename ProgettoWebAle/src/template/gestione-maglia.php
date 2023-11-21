        <?php 
        if($templateParams["azione"]!=1){
            $maglia = $templateParams["maglia"]; 
        }
            $azione = getAction($templateParams["azione"])
        ?>
        <form action="processa-azione.php" method="POST" enctype="multipart/form-data">
            <h2>Gestisci Maglia</h2>
            <?php if(isset($templateParams["maglia"]) && $maglia==-1): ?>
            <p>Maglia non trovata</p>
            <?php else: ?>
            <ul>
                <li>
                    <?php if($templateParams["azione"]==1): ?>
                    <label for="immagineFronte">Immagine fronte</label><input required type="file" name="immagineFronte" id="immagineFronte" />
                    <?php elseif ($templateParams["azione"]==2): ?>
                    <label for="immagineFronte">Immagine fronte</label><input type="file" name="immagineFronte" id="immagineFronte" />
                    <?php endif;
                    if($templateParams["azione"]!=1): ?>
                    <img src="<?php echo UPLOAD_DIR.$maglia["immagineFronte"]; ?>" alt="" />
                    <?php endif; ?>
                </li>
                <li>
                <?php if($templateParams["azione"]==1): ?>
                    <label for="immagineRetro">Immagine retro</label><input required type="file" name="immagineRetro" id="immagineRetro" />
                    <?php elseif ($templateParams["azione"]==2): ?>
                    <label for="immagineRetro">Immagine retro</label><input type="file" name="immagineRetro" id="immagineRetro" />
                    <?php endif;
                    if($templateParams["azione"]!=1): ?>
                    <img src="<?php echo UPLOAD_DIR.$maglia["immagineRetro"]; ?>" alt="" />
                    <?php endif; ?>
                </li>
                <li>
                    <?php if($templateParams["azione"]!=1): ?>
                    <p> <?php echo $maglia["modello"] ?> </p>
                    <?php else: 
                        foreach($dbh->getModels() as $model): ?>
                        <input required type="radio" id="modello_<?php echo $model["idModello"]; ?>" value="<?php echo $model["idModello"]; ?>" name="modello" />
                        <label for="modello_<?php echo $model["idModello"]; ?>"><?php echo $model["nome"]; ?></label>
                    <?php endforeach;
                    endif; ?>
                </li>
                <li>
                    <?php if($templateParams["azione"]!=1): ?>
                    <p> <?php echo $maglia["colore"] ?> </p>
                    <?php else: 
                        foreach($dbh->getColors() as $color): ?>
                        <input required type="radio" id="colore_<?php echo $color["idColore"]; ?>" value="<?php echo $color["idColore"]; ?>" name="colore" />
                        <label for="colore_<?php echo $color["idColore"]; ?>"><?php echo $color["nome"]; ?></label>
                    <?php endforeach;
                    endif; ?>
                </li>
                <li>
                    <?php if($templateParams["azione"]!=1): ?>
                    <p> <?php echo $maglia["genere"] ?> </p>
                    <?php else: 
                        foreach($dbh->getGenders() as $gender): ?>
                        <input required type="radio" id="genere_<?php echo $gender["idGenere"]; ?>" value="<?php echo $gender["idGenere"]; ?>" name="genere" />
                        <label for="genere_<?php echo $gender["idGenere"]; ?>"><?php echo $gender["nome"]; ?></label>
                    <?php endforeach;
                    endif; ?>
                </li>
                <li>
                    <?php if($templateParams["azione"]==3): ?>
                        <p> Prezzo: <?php echo $maglia["prezzo"] ?> </p>
                    <?php else: ?>
                        <label for="prezzo">Prezzo:</label>
                    <?php   if($templateParams["azione"]==2): ?>
                                <input required type="number" id="prezzo" name="prezzo" value="<?php echo $maglia["prezzo"] ?>" />
                    <?php   else: ?>
                                <input required type="number" id="prezzo" name="prezzo" />
                    <?php   endif;
                        endif; ?>
                </li>
                <li>
                    <?php if($templateParams["azione"]==3): ?>
                        <p> Taglia: <?php echo $maglia["taglia"] ?> </p>
                    <?php else: ?>
                        <label for="taglia">Taglia:</label>
                    <?php   if($templateParams["azione"]==2): ?>
                                <input required type="text" id="taglia" name="taglia" value="<?php echo $maglia["taglia"] ?>" />
                    <?php   else: ?>
                                <input required type="text" id="taglia" name="taglia" />
                    <?php   endif;
                        endif; ?>
                </li>
                <li>
                    <?php if($templateParams["azione"]==3): ?>
                        <p> Prezzo: <?php echo $maglia["dispMagazzino"] ?> </p>
                    <?php else: ?>
                        <label for="dispMagazzino">Disponabilità magazzino:</label>
                    <?php   if($templateParams["azione"]==2): ?>
                                <input required type="number" id="dispMagazzino" name="dispMagazzino" value="<?php echo $maglia["dispMagazzino"] ?>" />
                    <?php   else: ?>
                                <input required type="number" id="dispMagazzino" name="dispMagazzino" />
                    <?php   endif;
                        endif; ?>
                </li>
                <li>
                    <input type="submit" name="submit" value="<?php echo $azione; ?> Articolo" />
                    <a href="login.php">Annulla</a>
                </li>
            </ul>
                <?php if($templateParams["azione"]!=1): ?>
                <input type="hidden" name="idMaglia" value="<?php echo $maglia["idMaglia"]; ?>" />
                <input type="hidden" name="oldImmagineFronte" value="<?php echo $maglia["immagineFronte"]; ?>" />
                <input type="hidden" name="oldImmagineRetro" value="<?php echo $maglia["immagineRetro"]; ?>" />
                <?php endif;?>
                <input type="hidden" name="action" value="<?php echo $templateParams["azione"]; ?>" />
            <?php endif;?>
        </form>