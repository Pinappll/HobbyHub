<form method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?? "" ?>" class="<?= $config["config"]["class"] ?? "" ?>" id="<?= $config["config"]["id"] ?? "" ?>" <?= (!empty($config["config"]["enctype"])) ? 'enctype="' . $config["config"]["enctype"] . '"' : "" ?>>


    <div class="container">
        <?php if (!empty($data)) : ?>
            <div style="background-color: red">
                <?php foreach ($data as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <?php foreach ($config["inputs"] as $name => $configInput) : ?>
            <div class="form-group">
                <input name="<?= $name ?>" type="<?= $configInput["type"] ?? "text" ?>" id="<?= $configInput["id"] ?? "" ?>" class="<?= $configInput["class"] ?? "" ?>" placeholder="<?= $configInput["placeholder"] ?? "" ?>" value="<?= $configInput["value"] ?? "" ?>" <?= (!empty($configInput["required"])) ? "required" : "" ?>><br>
            </div>
        <?php endforeach; ?>

        <?php if (isset($config["textarea"])) : ?>
            <?php foreach ($config["textarea"] as $name => $configTextarea) : ?>
                <div class="form-group">
                    <textarea name="<?= $name ?>" class="<?= $configTextarea["class"] ?? "" ?>" placeholder="<?= $configTextarea["placeholder"] ?? "" ?>" <?= (!empty($configTextarea["required"])) ? "required" : "" ?>></textarea><br>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($config["select"])) : ?>
            <?php foreach ($config["select"] as $name => $configSelect) : ?>
                <div class="form-group">
                    <select name="<?= $name ?>" class="<?= $configSelect["class"] ?? "" ?>" placeholder="<?= $configSelect["placeholder"] ?? "" ?>" <?= (!empty($configSelect["required"])) ? "required" : "" ?>>
                        <?php foreach ($config["options"][$name] as $option) : ?>
                            <option value="<?= $option ?>"><?= $option ?></option>
                        <?php endforeach; ?>
                    </select><br>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <input type="submit" class="button button-primary" value="<?= $config["config"]["submit"] ?? "Envoyer" ?>">
    </div>
</form>