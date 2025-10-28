<?php
$host = getenv('PGHOST');
$port = getenv('PGPORT');
$dbname = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
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
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

pg_free_result($result);
pg_close($conn);
?>
