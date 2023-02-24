<?php
// Подключаемся к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=testdb', 'root', 'root');

// Получение параметров запроса
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = isset($_GET['records_per_page']) ? (int)$_GET['records_per_page'] : 10;
$region = isset($_GET['region']) ? $_GET['region'] : '';
$city = isset($_GET['city']) ? $_GET['city'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$model = isset($_GET['model']) ? $_GET['model'] : '';
$engine = isset($_GET['engine']) ? $_GET['engine'] : '';
$mileage = isset($_GET['mileage']) ? $_GET['mileage'] : '';
$owners = isset($_GET['owners']) ? $_GET['owners'] : '';

// Вычисляем смещение для запроса
$offset = ($page - 1) * $records_per_page;

// Формирование запроса с учетом фильтров
$sql = "SELECT ads.*, MIN(photos.path) AS image FROM ads LEFT JOIN photos ON ads.id = photos.ad_id WHERE 1=1";;
if (!empty($region)) {
$sql .= " AND region LIKE :region";
}
if (!empty($city)) {
$sql .= " AND city LIKE :city";
}
if (!empty($brand)) {
$sql .= " AND brand LIKE :brand";
}
if (!empty($model)) {
$sql .= " AND model LIKE :model";
}
if (!empty($engine)) {
$sql .= " AND engine = :engine";
}
if (!empty($mileage)) {
$sql .= " AND mileage = :mileage";
}
if (!empty($owners)) {
$sql .= " AND owners = :owners";
}
$sql .= " GROUP BY ads.id ORDER BY ads.created_at DESC LIMIT $records_per_page OFFSET $offset";

$stmt = $pdo->prepare($sql);

if (!empty($region)) {
$stmt->bindParam(':region', $region, PDO::PARAM_STR);
}
if (!empty($city)) {
$stmt->bindParam(':city', $city, PDO::PARAM_STR);
}
if (!empty($brand)) {
$stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
}
if (!empty($model)) {
$stmt->bindParam(':model', $model, PDO::PARAM_STR);
}
if (!empty($engine)) {
$stmt->bindParam(':engine', $engine, PDO::PARAM_STR);
}
if (!empty($mileage)) {
$stmt->bindParam(':mileage', $mileage, PDO::PARAM_STR);
}
if (!empty($owners)) {
$stmt->bindParam(':owners', $owners, PDO::PARAM_STR);
}

// Execute the prepared statement
$stmt->execute();

// Fetch the results as an array of associative arrays
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
$sql_count = "SELECT count(*) FROM ads WHERE 1=1";
if (!empty($region)) {
    $sql_count .= " AND region LIKE :region";
}
if (!empty($city)) {
    $sql_count .= " AND city LIKE :city";
}
if (!empty($brand)) {
    $sql_count .= " AND brand LIKE :brand";
}
if (!empty($model)) {
    $sql_count .= " AND model LIKE :model";
}
if (!empty($engine)) {
    $sql_count .= " AND engine = :engine";
}
if (!empty($mileage)) {
    $sql_count .= " AND mileage = :mileage";
}
if (!empty($owners)) {
    $sql_count .= " AND owners = :owners";
}

$stmt_count = $pdo->prepare($sql_count);

if (!empty($region)) {
    $stmt_count->bindParam(':region', $region, PDO::PARAM_STR);
}
if (!empty($city)) {
    $stmt_count->bindParam(':city', $city, PDO::PARAM_STR);
}
if (!empty($brand)) {
    $stmt_count->bindParam(':brand', $brand, PDO::PARAM_STR);
}
if (!empty($model)) {
    $stmt_count->bindParam(':model', $model, PDO::PARAM_STR);
}
if (!empty($engine)) {
    $stmt_count->bindParam(':engine', $engine, PDO::PARAM_STR);
}
if (!empty($mileage)) {
    $stmt_count->bindParam(':mileage', $mileage, PDO::PARAM_STR);
}
if (!empty($owners)) {
    $stmt_count->bindParam(':owners', $owners, PDO::PARAM_STR);
}

// Execute the prepared statement
$stmt_count->execute();

// Fetch the result as a single value
$total_ads = $stmt_count->fetchColumn();

// Вычисляем общее количество страниц
$total_pages = ceil($total_ads / $records_per_page);
// Формируем ответ в виде ассоциативного массива
$response = array(
    'ads' => $ads,
    'total_pages' => $total_pages
);


// Возвращаем ответ в формате JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
