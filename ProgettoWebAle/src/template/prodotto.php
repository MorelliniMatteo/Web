<?php $maglia = $templateParams["maglia"]; ?>
    <section>
        <img src="<?php echo $IMG_DIR?>back.png" alt="precedente"/>
        <div>
            <img src="<?php echo $IMG_DIR.$maglia["immagineFronte"]; ?>" alt="<?php echo $maglia["idMaglia"]; ?>">
            <img src="<?php echo $IMG_DIR.$maglia["immagineRetro"]; ?>" alt="<?php echo $maglia["idMaglia"]; ?>">
        </div>
        <img src="<?php echo $IMG_DIR?>next.png" alt="prossima"/>
        <fieldset><legend>Personalizza:</legend>
            <ul>
                <li>
                    <p>Taglia: <?php echo $maglia["taglia"]?></p>
                </li>
                <li>
                    <label for="taglia">Seleziona un'altra taglia:</label>
                    <form method="POST">
                        <ul>
                            <li>
                            <select name="taglia">
                                <?php foreach($templateParams["taglie"] as $taglia): ?>
                                    <?php if($taglia["taglia"] != $maglia["taglia"]): ?>
                                        <option value="<?php echo $taglia["taglia"]?>"><?php echo $taglia["taglia"]?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            </li>
                            <li>
                                <input type="submit" name="cambioTaglia" value="Cambia taglia"/>
                            </li>
                        </ul>
                    </form>
                </li>
                <li>
                    <p>Colore: <?php echo $maglia["colore"]?></p>
                </li>
                <li>
                    <label for="colore">Seleziona un altro colore disponibile per lo stesso modello:</label>
                    <form method="POST">
                        <ul>
                            <li>
                            <select name="colore">
                                <?php foreach($templateParams["colori"] as $colore): ?>
                                    <?php if($colore["idColore"] != $maglia["idColore"]): ?>
                                        <option value="<?php echo $colore["idColore"]?>"><?php echo $colore["nome"]?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            </li>
                            <li>
                                <input type="submit" name="cambioColore" value="Cambia colore"/>
                            </li>
                        </ul>
                    </form>
                </li>
                <li>
                    <form method="POST">
                        <ul>
                            <li>
                                <label for="quantity">Quantità:</label>
                                <input required type="number" name="quantità" min="1" max="<?php echo $maglia["dispMagazzino"]?>"/>
                                <p>(ne sono rimaste solo <?php echo $maglia["dispMagazzino"]?>)</p>
                            </li>
                            <li>
                                <label for="name">Nome(+5€):</label>
                                <input type="name" id="nomePersonalizzato" name="nomePersonalizzato"/>
                            </li>
                            <li>
                                <label for="number">Numero(+5€):</label>
                                <input type="number" name="numeroPersonalizzato" min="1" max="99"/>
                            </li>
                            <li>
                                <?php if($maglia["dispMagazzino"] <= 0): ?>
                                    <p>In questo momento la maglia non è disponibile!</p>
                                <?php else: ?>
                                    <input type="submit" name="aggiungi" value="Aggiungi al carrello"/>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </form>
                </li>
            </ul>
        </fieldset>
    </section>
    <section>
        <h2>Descrizione prodotto:</h2>
        <article>
            <h3><?php echo $maglia["modello"]?></h3>
            <p><?php echo $maglia["genere"]?> - <?php echo $maglia["colore"]?></p>
            <p><?php echo $maglia["descrizione"]?></p>
            <p>Prezzo: <?php echo $maglia["prezzo"]?>€</p>
        </article>
        <table>
            <caption>Guida alle taglie (cm):</caption>
            <thead>
                <tr>
                    <th scope="col" id="taglia">Taglia</th>
                    <th scope="col" id="it">IT</th>
                    <th scope="col" id="spalla">Spalla</th>
                    <th scope="col" id="lung">Lunghezza</th>
                    <th scope="col" id="manica">Manica</th>
                    <th scope="col" id="torace">Torace</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td headers="taglia">XS</td>
                    <td headers="it">44</td>
                    <td headers="spalla">45</td>
                    <td headers="lung">66</td>
                    <td headers="manica">20</td>
                    <td headers="torace">100</td>
                </tr>
                <tr>
                    <td headers="taglia">S</td>
                    <td headers="it">46</td>
                    <td headers="spalla">45.5</td>
                    <td headers="lung">68</td>
                    <td headers="manica">20.5</td>
                    <td headers="torace">104</td>
                </tr>
                <tr>
                    <td headers="taglia">M</td>
                    <td headers="it">48</td>
                    <td headers="spalla">46</td>
                    <td headers="lung">70</td>
                    <td headers="manica">21</td>
                    <td headers="torace">108</td>
                </tr>
                <tr>
                    <td headers="taglia">L</td>
                    <td headers="it">50</td>
                    <td headers="spalla">47</td>
                    <td headers="lung">72</td>
                    <td headers="manica">21.5</td>
                    <td headers="torace">112</td>
                </tr>
                <tr>
                    <td headers="taglia">XL</td>
                    <td headers="it">52</td>
                    <td headers="spalla">50</td>
                    <td headers="lung">74</td>
                    <td headers="manica">22</td>
                    <td headers="torace">116</td>
                </tr>
            </tbody>
        </table>
    </section>
