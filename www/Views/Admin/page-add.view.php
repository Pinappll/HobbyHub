<link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet" />
<link href="https://unpkg.com/grapesjs-preset-webpage/dist/grapesjs-preset-webpage.min.css" rel="stylesheet" />
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
<script src="https://unpkg.com/grapesjs-blocks-basic"></script>
<header id="header">
  <div class="title">Page Builder</div>
  <?php $this->includeComponent("form", $configForm, $errorsForm);
  if (isset($this->data["message"])) {
    echo "<h3>" . $this->data["message"] . "</h3>";
  }
  ?>
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
    plugins: ["gjs-blocks-basic"],
    pluginsOpts: {
      "gjs-blocks-basic": {},
    },
    storageManager: false,
    assetManager: {
      embedAsBase64: true,
    },
    blockManager: {
      appendTo: "#blocks",
      blocks: [{
          id: "text",
          label: "Text",
          content: '<div data-gjs-type="text">Insert your text here</div>',
          category: "Basic",
        },
        {
          id: "image",
          label: "Image",
          content: '<input type="file" id="image-upload" accept="image/*" data-gjs-type="image" data-gjs-draggable="true" />',
          category: "Basic",
        },
        {
          id: "title",
          label: "Title",
          content: '<h1 data-gjs-type="text">Your Title Here</h1>',
          category: "Basic",
        },
        {
          id: "my-section",
          label: "Section",
          content: {
            tagName: 'div',
            classes: ['section', 'section-presentation'],
            components: `<section class="section section-presentation">
        <h1>Titre de la section</h1>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorum id accusamus soluta quod error rem labore optio tenetur, fuga atque nam recusandae, magni et molestiae quae incidunt beatae odio corrupti.</p>
    </section>`,
          },
          category: "Basic",
        },
        {
          id: "my-section2",
          label: "Section 2",
          content: {
            tagName: 'div',
            classes: ['section', 'section-menu'],
            components: `<section class="section section-menu">
    <h1>Menu</h1>
    <div class="menu">
        <h2>Titre du Menu 1</h2>
        <p>Description du Menu 1, avec des détails sur les plats disponibles.</p>
    </div>
</section>
`,
          },
          category: "Basic",
        },
        {
          id: "my-map",
          label: "Map",
          content: {
            tagName: 'div',
            classes: ['map'],
            components: `<div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.474052163265!2d2.38715937612803!3d48.849170101355796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6720d9c7af387%3A0x5891d8d62e8535c7!2sESGI%2C%20%C3%89cole%20Sup%C3%A9rieure%20de%20G%C3%A9nie%20Informatique!5e0!3m2!1sfr!2sfr!4v1706276679727!5m2!1sfr!2sfr" width="600" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
`,
          },
          category: "Basic",
        },
        {
          id: "my-card",
          label: "Card",
          content: {
            tagName: 'div',
            classes: ['card'],
            components: `
			<article class="card">
				<img src="../../dist/assets/images/recettes/cake.jpg">
				<h1>Card title</h1>
				<p>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				<a href="#" class="button button-primary button-sm"> Button </a>

			</article>
`,
          },
          category: "Basic",
        },
      ],
    },
  });

  editor.on('load', () => {
    const cssLink = editor.Canvas.getDocument().createElement('link');
    cssLink.href = '/easycook-vite/dist/css/style.css';
    cssLink.rel = 'stylesheet';
    cssLink.type = 'text/css';
    editor.Canvas.getDocument().head.appendChild(cssLink);
  });

  document.getElementById('pageForm').addEventListener('submit', function(e) {
    debugger;
    const htmlContent = editor.getHtml();
    const componentsJson = editor.getComponents();
    const styleJson = editor.getStyle();
    const jsonData = JSON.stringify({
      components: componentsJson,
      styles: styleJson,
      html: htmlContent
    });

    document.querySelector('.contentInput').value = jsonData;
  });
</script>