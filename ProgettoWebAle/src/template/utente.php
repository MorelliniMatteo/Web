            <?php require("credenziali.php") ?>
            <section>
                <h2>I miei ordini</h2>
                <?php foreach($templateParams["ordini"] as $ordine): ?>
                    <div>
                        <h2> Data pagamento: <?php echo $ordine["dataPagamento"] ?></h2>
                        <h3> Stato: <?php echo $ordine["stato"] ?></h3>
                        <table>
                            <thead>
                                <tr>
                                    <th id="maglia_<?php echo $ordine["idOrdine"]; ?>">Maglia</th>
                                    <th id="taglia_<?php echo $ordine["idOrdine"]; ?>">Taglia</th>
                                    <th id="scritta_<?php echo $ordine["idOrdine"]; ?>">Nome</th>
                                    <th id="numero_<?php echo $ordine["idOrdine"]; ?>">Num.</th>
                                    <th id="quantità_<?php echo $ordine["idOrdine"]; ?>">Qt</th>
                                    <th id="costo_<?php echo $ordine["idOrdine"]; ?>">Costo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dbh->getProductsInOrder($ordine["idOrdine"]) as $product): ?>
                                <tr>
                                    <td headers="maglia_<?php echo $ordine["idOrdine"]; ?>">
                                        <a href="singolo-prodotto.php?idMaglia=<?php echo $product["idMaglia"]; ?>">
                                            <img src="<?php echo $IMG_DIR.$product["immagineFronte"]; ?>" alt="<?php echo $product["immagineFronte"]; ?>">
                                        </a>
                                    </td>
                                    <td headers="taglia_<?php echo $ordine["idOrdine"]; ?>">
                                        <?php echo $product["taglia"]; ?>
                                    </td>
                                    <td headers="scritta_<?php echo $ordine["idOrdine"]; ?>">
                                        <?php echo $product["nomePersonalizzato"]; ?>
                                    </td>
                                    <td headers="numero_<?php echo $ordine["idOrdine"]; ?>">
                                        <?php echo $product["numeroPersonalizzato"]; ?>
                                    </td>
                                    <td headers="quantità_<?php echo $ordine["idOrdine"]; ?>">
                                        <?php echo $product["quantità"]; ?>
                                    </td>
                                    <td headers="costo_<?php echo $ordine["idOrdine"]; ?>">
                                        <?php echo $product["costo"]; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th id="totale_<?php echo $ordine["idOrdine"]; ?>">Totale:</th>
                                    <td colspan=5 headers="totale_<?php echo $ordine["idOrdine"]; ?>"><?php echo $ordine["totale"]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </section>