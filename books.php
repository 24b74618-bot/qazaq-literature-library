
<?php
$pageTitle = "Кітаптар";

// Дерекқорға қосылу
require_once __DIR__ . "/includes/db.php";

// Іздеу сөзін алу
$q = trim($_GET["q"] ?? "");

// Кітаптарды дерекқордан алу
$sql = "
    SELECT
        books.id,
        books.title,
        books.description,
        books.published_year,
        authors.name AS author_name,
        categories.name AS category_name
    FROM books
    LEFT JOIN authors ON books.author_id = authors.id
    LEFT JOIN categories ON books.category_id = categories.id
";

if ($q !== "") {
    $sql .= "
        WHERE books.title LIKE :title
        OR authors.name LIKE :author
        OR categories.name LIKE :category
        OR books.description LIKE :description
    ";
}

$sql .= " ORDER BY books.id DESC";

$stmt = $pdo->prepare($sql);

if ($q !== "") {
    $search = "%" . $q . "%";

    $stmt->execute([
        "title" => $search,
        "author" => $search,
        "category" => $search,
        "description" => $search
    ]);
} else {
    $stmt->execute();
}

$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . "/includes/header.php";
?>

<main class="container page-main">

    <div class="page-intro">
        <span class="eyebrow">ЭЛЕКТРОНДЫ КАТАЛОГ</span>
        <h1>Кітаптар әлемі</h1>
        <p>Қазақ әдебиетінің таңдаулы шығармаларын іздеп, танысыңыз.</p>
    </div>

    <form class="search-form" method="GET" action="books.php">
        <label class="sr-only" for="q">Кітап немесе автор атауы</label>

        <input
            id="q"
            name="q"
            type="search"
            value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>"
            placeholder="Кітап немесе авторды іздеу..."
        >

        <button class="btn btn-primary" type="submit">Іздеу</button>

        <?php if ($q !== ""): ?>
            <a class="clear-link" href="books.php">Тазарту</a>
        <?php endif; ?>
    </form>

    <p class="result-count">
        Табылған шығарма саны:
        <strong><?= count($books) ?></strong>
    </p>

    <div class="book-grid">

        <?php foreach ($books as $i => $book): ?>

            <article class="book-card">

                <div class="cover cover-<?= ($i % 4) + 1 ?>">

                    <span>
                        <?= htmlspecialchars($book["category_name"] ?? "Әдеби шығарма", ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <strong>
                        <?= htmlspecialchars($book["title"], ENT_QUOTES, 'UTF-8') ?>
                    </strong>

                    <small>
                        <?= htmlspecialchars($book["author_name"] ?? "Авторы белгісіз", ENT_QUOTES, 'UTF-8') ?>
                    </small>

                </div>

                <div class="book-info">

                    <span class="tag">
                        <?= htmlspecialchars($book["category_name"] ?? "Әдеби шығарма", ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <h2>
                        <?= htmlspecialchars($book["title"], ENT_QUOTES, 'UTF-8') ?>
                    </h2>

                    <p>
                        <?= htmlspecialchars($book["author_name"] ?? "Авторы белгісіз", ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <p class="muted">
                        <?= htmlspecialchars($book["description"] ?? "", ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <?php if (!empty($book["published_year"])): ?>
                        <small>
                            Жарияланған жылы:
                            <?= htmlspecialchars((string)$book["published_year"], ENT_QUOTES, 'UTF-8') ?>
                        </small>
                    <?php endif; ?>

                    <!-- Кітапты өзгерту батырмасы -->
                    <a
                        href="edit-book.php?id=<?= (int)$book['id'] ?>"
                        class="btn btn-primary"
                    >
                        Өзгерту
                    </a>
                    <form action="delete-book.php" method="POST"
                        onsubmit="return confirm('Бұл кітапты өшіруге сенімдісіз бе?');">
                        <input type="hidden" name="id"
                            value="<?= (int)$book['id'] ?>">
                        <button type="submit" class="btn btn-primary">
                            Өшіру
                        </button>
                    </form>

                </div>

            </article>

        <?php endforeach; ?>

    </div>

    <?php if (empty($books)): ?>
        <div class="empty-state">
            <?php if ($q !== ""): ?>
                Іздеу бойынша кітап табылмады. Басқа сөз енгізіп көріңіз.
            <?php else: ?>
                Әзірге кітаптар қосылмаған.
            <?php endif; ?>
        </div>
    <?php endif; ?>

</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
