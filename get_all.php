<?php
header('Content-Type: application/json; charset=utf-8');

// Подключение
$host = getenv('PGHOST');
$port = getenv('PGPORT');
$dbname = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require";
$conn = pg_connect($conn_string);

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Ошибка подключения к базе"]);
    exit;
}

pg_set_client_encoding($conn, "UTF8");

$query = "SELECT holiday_date, text FROM tab ORDER BY holiday_date";
$result = pg_query($conn, $query);

$data = [];
if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $data[] = array_map('utf8_encode', $row);
    }
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

pg_free_result($result);
pg_close($conn);
?>
