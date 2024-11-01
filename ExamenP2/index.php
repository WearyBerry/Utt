<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bienesraices";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Insertar datos en la tabla `propiedadesVendidas`
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vender'])) {
    $propiedad_id = $_POST['propiedad_id'];
    $comprador = $_POST['comprador'];

    $stmt = $conn->prepare("INSERT INTO propiedadesVendidas (propiedad_id, comprador) VALUES (?, ?)");
    $stmt->bind_param("is", $propiedad_id, $comprador);

    if ($stmt->execute()) {
        header("Location: index.php?success=1");
        exit();
    } else {
        echo "Error al registrar la venta: " . $stmt->error;
    }
    $stmt->close();
}

// Obtener todas las propiedades
$sql = "SELECT * FROM propiedades";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Obtener todas las propiedades vendidas
$soldPropertiesSql = "SELECT pv.comprador, p.titulo, p.precio 
                      FROM propiedadesVendidas pv 
                      JOIN propiedades p ON pv.propiedad_id = p.id";
$soldResult = $conn->query($soldPropertiesSql);

if (!$soldResult) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta de Propiedades</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #2c1a4b; /* Color de fondo morado oscuro */
            color: #ffffff; /* Color del texto blanco */
            margin: 0;
        }
        .navbar {
            background-color: #3b2c6e; /* Color de la barra de navegación morado */
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #ffffff; /* Color del texto de la barra de navegación */
        }
        .navbar-logo {
            font-size: 24px;
            font-weight: bold;
        }
        .navbar-logo span {
            color: #d4a5ff; /* Color del texto en la parte del logo */
        }
        .navbar-links {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
        }
        .navbar-links a {
            color: #ffffff; /* Color del texto de los enlaces */
            text-decoration: none;
            font-size: 16px;
        }
        .navbar-links a:hover {
            color: #d4a5ff; /* Color del texto de los enlaces al pasar el mouse */
        }
        .navbar-icon {
            font-size: 20px;
            margin-left: auto;
        }
        .container { 
            width: 600px; 
            margin: 50px auto; 
            padding: 20px; 
            background-color: #4e3682; /* Color de fondo del contenedor */
            border-radius: 5px; 
            box-shadow: 0px 0px 10px rgba(0,0,0,0.5); 
        }
        h1 { 
            text-align: center; 
            color: #d4a5ff; /* Color del título */
        }
        form { 
            display: flex; 
            flex-direction: column; 
        }
        label { 
            margin: 10px 0 5px; 
            font-weight: bold; 
            color: #e5e0f9; /* Color de las etiquetas */
        }
        select, input[type="text"] { 
            padding: 8px; 
            border: 1px solid #7b5f9e; /* Borde de los campos de entrada */
            border-radius: 4px; 
            background-color: #5a4b83; /* Color de fondo de los campos de entrada */
            color: #ffffff; /* Color del texto en los campos de entrada */
        }
        button { 
            margin-top: 20px; 
            padding: 10px; 
            background-color: #a65eae; /* Color de fondo del botón */
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        button:hover { 
            background-color: #9c55a6; /* Color de fondo del botón al pasar el mouse */
        }
        /* Estilo para la sección de propiedades vendidas */
        .sold-properties {
            margin-top: 30px;
            background-color: #5a4b83; /* Color de fondo para la tabla */
            padding: 15px;
            border-radius: 5px;
        }
        .sold-properties table {
            width: 100%;
            border-collapse: collapse;
        }
        .sold-properties th, .sold-properties td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #7b5f9e;
        }
        .sold-properties th {
            background-color: #4e3682; /* Color de fondo para el encabezado de la tabla */
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <div class="navbar">
        <div class="navbar-logo">BIENES<span>RAICES</span></div>
        <ul class="navbar-links">
            <li><a href="#">Nosotros</a></li>
            <li><a href="#">Anuncios</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
        <div class="navbar-icon">🌙</div> <!-- Icono de luna -->
    </div>

    <!-- Contenido principal -->
    <div class="container">
        <h1>Registrar Venta de Propiedad</h1>
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">¡Propiedad vendida registrada exitosamente!</p>
        <?php endif; ?>
        <form method="POST" action="index.php">
            <label for="propiedad_id">Selecciona la Propiedad Vendida:</label>
            <select name="propiedad_id" id="propiedad_id" required>
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['titulo'] . " - $" . number_format($row['precio'], 2) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay propiedades disponibles</option>';
                }
                ?>
            </select>

            <label for="comprador">Nombre del Comprador:</label>
            <input type="text" name="comprador" id="comprador" required>

            <button type="submit" name="vender">Registrar Venta</button>
        </form>

        <!-- Sección de propiedades vendidas -->
        <div class="sold-properties">
            <h2>Propiedades Vendidas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre del Comprador</th>
                        <th>Propiedad Comprada</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($soldRow = $soldResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $soldRow['comprador']; ?></td>
                            <td><?php echo $soldRow['titulo']; ?></td>
                            <td>$<?php echo number_format($soldRow['precio'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
