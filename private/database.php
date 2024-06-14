<?php

namespace ADEJ1R;

class Database {
    private $pdo;
    private $error;

    private $table = "szindarabok";

    public function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;


        try {
            $this->pdo = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            die("Adatbázis kapcsolódási hiba: " . $this->error);
        }
    }

    public function getAllRecords() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
            $records = $stmt->fetchAll();
            if ($records) {
                return array_map(function($record) {
                    return array_filter($record, function($key) {
                        return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY);
                }, $records);
            } else {
                return [];
            }
        } catch (\PDOException $e) {
            return [
                "message" => ['message' => "Adatbázis hiba: " . $e->getMessage()],
                "status" => 500,
            ];
        }
    }
    public function getSingleRecord($index) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} where id = ?");
            $stmt->execute([$index]);
            $data = $stmt->fetch();

            if ($data) {
                // Csak az alfanumerikus kulcsok megtartása
                return array_filter($data, function($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);
            } else {
                return null;
            }

        } catch (\PDOException $e) {
            return [
                "message" => ['message' => "Adatbázis hiba: " . $e->getMessage()],
                "status" => 500,
            ];
        }
    }


    public function insertRecord($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));

        try {
            $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
            $stmt->execute(array_values($data));
            return $this->getSingleRecord($this->pdo->lastInsertId());
        } catch (\PDOException $e) {
            return [
                "message" => ['message' => "Adatbázis hiba: " . $e->getMessage()],
                "status" => 500,
            ];
        }
    }

    public function updateRecord($id, $data) {

        $rowExists = $this->rowExists($id);
        if (is_array($rowExists)) {
            return $rowExists;
        }
        if ($rowExists === false) {
            return [
                "message" => ['message' => "A frissíteni kívánt rekord nem létezik az adatbázisban"],
                "status" => 404,
            ];
        }

        $columns = implode(" = ?, ", array_keys($data)) . " = ?";

        try {
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $columns WHERE id = ?");
            $stmt->execute(array_merge(array_values($data), [$id]));
            if ($stmt->rowCount() === 0) {
                return [
                    "message" => ['message' => "Nem történt módosítás."],
                    "status" => 200,
                ];
            }
            return [];
        } catch (\PDOException $e) {
            return [
                "message" => ['message' => "Adatbázis hiba: " . $e->getMessage()],
                "status" => 500,
            ];
        }
    }

    public function rowExists($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT 1 FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetchColumn() !== false;
        } catch (\PDOException $e) {
            return [
                "message" => ['message' => "Adatbázis hiba: " . $e->getMessage()],
                "status" => 500,
            ];
        }
    }

    public function deleteRecord($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() === 0) {
                return [
                    "message" => ['message' => "Nincs ilyen rekord"],
                    "status" => 404,
                ];
            }  else {
                return [
                    "message" => ['message' => "Deleted"],
                    "status" => 200,
                ];
            }
        } catch (\PDOException $e) {
            return [
                "message" => ['message' => "Adatbázis hiba: " . $e->getMessage()],
                "status" => 500,
            ];
        }
    }

}

