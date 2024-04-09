<?php
use \Firebase\JWT\JWT;

// Funzione per verificare il token JWT
function verifyToken($token) {
    try {
        $decoded = JWT::decode($token, SECRET_KEY, array('HS256'));
        return $decoded;
    } catch (Exception $e) {
        return null;
    }
}

// Connessione al database
$connessione = new mysqli("localhost","root","","fotorum");
if($connessione->connect_errno)
{
    echo("Connessione fallita: ".$connessione->connect_error.".");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/fotorum/api/login') {
    // Estrai l'nickname e la password dal corpo della richiesta
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    // Recupera l'utente dal database
    $query = "SELECT * FROM Account WHERE nickname = ?";
    $stmt = $connessione->prepare($query);
    $stmt->bind_param('s', $nickname);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Calcola l'hash della password fornita
        $hashed_password = hash('sha3-512', $user['salt'] . $password);

        // Verifica se l'hash della password fornita corrisponde a quello nel database
        if ($hashed_password === $user['password']) {
            // Se le credenziali sono corrette, genera un token JWT
            require 'tokenJWT.php';
            $token = generateToken($user);
            //inserisci il token nella sessione
                //$_SESSION['token'] = $token;
            // Restituisci il token al client
            http_response_code(200);
            // Restituisci il token al client
            echo json_encode(array('token' => $token));
        } else {
            // Se le credenziali non sono corrette, restituisci un errore
            http_response_code(401);
            echo json_encode(array('message' => 'nickname o password non corretti.'));
        }
    } else {
        // Se l'utente non esiste, restituisci un errore
        http_response_code(401);
        echo json_encode(array('message' => 'nickname o password non corretti.'));
    }

    exit();
}

if(isset($_REQUEST['tabella'])){
    $tabella = $_REQUEST['tabella'];
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        if(isset($_REQUEST['info'])){
            $info = $_REQUEST['info'];
            if ($info == 'post') {
                // Se il parametro "info" è "post", allora restituisci i post relativi all'account
                if(isset($_REQUEST['post_id'])) {
                    // Se è specificato un post_id, restituisci solo quel post
                    $post_id = $_REQUEST['post_id'];
                    $query = "SELECT * FROM Post WHERE account_id = ? AND id = ?";
                    $stmt = $connessione->prepare($query);
                    $stmt->bind_param("ii", $id, $post_id);
                } else {
                    // Altrimenti, restituisci tutti i post dell'account
                    $query = "SELECT * FROM Post WHERE account_id = ?";
                    $stmt = $connessione->prepare($query);
                    $stmt->bind_param("i", $id);
                }
            } elseif ($info == 'sex') {
                // Query per ottenere il genere dell'account
                $query = "SELECT a.*, s.sex FROM $tabella a JOIN Sex s ON a.sex = s.id WHERE a.id = ?";
                $stmt = $connessione->prepare($query);
                $stmt->bind_param("i", $id);
            } else {
                $query = "SELECT * FROM $tabella WHERE id = ?";
                $stmt = $connessione->prepare($query);
                $stmt->bind_param("i", $id);
            }
        } else {
            $query = "SELECT * FROM $tabella WHERE id = ?";
            $stmt = $connessione->prepare($query);
            $stmt->bind_param("i", $id);
        }
    } else {
        $query = "SELECT * FROM $tabella";
        $stmt = $connessione->prepare($query);
    }
    $stmt->execute();
    $risultato = $stmt->get_result();
    if ($risultato) {
        header('Content-Type: application/json');
        echo json_encode($risultato->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);    
    } else {
        echo "Errore nella query: " . $connessione->error;
    }
} else {
echo("
<!DOCTYPE html>
<html>
    <head>
        <title>Api</title>
    </head>
    <body>
        <div>
            <h1>Api</h1>
            <form action='/fotorum/api/login' method='post'>
                <label for='nickname'>nickname:</label><br>
                <input type='text' id='nickname' name='nickname'><br>
                <label for='password'>Password:</label><br>
                <input type='password' id='password' name='password'><br>
                <input type='submit' value='Submit'>
            </form>
            <h2><a href='/fotorum/verifica.html'>verifica</a></h2>
        </div>
        <hr>
        <div style='padding-left: 20px; padding-top:10px;'>
            <h2><a href='/fotorum/api/account'>Account</a></h2>
            <h2><a href='/fotorum/api/post'>Post</a></h2>
            <h2><a href='/fotorum/api/likes'>Likes</a></h2>
            <h2><a href='/fotorum/api/comment'>Comment</a></h2>
            <h2><a href='/fotorum/index'>Home</a></h2>
        </div>
    </body>
</html>");
}
?>