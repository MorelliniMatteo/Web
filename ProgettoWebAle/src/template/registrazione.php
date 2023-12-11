<section>
    <h2>Registrazione</h2>
    <?php if(isset($templateParams["messaggio"])): ?>
        <p><?php echo $templateParams["messaggio"]; ?></p>
    <?php endif; ?>
    <form method="POST">
        <fieldset>
        <ul>
            <li>
                <label for="nomeRegistrazione">Nome:</label><br/>
                <input required type="text" id="nomeRegistrazione" name="nomeRegistrazione" />
            </li>
            <li>
                <label for="cognomeRegistrazione">Cognome:</label><br/>
                <input required type="text" id="cognomeRegistrazione" name="cognomeRegistrazione" />
            </li>
            <li>
                <label for="emailRegistrazione">Email:</label><br/>
                <input required type="text" id="emailRegistrazione" name="emailRegistrazione" />
            </li>
            <li>
                <label for="telefonoRegistrazione">Numero di telefono:</label><br/>
                <input required type="text" id="telefonoRegistrazione" name="telefonoRegistrazione" />
            </li>
            <li>
                <label for="passwordRegistrazione">Password:</label><br/>
                <input required type="password" id="passwordRegistrazione" name="passwordRegistrazione" />
            </li>
            <li>
                <label for="confermaPassword">Conferma password:</label><br/>
                <input required type="password" id="confermaPassword" name="confermaPassword" />
            </li>
            <li>
                <input type="submit" name="invioRegistrazione" value="Invia" />
            </li>
        </ul>
        </fieldset>
    </form>
    <p>Se sei già registrato allora <a href="login.php">Accedi!</a></p>
</section>