<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3307;dbname=solidnew", "solidnew", "solidnew123");
    echo "Connection successful!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
