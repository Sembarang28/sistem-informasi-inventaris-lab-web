<?php
$conn = mysqli_connect('localhost', 'root', '', 'inventarislab');


if(mysqli_connect_errno()){
    echo "Koneksi database mysqli gagal!!! : ".mysqli_connect_error();
}

function select($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

?>