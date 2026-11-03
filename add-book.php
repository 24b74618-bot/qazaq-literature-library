<?php
$pageTitle = "Кітап қосу";

require_once __DIR__ . "/includes/db.php";

$errors = [];
$title = "";
$author_id = "";
$category_id = "";
$description = "";
$published_year = "";

// Авторлар мен санаттарды алу
$authors = $pdo->query("SELECT id, name FROM authors ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

// Форманы өңдеу
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $author_id = $_POST["author_id"] ?? "";
    $category_id = $_POST["category_id"] ?? "";
    $description = trim($_POST["description"] ?? "");
    $published_year = trim($_POST["published_year"] ?? "");

    if ($title === "") {
        $errors[] = "Кітап атауын енгізіңіз.";
    }

    if (!filter_var($author_id, FILTER_VALIDATE_INT)) {
        $errors[] = "Авторды таңдаңыз.";
    }

    if (!filter_var($category_id, FILTER_VALIDATE_INT)) {
        $errors[] = "Санатты таңдаңыз.";
    }

    if ($published_year !== "" &&
        (!ctype_digit($published_year) || (int)$published_year < 1 || (int)$published_year > (int)date("Y"))) {
        $errors[] = "Жарияланған жылды дұрыс енгізіңіз.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO books (title, author_id, category_id, description, published_year)
            VALUES (:title, :author_id, :category_id, :description, :published_year)
        ");

        $stmt->execute([
            "title" => $title,
            "author_id" => $author_id,
            "category_id" => $category_id,
            "description" => $description,
            "published_year" => $published_year !== "" ? $published_year : null
        ]);

        header("Location: books.php");
        exit;
    }
}

require __DIR__ . "/includes/header.php";
?>

<main class="container page-main">

    <div class="page-intro">
        <span class="eyebrow">КІТАПХАНАНЫ БАСҚАРУ</span>
        <h1>Жаңа кітап қосу</h1>
        <p>Қазақ әдебиетінің жаңа шығармасын каталогқа енгізіңіз.</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="empty-state">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="search-form" style="display:flex; flex-direction:column; align-items:stretch; gap:15px;">

        <label>Кітап атауы</label>
        <input type="text" name="title" required
               value="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"
               placeholder="Кітап атауын енгізіңіз">

        <label>Автор</label>
        <select name="author_id" required>
            <option value="">Авторды таңдаңыз</option>
            <?php foreach ($authors as $author): ?>
                <option value="<?= $author["id"] ?>"
                    <?= (string)$author_id === (string)$author["id"] ? "selected" : "" ?>>
                    <?= htmlspecialchars($author["name"], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Санат</label>
        <select name="category_id" required>
            <option value="">Санатты таңдаңыз</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category["id"] ?>"
                    <?= (string)$category_id === (string)$category["id"] ? "selected" : "" ?>>
                    <?= htmlspecialchars($category["name"], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Сипаттамасы</label>
        <textarea name="description" rows="4"
                  placeholder="Кітап туралы қысқаша ақпарат"><?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?></textarea>

        <label>Жарияланған жылы</label>
        <input type="number" name="published_year"
               value="<?= htmlspecialchars($published_year, ENT_QUOTES, 'UTF-8') ?>"
               placeholder="Мысалы: 2020">

        <button type="submit" class="btn btn-primary">Кітапты сақтау</button>

        <a href="books.php" class="clear-link">Артқа қайту</a>

    </form>

</main>

<?php require __DIR__ . "/includes/footer.php"; ?>