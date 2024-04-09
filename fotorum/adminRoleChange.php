<?php
session_start();

// Controllo di autenticazione
if (!isset($_SESSION['nickname']) && !isset($_COOKIE['email_or_nickname'])) {
    header("Location: login.php");
    exit();
}

// Controllo di ruolo (admin)
if ($_SESSION['role'] != 3 && $_SESSION['role'] != 2) {
    // Se l'utente non è un admin, reindirizza a una pagina di accesso negato o simile
    header("Location: home.php");
    exit();
}

$nickname = isset($_SESSION['nickname']) ? $_SESSION['nickname'] : $_COOKIE['email_or_nickname'];
$nickname = htmlspecialchars($nickname);

require "connection.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Role Change</title>
    <script>
        function changeRole(accountId, newRoleId) {
            if (confirm('Sei sicuro di voler cambiare il ruolo di questo account?')) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Aggiorna la pagina dopo il cambio ruolo
                            location.reload();
                        } else {
                            alert('Si è verificato un errore durante il cambio ruolo.');
                        }
                    }
                };
                xhr.open('POST', 'adminRoleChangeControl.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('accountId=' + accountId + '&newRoleId=' + newRoleId);
            }
        }
    </script>
</head>
<body>

<form action="" method="get">
    <label for="sort">Ordina per:</label>
    <select id="sort" name="sort">
        <option value="name">Nome</option>
        <option value="surname">Cognome</option>
        <option value="nickname">Nickname</option>
        <option value="email">Email</option>
        <option value="role">Ruolo</option>
    </select>
    <button type="submit">Ordina</button>
</form>

<?php
// Query per ottenere informazioni account e ruoli
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name'; // Ordina per nome per default

$sql = "SELECT account.*, role.description AS role_description FROM account INNER JOIN role ON account.role = role.id ORDER BY $sort ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Name</th><th>Surname</th><th>Nickname</th><th>Email</th><th>Role</th><th>Action</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["surname"] . "</td>";
        echo "<td>" . $row["nickname"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["role_description"] . "</td>";
        echo "<td>";
        
        // Verifica se l'utente è admin "2"
        if ($_SESSION['role'] == 2) {
            // Query per ottenere i ruoli consentiti per l'utente con il ruolo "2"
            $allowedRoles = array(1, 4, 5);

            // Verifica se il ruolo dell'utente da modificare è consentito per l'admin "2"
            if (in_array($row["role"], $allowedRoles)) {
                echo "<select onchange=\"changeRole(" . $row["id"] . ", this.value)\">";

                // Aggiungi solo i ruoli consentiti per l'utente con il ruolo "2"
                foreach ($allowedRoles as $allowedRole) {
                    // Trova la descrizione del ruolo corrispondente all'ID
                    $roleQuery = "SELECT description FROM role WHERE id = $allowedRole";
                    $roleResult = $conn->query($roleQuery);
                    if ($roleResult->num_rows > 0) {
                        $roleRow = $roleResult->fetch_assoc();
                        echo "<option value='" . $allowedRole . "'>" . $roleRow["description"] . "</option>";
                    }
                }
                echo "</select>";
            } else {
                // Se il ruolo dell'utente non è consentito, visualizza solo il ruolo corrente
                echo $row["role_description"];
            }
        } elseif ($_SESSION['role'] == 3) {
            // Se l'utente è admin "3", visualizza il menu a discesa con tutti i ruoli
            echo "<select onchange=\"changeRole(" . $row["id"] . ", this.value)\">";
            // Query per ottenere i ruoli dalla tabella role
            $roleQuery = "SELECT * FROM role";
            $roleResult = $conn->query($roleQuery);
            if ($roleResult->num_rows > 0) {
                while ($roleRow = $roleResult->fetch_assoc()) {
                    echo "<option value='" . $roleRow["id"] . "'";
                    // Se il ruolo corrente dell'utente corrisponde al ruolo nella tabella, seleziona questa opzione
                    if ($roleRow["id"] == $row["role"]) {
                        echo " selected";
                    }
                    echo ">" . $roleRow["description"] . "</option>";
                }
            }
            echo "</select>";
        }
        
        
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nessun risultato trovato";
}
$conn->close();
?>

<div id="menu">
    <a href="home.php">Home</a><br>
    <a href="logout.php">Logout</a><br>
</div>
</body>
</html>
