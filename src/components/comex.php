<?php
header("Content-Type: application/json");
require_once "servidor.php"; // Importar la conexiÃ³n a la base de datos

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET['id'])) {
            getUserById($_GET['id']);
        } else {
            getUsers();
        }
        break;
    case 'POST':
        createUser();
        break;
    case 'PUT':
        if (!empty($_GET['id'])) {
            updateUser($_GET['id']);
        } else {
            echo json_encode(["error" => "ID requerido para actualizar usuario"]);
        }
        break;
    case 'DELETE':
        if (!empty($_GET['id'])) {
            deleteUser($_GET['id']);
        } else {
            echo json_encode(["error" => "ID requerido para eliminar usuario"]);
        }
        break;
    default:
        echo json_encode(["error" => "MÃ©todo no soportado"]);
        break;
}

// Obtener todos los usuarios
function getUsers() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($users);
}

// Obtener un usuario por ID
function getUserById($id) {
    global $conn;
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    echo json_encode($user ?: ["error" => "Usuario no encontrado"]);
}

// Crear un nuevo usuario
function createUser() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['name'], $data['email'], $data['password'])) {
        echo json_encode(["error" => "Faltan datos requeridos"]);
        return;
    }

    $password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $data['name'], $data['email'], $password_hash);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => "Usuario creado con Ã©xito"]);
    } else {
        echo json_encode(["error" => "Error al crear usuario"]);
    }
}

// Actualizar un usuario
function updateUser($id) {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['name'], $data['email'])) {
        echo json_encode(["error" => "Faltan datos requeridos"]);
        return;
    }

    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $data['name'], $data['email'], $id);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => "Usuario actualizado con Ã©xito"]);
    } else {
        echo json_encode(["error" => "Error al actualizar usuario"]);
    }
}

// Eliminar un usuario
function deleteUser($id) {
    global $conn;
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => "Usuario eliminado con Ã©xito"]);
    } else {
        echo json_encode(["error" => "Error al eliminar usuario"]);
    }
}
?>