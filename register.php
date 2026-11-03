
<?php
session_start();

require_once __DIR__ . "/includes/db.php";

$pageTitle = "Тіркелу";
$errors = [];
$name = "";
$email = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    // Мәліметтерді тексеру
    if (mb_strlen($name) < 2) {
        $errors[] = "Аты-жөніңіз кемінде 2 таңбадан тұруы керек.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Дұрыс электрондық пошта енгізіңіз.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Құпиясөз кемінде 8 таңбадан тұруы керек.";
    }

    if ($password !== $confirm) {
        $errors[] = "Құпиясөздер сәйкес келмейді.";
    }

    // Дерекқорға сақтау
    if (!$errors) {
        try {
            $check = $pdo->prepare(
                "SELECT id FROM users WHERE email = :email"
            );

            $check->execute(["email" => $email]);

            if ($check->fetch()) {
                $errors[] = "Бұл электрондық пошта бұрын тіркелген.";
            } else {
                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $stmt = $pdo->prepare(
                    "INSERT INTO users (name, email, password)
                     VALUES (:name, :email, :password)"
                );

                $stmt->execute([
                    "name" => $name,
                    "email" => $email,
                    "password" => $hashedPassword
                ]);

                $success = "Сіз сәтті тіркелдіңіз! Енді жүйеге кіре аласыз.";

                $name = "";
                $email = "";
            }

        } catch (PDOException $e) {
            $errors[] = "Тіркелу кезінде қате пайда болды. Қайталап көріңіз.";
        }
    }
}

require __DIR__ . "/includes/header.php";
?>

<main class="container auth-wrap">
  <section class="auth-card">

    <span class="eyebrow">ҚАЗАҚ ӘДЕБИЕТІНЕ БІРГЕ САЯХАТ</span>

    <h1>Тіркелу</h1>

    <p class="muted">
      Жеке кітапханаңызды қалыптастыру үшін тіркеліңіз.
    </p>

    <?php if ($errors): ?>
      <div class="notice notice-error" role="alert">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="notice notice-success" role="status">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="register.php" class="stack-form">

      <label for="name">Аты-жөніңіз</label>
      <input
        id="name"
        name="name"
        type="text"
        value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
        placeholder="Аты-жөніңіз"
        required
      >

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
        placeholder="Кемінде 8 таңба"
        required
      >

      <label for="confirm_password">Құпиясөзді қайталаңыз</label>
      <input
        id="confirm_password"
        name="confirm_password"
        type="password"
        placeholder="Құпиясөзді қайталаңыз"
        required
      >

      <button class="btn btn-primary btn-full" type="submit">
        Тіркелу
      </button>

    </form>

    <p class="auth-switch">
      Аккаунтыңыз бар ма?
      <a href="login.php">Жүйеге кіру</a>
    </p>

  </section>
</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
