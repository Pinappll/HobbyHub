
    <link
      href="https://unpkg.com/grapesjs/dist/css/grapes.min.css"
      rel="stylesheet"
    />
    <link
      href="https://unpkg.com/grapesjs-preset-webpage/dist/grapesjs-preset-webpage.min.css"
      rel="stylesheet"  
    />
    <style>
      #wrapper {
        display: flex;
      }

      #sidebar {
        width: 200px;
        background-color: #444444;
      }

      #editor {
        flex: 1;
      }

      /* Supprimer les marges par défaut */
      body,
      html {
        margin: 0;
        padding: 0;
      }

      /* Supprimer la bordure autour de la barre latérale et de la zone d'édition */
      #sidebar,
      #editor {
        border: none;
        outline: none;
      }
      #header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f0f0f0;
        padding: 10px;
      }

      #buttons {
        display: flex;
        gap: 10px;
      }

      #buttons button {
        background-color: #007bff;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        cursor: pointer;
      }

      #buttons button:hover {
        background-color: #0056b3;
      }
    </style>
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-preset-webpage"></script>
    <header id="header">
      <div class="title">Page Builder</div>
      <div class="buttons">
        <button id="save-button" class="button">Enregistrer</button>
        <button id="preview-button" class="button">Prévisualiser</button>
      </div>
    </header>
    <div id="wrapper">
      <div id="sidebar">
        <div id="blocks"></div>
      </div>
      <div id="editor"></div>
    </div>

    <script>
      // Initialisation de l'éditeur GrapeJS
      const editor = grapesjs.init({
        container: "#editor",
        plugins: ["gjs-preset-webpage"],
        pluginsOpts: {
          "gjs-preset-webpage": {},
        },
        storageManager: false, // Désactiver la gestion du stockage pour cet exemple
        assetManager: {
          embedAsBase64: true, // Activer l'intégration des ressources en tant que base64 pour cet exemple
        },
        blockManager: {
          appendTo: "#blocks", // Elément parent pour les blocs
          blocks: [
            {
              id: "text",
              label: "Text",
              content: '<div data-gjs-type="text">Insert your text here</div>',
              category: "Basic",
            },
            {
              id: "image",
              label: "Image",
              content:
                '<input type="file" id="image-upload" accept="image/*" data-gjs-type="image" data-gjs-draggable="true" />',
              category: "Basic",
            },
            {
              id: "title",
              label: "Title",
              content: '<h1 data-gjs-type="text">Your Title Here</h1>',
              category: "Basic",
            },
          ],
        },
      });
    </script>
