<?php
$pageTitle = "Авторлар";
require __DIR__ . "/includes/header.php";
$authors = [
 ["Абай Құнанбайұлы","Ақын, ойшыл, ағартушы","Қазақ жазба әдебиетінің негізін қалаушылардың бірі."],
 ["Мұхтар Әуезов","Жазушы, драматург, ғалым","«Абай жолы» роман-эпопеясының авторы."],
 ["Міржақып Дулатұлы","Ақын, жазушы, қоғам қайраткері","«Бақытсыз Жамал» романының авторы."]
];
?>
<main class="container page-main"><div class="page-intro"><span class="eyebrow">ҚАЛАМГЕРЛЕР</span><h1>Қазақ әдебиетінің тұлғалары</h1><p>Ұлт руханиятына үлес қосқан көрнекті қаламгерлер.</p></div>
<div class="author-grid"><?php foreach ($authors as $author): ?><article class="author-card"><div class="author-monogram"><?= mb_substr($author[0],0,1) ?></div><span class="tag"><?= htmlspecialchars($author[1],ENT_QUOTES,'UTF-8') ?></span><h2><?= htmlspecialchars($author[0],ENT_QUOTES,'UTF-8') ?></h2><p><?= htmlspecialchars($author[2],ENT_QUOTES,'UTF-8') ?></p></article><?php endforeach; ?></div></main>
<?php require __DIR__ . "/includes/footer.php"; ?>