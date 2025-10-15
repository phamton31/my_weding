<?php
header('Content-Type: application/json');
require 'config_db.php';

$action = $_POST['action'] ?? '';

switch($action) {

    case 'agregar':
        $nombres = $_POST['nombres'] ?? [];
        if (!$nombres) {
            echo json_encode(["success" => false, "error" => "No se enviaron nombres."]);
            exit;
        }

        $codigo = uniqid('INV_');
        foreach ($nombres as $nombre) {
            $nombre = trim($nombre);
            if ($nombre) {
                $query = "INSERT INTO invitados (codigo, nombre) VALUES ($1, $2)";
                pg_query_params($dbconn, $query, [$codigo, $nombre]);
            }
        }

        echo json_encode(["success" => true, "codigo" => $codigo]);
        break;

    case 'editar':
        $codigo = $_POST['codigo'] ?? '';
        $nombres = $_POST['nombres'] ?? [];
        $asistencia = $_POST['asistencia'] ?? null;

        if (!$codigo || !$nombres) {
            echo json_encode(["success" => false, "error" => "Faltan datos para editar."]);
            exit;
        }

        $query = "SELECT id FROM invitados WHERE codigo = $1 ORDER BY id";
        $result = pg_query_params($dbconn, $query, [$codigo]);

        $count = 0;
        while ($row = pg_fetch_assoc($result)) {
            if (isset($nombres[$count])) {
                $update = "UPDATE invitados SET nombre=$1, asistencia=$2 WHERE id=$3";
                pg_query_params($dbconn, $update, [$nombres[$count], $asistencia, $row['id']]);
                $count++;
            }
        }

        echo json_encode(["success" => true]);
        break;

    case 'eliminar':
        $codigo = $_POST['codigo'] ?? '';
        if (!$codigo) {
            echo json_encode(["success" => false, "error" => "Falta el código para eliminar."]);
            exit;
        }

        $delete = "DELETE FROM invitados WHERE codigo = $1";
        pg_query_params($dbconn, $delete, [$codigo]);

        echo json_encode(["success" => true]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida."]);
        break;
}
