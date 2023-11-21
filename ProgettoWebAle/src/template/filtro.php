<aside>
    <form>
        <ul>
            <?php foreach($templateParams["generi"] as $genere): ?>
                <li>
                    <label><?php echo $genere["nome"]?></label>
                    <input type="checkbox" name="<?php echo toTag($genere["nome"])?>" value="1"/>
                </li>
            <?php endforeach; ?>
            <li>
                <label>Colore</label>
                <select name="colore">
                    <option value="0">Nessuno</option>
                    <?php foreach($templateParams["colori"] as $colore): ?>
                        <option value="<?php echo $colore["idColore"]?>"><?php echo $colore["nome"]?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <li>
                <input type="submit" value="Filtra"/>
            </li>
        </ul>
    </form>
</aside>
