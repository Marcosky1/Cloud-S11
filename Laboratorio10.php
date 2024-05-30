<?php
// db_connect.php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Funciones CRUD

// Crear Usuario
function createUser($conn, $username, $password, $email, $createdBy) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("CALL CreateUser(:username, :passwordHash, :email, :createdBy)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':passwordHash', $passwordHash);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':createdBy', $createdBy);

    return $stmt->execute();
}

// Leer Usuario
function readUser($conn, $userID) {
    $stmt = $conn->prepare("CALL ReadUser(:userID)");
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Actualizar Usuario
function updateUser($conn, $userID, $username, $password, $email, $modifiedBy) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("CALL UpdateUser(:userID, :username, :passwordHash, :email, :modifiedBy)");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':passwordHash', $passwordHash);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':modifiedBy', $modifiedBy);

    return $stmt->execute();
}

// Eliminar Usuario
function deleteUser($conn, $userID) {
    $stmt = $conn->prepare("CALL DeleteUser(:userID)");
    $stmt->bindParam(':userID', $userID);

    return $stmt->execute();
}

// Crear Juego1
function createGame1($conn, $userID, $score, $createdBy) {
    $stmt = $conn->prepare("CALL CreateGame1(:userID, :score, :createdBy)");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':score', $score);
    $stmt->bindParam(':createdBy', $createdBy);

    return $stmt->execute();
}

// Leer Juego1
function readGame1($conn, $gameID) {
    $stmt = $conn->prepare("CALL ReadGame1(:gameID)");
    $stmt->bindParam(':gameID', $gameID);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Actualizar Juego1
function updateGame1($conn, $gameID, $score, $modifiedBy) {
    $stmt = $conn->prepare("CALL UpdateGame1(:gameID, :score, :modifiedBy)");
    $stmt->bindParam(':gameID', $gameID);
    $stmt->bindParam(':score', $score);
    $stmt->bindParam(':modifiedBy', $modifiedBy);

    return $stmt->execute();
}

// Eliminar Juego1
function deleteGame1($conn, $gameID) {
    $stmt = $conn->prepare("CALL DeleteGame1(:gameID)");
    $stmt->bindParam(':gameID', $gameID);

    return $stmt->execute();
}

// Funciones CRUD para Game2 y Game3 seguirán el mismo patrón

// Ejemplo de uso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    switch ($action) {
        case 'createUser':
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $createdBy = $_POST['created_by'];
            createUser($conn, $username, $password, $email, $createdBy);
            break;
        case 'readUser':
            $userID = $_POST['user_id'];
            $user = readUser($conn, $userID);
            echo json_encode($user);
            break;
        case 'updateUser':
            $userID = $_POST['user_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $modifiedBy = $_POST['modified_by'];
            updateUser($conn, $userID, $username, $password, $email, $modifiedBy);
            break;
        case 'deleteUser':
            $userID = $_POST['user_id'];
            deleteUser($conn, $userID);
            break;
        // Add cases for Game1, Game2, Game3 CRUD operations
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laboratorio 10</title>
</head>
<body>
    <h1>Create User</h1>
    <form action="Laboratorio10.php" method="post">
        <input type="hidden" name="action" value="createUser">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password"><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br>
        <label for="created_by">Created By:</label>
        <input type="text" name="created_by" id="created_by"><br>
        <input type="submit" value="Create User">
    </form>

    <h1>Read User</h1>
    <form action="Laboratorio10.php" method="post">
        <input type="hidden" name="action" value="readUser">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" id="user_id"><br>
        <input type="submit" value="Read User">
    </form>

    <!-- Add forms for updateUser, deleteUser, and CRUD operations for Game1, Game2, Game3 -->

</body>
</html>