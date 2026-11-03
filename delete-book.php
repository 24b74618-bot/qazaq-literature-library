
<?php
require_once __DIR__ . "/includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: books.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: books.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
$stmt->execute(["id" => $id]);

header("Location: books.php");
exit;
