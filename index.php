<?php
$pageTitle = "Басты бет";
require __DIR__ . "/includes/header.php";
?>
<main>
  <section class="hero container">
    <div class="hero-copy">
      <span class="eyebrow">ҰЛТТЫҚ ӘДЕБИ МҰРА</span>
      <h1>Қазақ әдебиетінің <em>әлеміне</em> қош келдіңіз!</h1>
      <p>Классикалық шығармалар, көрнекті қаламгерлер және рухани қазына — барлығы бір онлайн кітапханада.</p>
      <div class="hero-actions">
        <a class="btn btn-primary" href="books.php">Кітаптарды қарау</a>
        <a class="text-link" href="authors.php">Авторлар туралы →</a>
      </div>
    </div>
    <div class="hero-art" aria-label="Кітаптар иллюстрациясы">
      <div class="sun"></div><div class="book book-one"><span>АБАЙ ЖОЛЫ</span><small>М. Әуезов</small></div>
      <div class="book book-two"><span>ӨЛЕҢДЕР</span><small>Абай Құнанбайұлы</small></div>
      <div class="book book-three"><span>ҚАЗАҚ ӘДЕБИЕТІ</span><small>Рухани мұра</small></div>
      <div class="decor-line"></div>
    </div>
  </section>

  <section class="container section">
    <div class="section-heading">
      <div><span class="eyebrow">КІТАПХАНА</span><h2>Әдебиет әлемін зерттеңіз</h2></div>
      <a class="text-link" href="books.php">Барлық кітаптар →</a>
    </div>
    <div class="feature-grid">
      <article class="feature-card"><span class="feature-icon">✦</span><h3>Бай әдеби мұра</h3><p>Қазақ әдебиетінің таңдаулы шығармалары бір каталогта.</p></article>
      <article class="feature-card"><span class="feature-icon">⌕</span><h3>Жылдам іздеу</h3><p>Шығарма атауы мен авторы бойынша қажетті кітапты табыңыз.</p></article>
      <article class="feature-card"><span class="feature-icon">♡</span><h3>Таңдаулы кітаптар</h3><p>Өзіңізге ұнаған туындыларды жеке тізімге жинаңыз.</p></article>
    </div>
  </section>

  <section class="quote-band">
    <div class="container quote-inner"><span>“</span><p>Артық ғылым кітапта, ерінбей оқып көруге.</p><small>Абай Құнанбайұлы</small></div>
  </section>
</main>
<?php require __DIR__ . "/includes/footer.php"; ?>