<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    public function getLatestOrders($n=10){
        $query = "SELECT idOrdine, email, dataPagamento, stato, 
            (SELECT GROUP_CONCAT(idMaglia, '.', quantità) 
            FROM maglia_ordinata
            WHERE maglia_ordinata.idOrdine=ordine.idOrdine
            GROUP BY maglia_ordinata.idOrdine) as maglie
            FROM ordine
            ORDER BY dataPagamento DESC 
            LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAdmins(){
        $stmt = $this->db->prepare("SELECT email, nome, cognome FROM account WHERE admin=1");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProducts(){
        $stmt = $this->db->prepare("SELECT idMaglia, immagineFronte, dispMagazzino FROM maglia ORDER BY dispMagazzino");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function mostSold($n = 3){
        $query = "SELECT idMaglia, immagineFronte FROM maglia ORDER BY vendite DESC LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getModels(){
        $stmt = $this->db->prepare("SELECT idModello, nome FROM modello");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getColors(){
        $stmt = $this->db->prepare("SELECT idColore, nome FROM colore");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getGenders(){
        $stmt = $this->db->prepare("SELECT idGenere, nome FROM genere");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSizes(){
        $stmt = $this->db->prepare("SELECT taglia FROM maglia GROUP BY taglia");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrdersOfUser($email){
        $stmt = $this->db->prepare("SELECT dataPagamento, stato, totale, idOrdine FROM ordine WHERE email=? ORDER BY dataPagamento DESC");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsInOrder($idOrder){
        $stmt = $this->db->prepare("SELECT maglia.idMaglia, quantità, nomePersonalizzato, numeroPersonalizzato, costo, immagineFronte, taglia
            FROM maglia_ordinata, maglia WHERE maglia.idMaglia = maglia_ordinata.idMaglia AND idOrdine=?");
        $stmt->bind_param("i", $idOrder);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsInCart($email){
        $stmt = $this->db->prepare("SELECT idRiga, maglia.idMaglia, quantità, nomePersonalizzato, numeroPersonalizzato, costo, immagineFronte, taglia
            FROM maglia_in_carrello, maglia WHERE maglia.idMaglia = maglia_in_carrello.idMaglia AND email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id){
        $stmt = $this->db->prepare("SELECT immagineFronte, immagineRetro, modello.idModello as idModello, modello.nome as modello, modello.descrizione as descrizione, colore.nome as colore, colore.idColore as idColore, genere.nome as genere, genere.idGenere as idGenere, prezzo, taglia, idMaglia, dispMagazzino
            FROM maglia, modello, genere, colore WHERE maglia.idModello = modello.idModello AND
            maglia.idColore = colore.idColore AND maglia.idGenere = genere.idGenere AND
            maglia.idMaglia=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductBySize($genere, $colore, $modello, $taglia){
        $stmt = $this->db->prepare("SELECT idMaglia FROM maglia WHERE taglia = ? AND idGenere = ? AND idColore = ? AND idModello = ?");
        $stmt->bind_param("siii", $taglia, $genere, $colore, $modello);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getColorsByModel($modello, $genere, $taglia){
        $stmt = $this->db->prepare("SELECT maglia.idColore, colore.nome FROM maglia, colore WHERE maglia.idColore = colore.idColore AND taglia = ? AND idGenere = ? AND idModello = ? GROUP BY idColore");
        $stmt->bind_param("sii", $taglia, $genere, $modello);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function checkLogin($email, $password){
        $query = "SELECT email, password, admin FROM account WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    } 

    public function changePassword($email, $vecchiaPassword, $nuovaPassword){
        $query = "UPDATE account SET password = ? WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $nuovaPassword, $email, $vecchiaPassword);
        $stmt->execute();

        return $stmt->affected_rows;
    } 

    public function register($email, $nome, $cognome, $password, $telefono){
        $query = "INSERT INTO account (email, nome, cognome, password, numeroTelefono)
            VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssss', $email, $nome, $cognome, $password, $telefono);
        $stmt->execute();

        return $stmt->affected_rows;
    } 
    
    public function alreadyRegistered($email){
        $query = "SELECT email FROM account WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFilteredShirts($generi, $colore){

        if($colore > 0){
            //Maglie di un colore
            if (count($generi) <= 0 || count($generi) >= 3) {
                //Maglie di qualsiasi genere
                $query = "SELECT M.idMaglia, M.prezzo, M.immagineFronte, O.nome as modello, G.nome as genere FROM maglia M, modello O, genere G WHERE M.dispMagazzino > 0 AND  M.idModello = O.idModello AND M.idGenere = G.idGenere AND idColore = ? GROUP BY M.idGenere, M.idModello, M.idColore";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('i', $colore);
    
            } elseif(count($generi) == 1) {
                //Maglie di UN genere
                $query = "SELECT M.idMaglia, M.prezzo, M.immagineFronte, O.nome as modello, G.nome as genere FROM maglia M, modello O, genere G WHERE M.dispMagazzino > 0 AND M.idModello = O.idModello AND M.idGenere = G.idGenere AND M.idGenere = ? AND idColore = ? GROUP BY M.idGenere, M.idModello, M.idColore";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ii', $generi[0], $colore);
            } else {
                //Maglie di DUE generi
                $query = "SELECT M.idMaglia, M.prezzo, M.immagineFronte, O.nome as modello, G.nome as genere FROM maglia M, modello O, genere G WHERE M.dispMagazzino > 0 AND M.idModello = O.idModello AND M.idGenere = G.idGenere AND idColore = ? AND M.idGenere IN (?, ?) GROUP BY M.idGenere, M.idModello, M.idColore";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('iii', $colore, $generi[0], $generi[1]);
            }
        } else {
            //Maglie di qualsiasi colore
            if (count($generi) <= 0 || count($generi) >= 3) {
                //Maglie di qualsiasi genere
                $query = "SELECT M.idMaglia, M.prezzo, M.immagineFronte, O.nome as modello, G.nome as genere FROM maglia M, modello O, genere G WHERE M.dispMagazzino > 0 AND  M.idModello = O.idModello AND M.idGenere = G.idGenere GROUP BY M.idGenere, M.idModello, M.idColore";
                $stmt = $this->db->prepare($query);
    
            } elseif(count($generi) == 1) {
                //Maglie di UN genere
                $query = "SELECT M.idMaglia, M.prezzo, M.immagineFronte, O.nome as modello, G.nome as genere FROM maglia M, modello O, genere G WHERE M.dispMagazzino > 0 AND M.idModello = O.idModello AND M.idGenere = G.idGenere AND M.idGenere = ? GROUP BY M.idGenere, M.idModello, M.idColore";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('i', $generi[0]);
            } else {
                //Maglie di DUE generi
                $query = "SELECT M.idMaglia, M.prezzo, M.immagineFronte, O.nome as modello, G.nome as genere FROM maglia M, modello O, genere G WHERE M.dispMagazzino > 0 AND M.idModello = O.idModello AND M.idGenere = G.idGenere AND M.idGenere IN (?, ?) GROUP BY M.idGenere, M.idModello, M.idColore";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('ii', $generi[0], $generi[1]);
            }
        }
        
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addToProduct($id, $qta){
        $query = "UPDATE maglia SET dispMagazzino = dispMagazzino + ? WHERE idMaglia = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $qta, $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function insertProduct($modello, $colore, $taglia, $genere, $dispMagazzino, $prezzo, $imgFronte, $imgRetro){
        $query = "INSERT INTO maglia (idModello, idColore, taglia, idGenere, dispMagazzino,
            prezzo, immagineFronte, immagineRetro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iisiiiss', $modello, $colore, $taglia, $genere, $dispMagazzino,
            $prezzo, $imgFronte, $imgRetro);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function updateProduct($id, $prezzo, $taglia, $immagineFronte, $immagineRetro, $dispMagazzino){
        $query = "UPDATE maglia SET dispMagazzino = ?, prezzo = ?, taglia = ?,
        immagineFronte = ?, immagineRetro = ? WHERE idMaglia = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iisssi', $dispMagazzino, $prezzo, $taglia,
            $immagineFronte, $immagineRetro, $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function removeProduct($id){
        $query = "UPDATE maglia SET dispMagazzino = 0 WHERE idMaglia = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function stock($id){
        $query = "SELECT dispMagazzino FROM maglia WHERE idMaglia = ? ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function numberOfProductInCart($id, $email){
        $query = "SELECT quantità FROM maglia_in_carrello WHERE idMaglia = ? AND email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $id, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $tot = 0;
        foreach($result as $value){
            $tot += $value["quantità"];
        }

        return $tot;
    }

    public function executeOrder($email){
        $error = false;
        $maglie = $this->getProductsInCart($email);
        $totale = 0.0;
        foreach($maglie as $maglia){
            $totale += $maglia["costo"];
        }
        //inserimento ordine
        $stato = "Ordine confermato, consegna prevista al Campus entro 5 giorni lavorativi!";
        $query = "INSERT INTO ordine (email, dataPagamento, stato, totale) 
            VALUES (?, CURRENT_TIMESTAMP(), ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssd', $email, $stato, $totale);
        $stmt->execute();

        $idOrder = $stmt->insert_id;
        if(!($idOrder>0)){
            return true;
        }

        //inserimento delle maglie nell'ordine, diminuzione scorte e aumento vendite
        $query = "INSERT INTO maglia_ordinata (idMaglia, idOrdine, quantità, nomePersonalizzato, numeroPersonalizzato, costo) 
            VALUES (?, ?, ?, ?, ?, ?)";
        $query2 = "UPDATE maglia SET dispMagazzino = dispMagazzino - ?, vendite = vendite + ? WHERE idMaglia = ?";
        
        if(count($maglie) == 0){
            return true;
        }
        foreach($maglie as $maglia){
            //la metto nell'ordine
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iiisid', $maglia["idMaglia"], $idOrder,
                $maglia["quantità"], $maglia["nomePersonalizzato"],
                $maglia["numeroPersonalizzato"], $maglia["costo"]);
            $stmt->execute();
            $id = $stmt->insert_id;
            if(!($idOrder>0)){
                return true;
            }
            //la tolgo dal magazzino
            $stmt = $this->db->prepare($query2);
            $stmt->bind_param('iii', $maglia["quantità"], $maglia["quantità"], $maglia["idMaglia"]);
            $stmt->execute();
            if($stmt->affected_rows!=1){
                return true;
            }
        }

        //cancellazione delle maglie nel carrello
        $query = "DELETE FROM maglia_in_carrello WHERE email=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        if(!($stmt->affected_rows>0)){
            return true;
        }
        return false;
    }

    public function addToCart($idMaglia, $email, $quantità, $nome, $numero, $costo) {
        $query = "INSERT INTO maglia_in_carrello (idMaglia, email, quantità, nomePersonalizzato, numeroPersonalizzato, costo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('isisid', $idMaglia, $email, $quantità, $nome, $numero, $costo);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function removeFromCart($idRiga){
        $query = "DELETE FROM maglia_in_carrello WHERE idRiga = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idRiga);
        $stmt->execute();

        return $stmt->affected_rows;
    }
}
?>
