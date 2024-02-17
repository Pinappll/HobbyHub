<section class="section">

    <h1>Pages</h1>
    <br>
    <a href="/admin/pages/add-page" class="button button-primary">Ajouter une page</a>
    <br>
    <br>

    <p>Vous trouverez ci-dessous la liste des pages du site.</p>
    <br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
               
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $page) : ?>
                <tr>
                    <td><?= $page->getId() ?></td>
                    <td><?= $page->getTitle_page() ?></td>
                    
                    <td>
                        <a href="/admin/pages/edit/<?= $page->getId() ?>">Modifier</a>
                        |
                        <a href="/admin/pages/delete/<?= $page->getId() ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
</section>