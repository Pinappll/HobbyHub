<main>
    <section class="section section-presentation">
        <h1>Restaurant</h1>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorum id accusamus soluta quod error rem labore optio tenetur, fuga atque nam recusandae, magni et molestiae quae incidunt beatae odio corrupti.</p>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero ullam unde doloremque accusantium, minima earum commodi neque beatae ipsum nemo modi eaque hic a sit asperiores similique esse, atque iste.</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis aperiam ipsum provident voluptatum dolore ducimus? Saepe modi numquam, quam, quo officiis perspiciatis impedit, laborum quidem perferendis magnam incidunt placeat fuga.</p>
    </section>
    <section class="section section-menu">
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