
<form method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?? "" ?>" class="<?= $config["config"]["class"] ?? "" ?>" id="<?= $config["config"]["id"] ?? "" ?>" <?= (!empty($config["config"]["enctype"])) ? 'enctype="' . $config["config"]["enctype"] . '"' : "" ?>>
    <?php if (!empty($config["config"]["title"])) : ?>
        <h1 class="form-title"><?= $config["config"]["title"] ?></h1>
    <?php endif; ?>
    <div class="container">
        <?php if (!empty($data)) : ?>
            <div class="error-message">
                <?php foreach ($data as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php foreach ($config["inputs"] as $name => $configInput) : ?>
            <div class="form-group<?= !empty($configInput["flex-row"]) && $configInput["flex-row"] === true ? ' flex-row' : '' ?>">
                <?php if ($configInput["type"] === "checkbox") : ?>
                    <?php foreach ($configInput["value"] as $value) : ?>
                        <input class="<?= $configInput["class"] ?? "" ?>" name="<?= $name ?>[]" type="<?= $configInput["type"] ?>" id="<?= $value["id"] ?>" value="<?= $value["id"] ?>" <?= ($value["checked"]) ? "checked" : "" ?> <?= (!empty($configInput["required"])) ? "required" : "" ?>>
                        <label for="<?= $value["id"] ?>"><?= $value["name"] ?></label>
                    <?php endforeach; ?>
                <?php elseif ($configInput["type"] === "textarea") : ?>
                    <textarea name="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>><?= $configInput["value"] ?? "" ?></textarea><br>
                <?php elseif ($configInput["type"] === "select") : ?>
                    <select name="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>>
                        <option disabled selected value="0"><?= $configInput["placeholder"] ?></option>
                        <?php foreach ($configInput["option"] as $option) : ?>
                            <option value="<?= $option["id"] ?>" <?= $option["selected"] ?? "" ?>><?= $option["name"] ?></option>
                        <?php endforeach; ?>
                        <?php if ($name === "parent_id") : ?>
                            <option value="0">Aucun parent</option>
                        <?php endif; ?>
                    </select><br>
                <?php elseif ($configInput["type"] === "partiel") : ?>
                    <div class="<?= $configInput["class"] ?>">
                        <h2><?= $configInput["titre"] ?></h2>
                    </div>
                <?php elseif ($configInput["type"] === "color") : ?>
                    <!-- Gestion du type color -->
                    <label for="<?= $name ?>"><?= $configInput["label"] ?? "" ?></label>
                    <input name="<?= $name ?>" type="color" id="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" value="<?= $configInput["value"] ?? "#000000" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>><br>
                <?php else : ?>
                    <input name="<?= $name ?><?= ($configInput["type"] === "text" && !empty($configInput["multiple"])) ? "[]" : "" ?>" type="<?= $configInput["type"] ?? "text" ?>" id="<?= $configInput["id"] ?? "" ?>" class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>" value="<?= $configInput["value"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>><br>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (!empty($config["div"])) : ?>
            <div class="<?= $config["div"]["class"] ?? "" ?>">
                <h2><?= $config["div"]["titre"] ?? "" ?></h2>
            </div>
        <?php endif; ?>
        
        <input type="submit" class="button button-primary" value="<?= $config["config"]["submit"] ?? "Envoyer" ?>">
    </div>
</form>