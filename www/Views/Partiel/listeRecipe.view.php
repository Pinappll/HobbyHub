<? var_dump($data["recipes"]);
foreach ($data["recipes"] as $recipe) : ?>
    <div class="card">
        <img src="<?= $recipe->getImage_url_recipe() ?>" alt="<?= $recipe->getTitle_recipe() ?>">
        <div class="container">
            <h4><b><?= $recipe->getTitle_recipe() ?></b></h4>
            <p><?= $recipe->getIngredient_recipe() ?></p>
            <p><?= $recipe->getInstruction_recipe() ?></p>
        </div>
    </div>
<? endforeach; ?>
<h1>test</h1>