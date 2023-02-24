<?php
// Проверяем, была ли нажата кнопка "Опубликовать"
if (isset($_POST['publish'])) {
  session_start();
  // Получаем данные из формы
  $region = $_POST['region'];
  $city = $_POST['city'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $engine = $_POST['engine'];
  $mileage = $_POST['mileage'];
  $number_owners = $_POST['number_owners'];
  $files = $_FILES['photos'];
  // Подключаемся к базе данных
  $pdo = new PDO('mysql:host=localhost;dbname=testdb', 'root', 'root');

  // Получаем ID текущего пользователя (предполагается, что пользователь уже авторизован)
  $user_id = $_SESSION['userid'];

  // Запрос к базе данных для получения количества опубликованных объявлений
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM ads WHERE user_id = ?');
  $stmt->execute([$user_id]);
  $count = $stmt->fetchColumn();

  // Если количество опубликованных объявлений больше или равно 3, выводим сообщение о лимите
  if ($count >= 3) {
    echo "Вы достигли лимита в 3 опубликованных объявления";
  }
  // Иначе, добавляем новую запись в базу данных
  else {
      $stmt = $pdo->prepare('INSERT INTO ads (user_id, region, city, brand, model, engine, mileage, owners) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
      $stmt->execute([$user_id, $region, $city, $brand, $model, $engine, $mileage, $number_owners]);

      // Получаем ID последней вставленной записи
      $ad_id = $pdo->lastInsertId();

      // Загружаем фотографии на сервер и сохраняем пути в базе данных
      $photo_paths = [];
      if (isset($_FILES['photos'])) {

        // Перебираем все загруженные файлы
        foreach ($files['name'] as $key => $name) {
          $tmp_name = $files['tmp_name'][$key];
          $error = $files['error'][$key];

          // Если файл успешно загружен, перемещаем его на сервер и сохраняем путь в массив
          if ($error == UPLOAD_ERR_OK && is_uploaded_file($tmp_name)) {
            $filename = basename($name);
            $path = "uploads/$filename";
            if (move_uploaded_file($tmp_name, $path)) {
              $photo_paths[] = $path;
            }
          }
        }
      }

      // Сохраняем пути к фотографиям в базе данных
      foreach ($photo_paths as $path) {
        $stmt = $pdo->prepare('INSERT INTO photos (ad_id, path) VALUES (?, ?)');
        $stmt->execute([$ad_id, $path]);
      }

    }
    header('Location: index.php');
  }
?>