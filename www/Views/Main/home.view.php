<main>
    <section class="section_presentation">
        <h1>Restaurant</h1>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorum id accusamus soluta quod error rem labore optio tenetur, fuga atque nam recusandae, magni et molestiae quae incidunt beatae odio corrupti.</p>
    </section>
    <section class="section_menu">
        <h1>menu</h1>
        <?php if (!empty($data["menu"])) : ?>
            <?php foreach ($data["menu"] as $menu) : ?>
                <div class="menu">
                    <h2><?php echo $menu["title"] ?></h2>
                    <p><?php echo $menu["description"] ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

</main>