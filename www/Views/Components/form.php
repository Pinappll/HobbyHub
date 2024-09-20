<form method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?? "" ?>" class="<?= $config["config"]["class"] ?? "" ?>" id="<?= $config["config"]["id"] ?? "" ?>" <?= (!empty($config["config"]["enctype"])) ? 'enctype="' . $config["config"]["enctype"] . '"' : "" ?>>
    <?php if (!empty($config["config"]["title"])) : ?>
        <h1 class="form-title"><?= $config["config"]["title"] ?></h1>
    <?php endif; ?>
    
    <div class="container">
        <?php if (!empty($data)) : ?>
            <div class="error-message">
                <?php foreach ($data as $error) : ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php foreach ($config["inputs"] as $name => $configInput) : ?>
            <div class="form-group<?= !empty($configInput["flex-row"]) && $configInput["flex-row"] === true ? ' flex-row' : '' ?>">
                <?php if (isset($configInput["type"]) && $configInput["type"] === "checkbox") : ?>
                    <?php foreach ($configInput["value"] as $value) : ?>
                        <input class="<?= $configInput["class"] ?? "" ?>" name="<?= $name ?>[]" type="<?= $configInput["type"] ?>" id="<?= $value["id"] ?>" value="<?= $value["id"] ?>" <?= isset($value["checked"]) && $value["checked"] ? "checked" : "" ?> <?= !empty($configInput["required"]) ? "required" : "" ?>>
                        <label for="<?= $value["id"] ?>"><?= htmlspecialchars($value["name"]) ?></label>
                    <?php endforeach; ?>
                <?php elseif (isset($configInput["type"]) && $configInput["type"] === "textarea") : ?>
                    <textarea name="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>" <?= !empty($configInput["required"]) ? "required" : "" ?> <?= !empty($configInput["disabled"]) ? "disabled" : "" ?>><?= htmlspecialchars($configInput["value"] ?? "") ?></textarea><br>
                <?php elseif (isset($configInput["type"]) && $configInput["type"] === "select") : ?>
                    <select name="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" <?= !empty($configInput["required"]) ? "required" : "" ?> <?= !empty($configInput["disabled"]) ? "disabled" : "" ?>>
                        <option disabled selected value="0"><?= $configInput["placeholder"] ?? "Sélectionner une option" ?></option>
                        <?php foreach ($configInput["options"] as $key => $option) : ?>
                            <option value="<?= $key ?>" <?= isset($configInput["value"]) && $configInput["value"] == $key ? 'selected' : '' ?>><?= htmlspecialchars($option) ?></option>
                        <?php endforeach; ?>
                    </select><br>
                <?php elseif (isset($configInput["type"]) && $configInput["type"] === "color") : ?>
                    <label for="<?= $name ?>"><?= htmlspecialchars($configInput["label"] ?? "") ?></label>
                    <input name="<?= $name ?>" type="color" id="<?= $name ?>" class="<?= $configInput["class"] ?? "" ?>" value="<?= htmlspecialchars($configInput["value"] ?? "#000000") ?>" <?= !empty($configInput["required"]) ? "required" : "" ?> <?= !empty($configInput["disabled"]) ? "disabled" : "" ?>><br>
                <?php else : ?>
                    <input name="<?= $name ?>" type="<?= $configInput["type"] ?? "text" ?>" id="<?= $configInput["id"] ?? "" ?>" class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>" value="<?= htmlspecialchars($configInput["value"] ?? "") ?>" <?= !empty($configInput["required"]) ? "required" : "" ?> <?= !empty($configInput["disabled"]) ? "disabled" : "" ?>><br>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (!empty($config["div"])) : ?>
            <div class="<?= $config["div"]["class"] ?? "" ?>">
                <h2><?= htmlspecialchars($config["div"]["titre"] ?? "") ?></h2>
            </div>
        <?php endif; ?>
        
        <input type="submit" class="button button-primary" value="<?= $config["config"]["submit"] ?? "Envoyer" ?>">
    </div>
</form>
