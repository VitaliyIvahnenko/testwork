<?php
class Db {
  private $pdo;

  public function __construct($host, $dbname, $user, $password) {
    try {
      $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
  }

  public function query($sql, $params = []) {
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
  }

  public function lastInsertId() {
    return $this->pdo->lastInsertId();
  }
}
?>