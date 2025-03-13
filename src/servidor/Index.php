<?php
$servername = "sql303.infinityfree.com";
$username = "if0_38447659";
$password = "kxditgUoc3";
$dbname = "if0_38447659_servidor";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa con la base de datos.<br>";

// Insertar datos desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $correo = $_POST['correo'];

    // Validar que los campos no estén vacíos
    if (!empty($nombre) && !empty($numero) && !empty($correo)) {
        // Declaración preparada para insertar datos
        $stmt = $conn->prepare("INSERT INTO tabla_usuarios (nombre, numero, correo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $numero, $correo);

        if ($stmt->execute()) {
            echo "Datos insertados correctamente.";
        } else {
            echo "Error al insertar datos: " . $stmt->error;
        }

        // Cerrar la declaración preparada
        $stmt->close();
    } else {
        echo "Por favor, completa todos los campos.";
    }
}

// Cerrar la conexión
$conn->close();
?>
