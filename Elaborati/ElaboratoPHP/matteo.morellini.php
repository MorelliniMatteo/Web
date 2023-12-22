<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "giugno";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

function isNumeroPresente($numero, $conn)
{
    $query = "SELECT COUNT(*) as count FROM insiemi WHERE valore = $numero";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

$A = $_GET['A'] ?? null;
$B = $_GET['B'] ?? null;
$O = $_GET['O'] ?? null;

if (!is_numeric($A) || !is_numeric($B) || $A <= 0 || $B <= 0 || !isNumeroPresente($A, $conn) || !isNumeroPresente($B, $conn) || ($O !== 'i' && $O !== 'u')) {
    echo "Parametri non validi o non presenti nel database o operazione non supportata.";
} else {
    $queryA = "SELECT valore FROM insiemi WHERE insieme = $A";
    $resultA = $conn->query($queryA);
    $insiemeA = [];
    while ($rowA = $resultA->fetch_assoc()) {
        $insiemeA[] = $rowA['valore'];
    }

    $queryB = "SELECT valore FROM insiemi WHERE insieme = $B";
    $resultB = $conn->query($queryB);
    $insiemeB = [];
    while ($rowB = $resultB->fetch_assoc()) {
        $insiemeB[] = $rowB['valore'];
    }

    if ($O === 'u') {
        $nuovoInsieme = array_unique(array_merge($insiemeA, $insiemeB));
    } elseif ($O === 'i') {
        $nuovoInsieme = array_intersect($insiemeA, $insiemeB);
    }

    if (!empty($nuovoInsieme)) {
        // Trova il massimo ID attualmente presente nel database e aggiungi 1 per ottenere il nuovo ID
        $maxIdQuery = "SELECT MAX(insieme) AS max_insieme FROM insiemi";
        $resultMaxId = $conn->query($maxIdQuery);
        $rowMaxId = $resultMaxId->fetch_assoc();
        $newId = $rowMaxId['max_insieme'] + 1;

        $insertQuery = "INSERT INTO insiemi (valore, insieme) VALUES ";
        foreach ($nuovoInsieme as $valore) {
            $insertQuery .= "($valore, $newId),";
        }
        $insertQuery = rtrim($insertQuery, ',');

        if ($conn->query($insertQuery) === TRUE) {
            echo "Operazione completata con successo!";
        } else {
            echo "Errore nell'inserimento dei dati: " . $conn->error;
        }
    } else {
        echo "Nessun dato da inserire.";
    }
}

$conn->close();
?>
