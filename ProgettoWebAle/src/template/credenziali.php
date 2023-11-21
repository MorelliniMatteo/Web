<section>
    <h2>Credenziali</h2>
    <?php if(isset($_SESSION["email"])): ?>
        <p>Email: <?php echo $_SESSION["email"]; ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="submit" name="logout" value="Logout" /> 
    </form>
    <form method="POST">
        <fieldset><legend>Cambia password:</legend>
            <ul>
                <li>
                    <label for="vecchiaPassword">Vecchia Password:</label>
                    <input required type="password" id="vecchiaPassword" name="vecchiaPassword" />
                </li>
                <li>
                    <label for="nuovaPassword">Nuova Password:</label>
                    <input required type="password" id="nuovaPassword" name="nuovaPassword" />
                </li>
                <li> 
                    <input type="submit" name="cambia" value="Cambia" /> 
                </li>
            </ul>
        </fieldset>
    </form>
    <?php if(isset($templateParams["messaggio"])): ?>
        <p><?php echo $templateParams["messaggio"]; ?></p>
    <?php endif; ?>
</section>
