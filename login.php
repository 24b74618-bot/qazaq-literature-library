
<?php
session_start();

require_once __DIR__ . "/includes/db.php";

$pageTitle = "Жүйеге кіру";
$errors = [];
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Электрондық пошта форматы дұрыс емес.";
    }

    if ($password === "") {
        $errors[] = "Құпиясөзді енгізіңіз.";
    }

    if (!$errors) {
        try {
            $stmt = $pdo->prepare(
                "SELECT id, name, email, password
                 FROM users
                 WHERE email = :email
                 LIMIT 1"
            );

            $stmt->execute(["email" => $email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user["password"])) {

                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];

                header("Location: index.php");
                exit;

            } else {
                $errors[] = "Электрондық пошта немесе құпиясөз қате.";
            }

        } catch (PDOException $e) {
            $errors[] = "Жүйеге кіру кезінде қате пайда болды.";
        }
    }
}

require __DIR__ . "/includes/header.php";
?>

<main class="container auth-wrap">
  <section class="auth-card">

    <span class="eyebrow">ҚАЙТА ОРАЛҒАНЫҢЫЗҒА ҚУАНЫШТЫМЫЗ</span>

    <h1>Жүйеге кіру</h1>

    <p class="muted">
      Кітапхана мүмкіндіктерін пайдалану үшін аккаунтыңызға кіріңіз.
    </p>

    <?php if ($errors): ?>
      <div class="notice notice-error" role="alert">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="stack-form">

      <label for="email">Электрондық пошта</label>

      <input
        id="email"
        name="email"
        type="email"
        value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
        placeholder="example@mail.com"
        required
      >

      <label for="password">Құпиясөз</label>

      <input
        id="password"
        name="password"
        type="password"
        placeholder="Құпиясөзіңіз"
        required
      >

      <button class="btn btn-primary btn-full" type="submit">
        Кіру
      </button>

    </form>

    <p class="auth-switch">
      Аккаунтыңыз жоқ па?
      <a href="register.php">Тіркелу</a>
    </p>

  </section>
</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
