<table id="recipe">
    <h2>Liste des recettes sélectionner</h2>
    <tr>
        <th></th>
        <th>Titre</th>
        <th>Ingredient</th>
        <th>Instruction</th>
        <th>Image</th>
    </tr>
    <?php foreach ($recipes as $recipe) : ?>
        <tr>
            <td><input checked type="checkbox" name="recipe[]" id="" value="<?= $recipe["id_recipe"] ?>">
            <td><?= $recipe["title_recipe"] ?></td>
            <td><?= $recipe["ingredient_recipe"] ?></td>
            <td><?= $recipe["instruction_recipe"] ?></td>
            <td><img src="/<?= $recipe["image_url_recipe"] ?>"></img></td>
        </tr>
    <?php endforeach; ?>
</table>