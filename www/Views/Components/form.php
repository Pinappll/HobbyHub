<form method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?? "" ?>" class="<?= $config["config"]["class"] ?? "" ?>" id="<?= $config["config"]["id"] ?? "" ?>" <?= (!empty($config["config"]["enctype"])) ? 'enctype="' . $config["config"]["enctype"] . '"' : "" ?>>

    <!-- Titre du formulaire, s'il est défini -->
    <?php if (!empty($config["config"]["title"])) : ?>
        <h1 class="form-title"><?= $config["config"]["title"] ?></h1>
    <?php endif; ?>

    <div class="container">
        <!-- Affichage des erreurs, si elles existent -->
        <?php if (!empty($data) && is_array($data)) : ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($data as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Boucle sur chaque champ du formulaire -->
        <?php foreach ($config["inputs"] as $name => $configInput) : ?>
            <div class="form-group">

                <!-- Gestion des textareas -->
                <?php if ($configInput["type"] === "textarea") : ?>
                    <label for="<?= $name ?>"><?= $configInput["placeholder"] ?? "" ?></label>
                    <textarea name="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>><?= $configInput["value"] ?? "" ?></textarea><br>

                <!-- Gestion des selects -->
                <?php elseif ($configInput["type"] === "select") : ?>
                    <label for="<?= $name ?>"><?= $configInput["placeholder"] ?? "" ?></label>
                    <select name="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>>
                        <option disabled selected><?= $configInput["placeholder"] ?? "Sélectionner" ?></option>
                        <?php if (is_array($configInput["options"])) : ?>
                            <?php foreach ($configInput["options"] as $option) : ?>
                                <option value="<?= $option["value"] ?>" <?= ($option["selected"] ?? false) ? "selected" : "" ?>>
                                    <?= $option["label"] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select><br><br>

                <!-- Gestion des couleurs -->
                <?php elseif ($configInput["type"] === "color") : ?>
                    <label for="<?= $name ?>"><?= $configInput["label"] ?? "" ?></label>
                    <input name="<?= $name ?>" type="color" id="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" value="<?= $configInput["value"] ?? "#000000" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>><br>

                <!-- Gestion des fichiers -->
                <?php elseif ($configInput["type"] === "file") : ?>
                    <label for="<?= $name ?>"><?= $configInput["placeholder"] ?? "" ?></label>
                    <input name="<?= $name ?>" type="file" id="<?= $configInput["id"] ?? "" ?>" class="<?= $configInput["class"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>><br>

                <!-- Autres types de champs (text, number, etc.) -->
                <?php else : ?>
                    <label for="<?= $name ?>"><?= $configInput["placeholder"] ?? "" ?></label>
                    <input name="<?= $name ?><?= ($configInput["type"] === "text" && !empty($configInput["multiple"])) ? "[]" : "" ?>" type="<?= $configInput["type"] ?? "text" ?>" id="<?= $configInput["id"] ?? "" ?>" class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>" value="<?= $configInput["value"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>><br>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

       

        <!-- Bouton de soumission -->
        <input type="submit" class="button button-primary" value="<?= $config["config"]["submit"] ?? "Envoyer" ?>">
    </div>
</form>
