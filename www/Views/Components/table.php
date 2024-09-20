<table class="styled-table">
    <thead>
        <tr>
            <?php foreach ($config as $column) : ?>
                <th><?= htmlspecialchars($column["title"]) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row) : ?>
            <tr>
                <?php foreach ($config as $column) : ?>
                    <?php if ($column["name"] === "image_url_recipe") : ?>
                        <td><img src="<?= "/" . htmlspecialchars($row[$column["name"]]) ?>" alt="image de la recette" class="table-image"></td>
                    
                    <?php elseif ($column["name"] === "edit") : ?>
                        <td><a href="<?= htmlspecialchars($column["route"] .  $row["id"]) ?>" class="button button-secondary">Éditer</a></td>
                    
                    <?php elseif ($column["name"] === "delete") : ?>
                        <td><a href="<?= htmlspecialchars($column["route"] .  $row["id"]) ?>" class="button button-danger">Supprimer</a></td>
                    
                    <?php elseif ($column["name"] === "anonymized") : ?>
                        <td><a href="<?= htmlspecialchars($column["route"] .  $row["id"]) ?>" class="button button-danger">Anonymiser</a></td>

                    <?php elseif ($column["name"] === "validation") : ?>
                        <td class="<?= htmlspecialchars($column["class"]) ?>">
                            <!-- Formulaire pour refuser -->
                            <form method="<?= htmlspecialchars($column["method"]["false"]) ?>" action="<?= htmlspecialchars($column["action"]["false"]) ?>" class="no-style-form">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($row["id"]) ?>">
                                <input type="submit" value="Refusé" class="button button-danger">
                            </form>

                            <!-- Formulaire pour valider -->
                            <form method="<?= htmlspecialchars($column["method"]["true"]) ?>" action="<?= htmlspecialchars($column["action"]["true"]) ?>" class="no-style-form">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($row["id"]) ?>">
                                <input type="submit" value="Validé" class="button button-secondary">
                            </form>
                        </td>
                    
                    <?php else : ?>
                        <td><?= htmlspecialchars($row[$column["name"]]) ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>