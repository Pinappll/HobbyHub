<section class="container section recettes">
    <h1><?= htmlspecialchars($title) ?></h1>
    <div class="container recettes__grid">
        <?php foreach ($data as $recipe): ?>
            <div class="card">
                <a href="/recipes/single-recipe?id=<?= htmlspecialchars($recipe['id']); ?>" class="card__link">
                    <div class="card__image">
                        <img src="<?= htmlspecialchars($recipe['image_url_recipe']); ?>" alt="<?= htmlspecialchars($recipe['title_recipe']); ?>" class="card__image">
                    </div>
                    <h2 class="card__title"><?= htmlspecialchars($recipe['title_recipe']); ?></h2>
                </a>
                <div class="card__content">
                    <!-- Contenu supplémentaire si nécessaire, par exemple, un extrait ou une description -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1; ?>">Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i; ?>" class="<?= $i === $currentPage ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1; ?>">Suivant</a>
        <?php endif; ?>
    </div>
</section>
