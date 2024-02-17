<table>
    <h1>Hello</h1>
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
                    <?php else : ?>
                        <td><?= $row[$column["name"]] ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>

            </tr>
        <?php endforeach; ?>
</table>