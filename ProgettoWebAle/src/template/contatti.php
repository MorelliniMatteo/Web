            <section>
                <h2>Contatti</h2>
                <table>
                    <thead>
                        <tr>
                            <th id="autore">Autore</th>
                            <th id="email_autore">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dbh->getAdmins() as $admin): ?>
                            <tr>
                                <th id="<?php echo toTag($admin["nome"]), toTag($admin["cognome"]); ?>" headers="autore" ><?php echo $admin["nome"], " ", $admin["cognome"]; ?></th>
                                <td headers="<?php echo toTag($admin["nome"]), toTag($admin["cognome"]); ?> email_autore"><?php echo $admin["email"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>