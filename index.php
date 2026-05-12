<?php
require 'conexion.php';

// --- LÓGICA DE CREACIÓN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tarea'])) {
    $nuevaTarea = [
        'descripcion' => $_POST['tarea'],
        'fecha' => new MongoDB\BSON\UTCDateTime()
    ];
    $coleccion->insertOne($nuevaTarea);
    header("Location: index.php");
    exit;
}

// --- LÓGICA DE ELIMINACIÓN ---
if (isset($_GET['eliminar'])) {
    $id = new MongoDB\BSON\ObjectId($_GET['eliminar']);
    $coleccion->deleteOne(['_id' => $id]);
    header("Location: index.php");
    exit;
}

// --- LÓGICA DE LECTURA ---
// Buscar todas las tareas
$tareas = $coleccion->find();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP + MongoDB Atlas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Mis Tareas (Prueba Sistema Distribuido)</h2>
                
                <form method="POST" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="tarea" class="form-control" placeholder="Escribe una nueva tarea..." required>
                        <button class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>

                <ul class="list-group">
                    <?php foreach ($tareas as $tarea): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <?php echo htmlspecialchars($tarea['descripcion']); ?>
                            </span>
                            <a href="index.php?eliminar=<?php echo $tarea['_id']; ?>" class="btn btn-danger btn-sm">
                                Eliminar
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <?php if (iterator_count($coleccion->find()) === 0): ?>
                    <div class="alert alert-info text-center mt-3 mb-0">
                        No hay tareas pendientes. ¡Buen trabajo!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>