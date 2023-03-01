<?php
require_once 'config.php';
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Ad.php';
require_once 'classes/Photo.php';

session_start();

class AdPublisher {
  private $db;
  private $user;
  private $ad;
  private $photo;

  public function __construct() {
    $this->db = new Database();
    $this->user = new User($this->db);
    $this->photo = new Photo($this->db);
    $this->ad = new Ad($this->db);
  }

  public function publishAd() {
    // Получаем данные из формы
    $region = filter_input(INPUT_POST, 'region', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $brand = filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_STRING);
    $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
    $engine = filter_input(INPUT_POST, 'engine', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $mileage = filter_input(INPUT_POST, 'mileage', FILTER_SANITIZE_NUMBER_INT);
    $number_owners = filter_input(INPUT_POST, 'number_owners', FILTER_SANITIZE_NUMBER_INT);
    $files = $_FILES['photos'];

    // Проверяем, что файлы были загружены
    if (!empty($files)) {
      // Массив допустимых расширений файлов
      $allowed_extensions = array('png', 'jpeg', 'jpg');
      // Обходим массив загруженных файлов
      foreach ($files['name'] as $key => $value) {
        // Получаем расширение текущего файла
        $file_ext = strtolower(pathinfo($files['name'][$key], PATHINFO_EXTENSION));
        // Проверяем, что расширение файла соответствует допустимым расширениям
        if (!in_array($file_ext, $allowed_extensions)) {
          // Если расширение недопустимо, вы можете показать сообщение об ошибке
          die("Недопустимый формат файла: " . $files['name'][$key]);
        }
      }
    }

    $user_id = $_SESSION['userid'];

    $count = $this->ad->getCountByUserId($user_id);

    if ($count >= 3) {
      echo "Вы достигли лимита в 3 опубликованных объявления";
    }
    else {


      $ad_id->create($region, $city, $brand, $model, $engine, $mileage, $number_owners);

      $photo_paths = [];
      if (isset($_FILES['photos'])) {
        // Перебираем все загруженные файлы
        foreach ($files['name'] as $key => $name) {
          $tmp_name = $files['tmp_name'][$key];
          $error = $files['error'][$key];

          if ($error == UPLOAD_ERR_OK && is_uploaded_file($tmp_name)) {
            $filename = basename($name);
            $path = "uploads/$filename";
            if (move_uploaded_file($tmp_name, $path)) {
              $photo_paths[] = $path;
            }
          }
        }
      }

      foreach ($photo_paths as $path) {
        $this->photo->save($ad_id, $path);
      }
    }

    header('Location: index.php');
  }
}

if (isset($_POST['publish'])) {
  $publisher = new AdPublisher();
  $publisher->publishAd();
}
?>
