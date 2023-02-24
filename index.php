<!DOCTYPE html>
<?php session_start();?>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Сайт объявлений по продаже автомобилей</title>
</head>
<body>
  <div class="container mt-3">
    <h1>Сайт объявлений по продаже автомобилей</h1>

    <form method="POST" action="autorisation.php">
      <div class="form-row justify-content-end">
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <!-- если пользователь авторизован, показываем его email и кнопку выхода -->
        <div class="col-md-3 mb-3">
          <p>Вы вошли как: <?php echo $_SESSION['email']; ?></p>
        </div>
        <div class="col-md-2 mb-3">
          <button type="submit" class="btn btn-primary" name="logout">Выход</button>
        </div>
        <?php else: ?>
        <!-- если пользователь не авторизован, показываем поля для ввода и кнопки входа и регистрации -->
        <div class="col-md-2 mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="Введите email" required>
        </div>
        <div class="col-md-2 mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль" required>
        </div>
        <div class="col-md-1 mb-3">
          <button type="submit" class="btn btn-primary" name="login">Войти</button>
          </div>
        <div class="col-md-2 mb-3">
          <button type="submit" class="btn btn-primary" name="register">Регистрация</button>
        </div>
        <?php endif; ?>
      </div>
    </form>

    <hr>

    <!-- Форма для публикации объявления -->
      <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
      <form method="POST" action="add.php" enctype="multipart/form-data">
        <div class="form-group">
          <label for="region">Область</label>
          <select class="form-control col-md-4" id="region" name="region">
            <option value="">Выберите область</option>
            <option value="region1">Область 1</option>
            <option value="region2">Область 2</option>
            <option value="region3">Область 3</option>
          </select>
        </div>
        <div class="form-group">
          <label for="city">Город</label>
          <input type="text" class="form-control col-md-4" id="city" name="city" placeholder="Введите город">
        </div>
        <div class="form-group">
          <label for="brand">Марка</label>
          <input type="text" class="form-control col-md-4" id="brand" name="brand" placeholder="Введите марку автомобиля">
        </div>
        <div class="form-group">
          <label for="model">Модель</label>
          <input type="text" class="form-control col-md-4" id="model" name="model" placeholder="Введите модель автомобиля">
        </div>
        <div class="form-group">
          <label for="engine">Объем двигателя</label>
          <input type="text" class="form-control col-md-4" id="engine" name="engine" placeholder="Введите объем двигателя">
        </div>
        <div class="form-group">
          <label for="mileage">Пробег</label>
          <input type="text" class="form-control col-md-4" id="mileage" name="mileage" placeholder="Введите текущий пробег автомобиля">
        </div>
        <div class="form-group">
          <label for="number_owners">количество хозяев</label>
          <input type="text" class="form-control col-md-4" id="number_owners" name="number_owners" placeholder="Введите количество хозяев автомобиля">
        </div>
        <div class="form-group">
          <label for="photos">Фото</label>
          <input type="file" class="form-control-file" id="photos" name="photos[]" multiple>
        </div>
        <button type="submit" class="btn btn-primary" name="publish">Опубликовать</button>
        </form>
        <?php else: ?>

          <!-- Форма для фильтров объявления -->
          <form method="GET" action="">
        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="search">Марка автомобиля:</label>
            <input type="text" class="form-control" id="brand" name="brand" placeholder="Введите марку">
          </div>
          <div class="col-md-3 mb-3">
            <label for="model">Модель автомобиля:</label>
            <input type="text" class="form-control" id="model" name="model" placeholder="Введите модель">
          </div>
          <div class="col-md-2 mb-3">
            <label for="volume">Объем двигателя:</label>
            <input type="text" class="form-control" id="engine" name="engine" placeholder="Введите объем">
          </div>
          <div class="col-md-2 mb-3">
            <label for="owners">Кол-во хозяев:</label>
            <input type="text" class="form-control" id="owners" name="owners" placeholder="Введите кол-во">
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="city">Город:</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Введите город">
          </div>
          <div class="col-md-2 mb-3">
            <label for="mileage">Пробег:</label>
            <input type="text" class="form-control" id="mileage" name="mileage" placeholder="Введите пробег">
          </div>
          <div class="col-md-3 mb-3">
            <label for="region">Область:</label>
            <select class="form-control" id="region" name="region">
              <option value="">Выберите область</option>
              <option value="region1">Область 1</option>
              <option value="region2">Область 2</option>
              <option value="region3">Область 3</option>
            </select>
          </div>
        </div>
      </form>
    <div class="container-fluid mt-4">

      <!-- Отображение списка объявлений -->
      <div id="ads-list" ></div>

<!-- Постраничная навигация -->
      <nav aria-label="Page navigation">
        <ul class="pagination" id="pagination">
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
          </li>
          <li class="page-item active">
            <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">2</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">3</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">4</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">5</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">Next</a>
          </li>
        </ul>
      </nav>
    </div>

        <?php endif; ?>
  </div>
  <hr>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Подключаем CSS фреймворк, Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script src="pagination.js"></script>
</body>
</html>