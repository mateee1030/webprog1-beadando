<?php
require 'db.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $result = mysqli_query($conn, "SELECT j.*, d.nev as diak_nev, t.nev as targy_nev 
                                   FROM jegy j 
                                   JOIN diak d ON j.diakid=d.id 
                                   JOIN targy t ON j.targyid=t.id 
                                   ORDER BY j.datum DESC LIMIT 100");
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode($data);

} elseif ($method === 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    $diakid = (int)$d['diakid'];
    $datum = mysqli_real_escape_string($conn, $d['datum']);
    $ertek = (int)$d['ertek'];
    $tipus = mysqli_real_escape_string($conn, $d['tipus']);
    $targyid = (int)$d['targyid'];
    mysqli_query($conn, "INSERT INTO jegy (diakid, datum, ertek, tipus, targyid) VALUES ($diakid, '$datum', $ertek, '$tipus', $targyid)");
    echo json_encode(['id' => mysqli_insert_id($conn)]);

} elseif ($method === 'PUT') {
    $d = json_decode(file_get_contents('php://input'), true);
    $id = (int)$d['id'];
    $diakid = (int)$d['diakid'];
    $datum = mysqli_real_escape_string($conn, $d['datum']);
    $ertek = (int)$d['ertek'];
    $tipus = mysqli_real_escape_string($conn, $d['tipus']);
    $targyid = (int)$d['targyid'];
    mysqli_query($conn, "UPDATE jegy SET diakid=$diakid, datum='$datum', ertek=$ertek, tipus='$tipus', targyid=$targyid WHERE id=$id");
    echo json_encode(['ok' => true]);

} elseif ($method === 'DELETE') {
    $d = json_decode(file_get_contents('php://input'), true);
    $id = (int)$d['id'];
    mysqli_query($conn, "DELETE FROM jegy WHERE id=$id");
    echo json_encode(['ok' => true]);
}