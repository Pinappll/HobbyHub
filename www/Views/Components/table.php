<table> 
    <thead>
        <tr>
            <?php
            foreach ($config as $colum) : ?>
                <th><?= $colum["title"] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row) : ?>
            <tr>
                <?php foreach ($config as $column) : ?>
                    <?php if ($column["name"] === "image_url_recipe") : ?>
                        <td><img src="<?= "/" . $row[$column["name"]] ?>" alt="image de la recette" width="100"></td>
                    
                    <?php elseif ($column["name"] === "edit") : ?>
                        <td><a href="<?= $column["route"] .  $row["id"] ?>"  class="button button-secondary">Editer</a></td>
                    <?php elseif ($column["name"] === "delete") : ?>
                        <td><a href="<?= $column["route"] .  $row["id"] ?>"  class="button button-danger">Supprimer</a></td>
                                            
                    <?php else : ?>
                        <td><?= $row[$column["name"]] ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>

            </tr>
        <?php endforeach; ?>
</table>