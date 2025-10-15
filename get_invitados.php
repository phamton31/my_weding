<?php
header('Content-Type: application/json');
require 'config_db.php';

$result = pg_query($dbconn, "SELECT * FROM invitados ORDER BY codigo, id");
$data = [];
while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode(["success" => true, "data" => $data]);
