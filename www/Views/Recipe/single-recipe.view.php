<section class="container section">
<div class="recipe-detail">
        <h1 class="recipe-detail__title"><?= htmlspecialchars($recipe->getTitle_recipe()); ?></h1>
        
        <div class="recipe-detail__info">
            <div class="recipe-detail__image">
                <img src="../../<?= htmlspecialchars($recipe->getImage_url_recipe()); ?>" alt="<?= htmlspecialchars($recipe->getTitle_recipe()); ?>">
            </div>
            <div class="recipe-detail__description">
                <p><?= nl2br(htmlspecialchars($recipe->getIngredient_recipe())); ?></p>
            </div>
        </div>
        
        <div class="recipe-detail__instructions">
            <h2>Instructions</h2>
            <p><?= nl2br(htmlspecialchars($recipe->getInstruction_recipe())); ?></p>
        </div>
        
        <div class="recipe-detail__categories">
    <h3>Catégories:</h3>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><?= isset($category["name"]) ? htmlspecialchars($category["name"]) : 'Nom de la catégorie non défini'; ?></li>
        <?php endforeach; ?>
    </ul>
</div>

    </div>

</section>