<!-- grapesjs_editor.php -->
<div style="padding: 10px;">
<h1>Créer une nouvelle page</h1>

<form id="pages-form" action="submit_page.php" method="POST">
<input type="hidden" id="content-input" name="content" />
    <input type="submit" class="button button-primary" value="Create page">
    <div id="gjs" style=""></div>
    <div id="blocks"></div>
</form>
</div>  
<link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
<style>
    /* Réduire la taille des blocs dans le gestionnaire de blocs */
    #blocks .gjs-block {
        width: 150px; /* ajustez la largeur comme vous le souhaitez */
        height: 20px; /* ajustez la hauteur comme vous le souhaitez */
        overflow: hidden; /* cache le contenu débordant */
        margin: 5px; /* ajoute un peu d'espace entre les blocs */
        padding: 5px; /* espace à l'intérieur des blocs */
        
    }

    /* Style du titre du bloc */
    #blocks .gjs-block-label {
        font-size: 2.75em; /* réduit la taille de la police du titre du bloc */
        white-space: nowrap; /* empêche le texte de passer à la ligne suivante */
        overflow: hidden; /* cache le texte débordant */
        text-overflow: ellipsis; /* ajoute des points de suspension si le texte déborde */
    }
</style>
<script src="https://unpkg.com/grapesjs"></script>
<script src="https://unpkg.com/grapesjs-preset-webpage"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const editor = grapesjs.init({
            container: '#gjs',
            fromElement: true,
            storageManager: false,
            plugins: ['gjs-preset-webpage'],
            pluginsOpts: {
                'gjs-preset-webpage': {}
            },
            blockManager: {
                appendTo: '#blocks',
                blocks: [
                    {
                        id: 'section',
                        label: '<b>Section</b>',
                        attributes: { class: 'gjs-block-section' },
                        content: '<section><h1>This is a simple title</h1><div>This is just a Lorem text: Lorem ipsum dolor sit amet</div></section>',
                    },
                    {
                        id: 'text',
                        label: 'Text',
                        content: '<div data-gjs-type="text">Insère ton texte ici</div>',
                    },
                    {
                        id: 'image',
                        label: 'Image',
                        select: true,
                        content: { type: 'image' },
                        activate: true,
                    },
                ],
            },
        });

        // Initial content save
        document.getElementById('content-input').value = editor.getHtml();
        // Update content on change
        editor.on('change:changesCount', () => {
            var content = editor.getHtml();
            document.getElementById('content-input').value = content;
        });
    });
</script>
