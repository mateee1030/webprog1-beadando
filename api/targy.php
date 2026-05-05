<?php
require 'db.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $result = mysqli_query($conn, "SELECT * FROM targy ORDER BY id");
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);

} elseif ($method === 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    $nev = mysqli_real_escape_string($conn, $d['nev']);
    $kat = mysqli_real_escape_string($conn, $d['kategoria']);
    mysqli_query($conn, "INSERT INTO targy (nev, kategoria) VALUES ('$nev', '$kat')");
    echo json_encode(['id' => mysqli_insert_id($conn)]);

} elseif ($method === 'PUT') {
    $d = json_decode(file_get_contents('php://input'), true);
    $nev = mysqli_real_escape_string($conn, $d['nev']);
    $kat = mysqli_real_escape_string($conn, $d['kategoria']);
    $id = (int)$d['id'];
    mysqli_query($conn, "UPDATE targy SET nev='$nev', kategoria='$kat' WHERE id=$id");
    echo json_encode(['ok' => true]);

} elseif ($method === 'DELETE') {
    $d = json_decode(file_get_contents('php://input'), true);
    $id = (int)$d['id'];
    mysqli_query($conn, "DELETE FROM targy WHERE id=$id");
    echo json_encode(['ok' => true]);
}