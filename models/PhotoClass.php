<?php

class Photo
{
  private $pdo;

  public function __construct(Database $database)
  {
    $this->pdo = $database->getPdo();
  }

  public function save(int $ad_id, string $path)
  {
    $stmt = $this->pdo->prepare('INSERT INTO photos (ad_id, path) VALUES (?, ?)');
    return $stmt->execute([$ad_id, $path]);
  }
}
?>