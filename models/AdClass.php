<?php

require_once 'Database.php';

class Ad  {
  private $region;
  private $city;
  private $brand;
  private $model;
  private $engine;
  private $mileage;
  private $owners;
  private $db;
  private $table = 'ads';

  public function __construct(
    $region,
    $city,
    $brand,
    $model,
    $engine,
    $mileage,
    $owners
  ) {
    $this->region = $region;
    $this->city = $city;
    $this->brand = $brand;
    $this->model = $model;
    $this->engine = $engine;
    $this->mileage = $mileage;
    $this->owners = $owners;
    $this->db = new Database();
  }

  public function create() {
    $stmt = $this->db->prepare("INSERT INTO $this->table ( region, city, brand, model, engine, mileage, owners) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$this->region, $this->city, $this->brand, $this->model, $this->engine, $$this->mileage, $this->owners]);
    return $this->db->lastInsertId();
  }

  public function getAll() {
    $stmt = $this->db->prepare("SELECT * FROM $this->table ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getByUserId($user_id) {
    $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getPhotosByAdId($ad_id) {
    $stmt = $this->db->prepare("SELECT * FROM photos WHERE ad_id = ?");
    $stmt->execute([$ad_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function search($page, $records_per_page)
  {
    $offset = ($page - 1) * $records_per_page;
    $sql = "SELECT ads.*, MIN(photos.path) AS image FROM ads LEFT JOIN photos ON ads.id = photos.ad_id WHERE 1=1";

    $params = [];

    if (!empty($this->region)) {
      $sql .= " AND region LIKE ?";
      $params[] = "%{$this->region}%";
    }
    if (!empty($this->city)) {
      $sql .= " AND city LIKE ?";
      $params[] = "%{$this->city}%";
    }
    if (!empty($this->brand)) {
      $sql .= " AND brand LIKE ?";
      $params[] = "%{$this->brand}%";
    }
    if (!empty($this->model)) {
      $sql .= " AND model LIKE ?";
      $params[] = "%{$this->model}%";
    }
    if (!empty($this->engine)) {
      $sql .= " AND engine = ?";
      $params[] = $this->engine;
    }
    if (!empty($this->mileage)) {
      $sql .= " AND mileage <= ?";
      $params[] = $this->mileage;
    }
    if (!empty($this->owners)) {
      $sql .= " AND owners <= ?";
      $params[] = $this->owners;
    }
    $stmt = $this->db->query($sql, $params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}
?>