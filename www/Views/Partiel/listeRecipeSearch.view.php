<ul>


    <?php foreach ($recipes as $recipe) : ?>

        <li class="li-recipe-search">
            
            <p>#<?=$recipe->getId()?> <?=$recipe->getTitle_recipe() ?></p>
            
            <img src="/<?= $recipe->getImage_url_recipe() ?>"></img>
            <input type="hidden" value=<?=$recipe->getId()?>>
            
        </li>
    <?php endforeach; ?>

</ul>