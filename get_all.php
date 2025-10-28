<?php
$host = "127.0.1.23";
$port = "5432";
$dbname = "mydatabase";
$user = "postgres1";
$password = "kSOFQ88UW4eISRBOINpqY2ELCNRGrin3";

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);

if (!$conn) {
    die("Ошибка подключения к PostgreSQL");
}

pg_set_client_encoding($conn, "UTF8");

// Получаем все 14 дней
$query = "SELECT holiday_date, text FROM tab ORDER BY holiday_date LIMIT 14;";
$result = pg_query($conn, $query);

$holidays = [];
while ($row = pg_fetch_assoc($result)) {
    $holidays[] = $row;
}

pg_close($conn);

// Отдаём JSON
header('Content-Type: application/json');
echo json_encode($holidays, JSON_UNESCAPED_UNICODE);
?>
