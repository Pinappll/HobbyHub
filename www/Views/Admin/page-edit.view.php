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

  body,
  html {
    margin: 0;
    padding: 0;
  }

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
    color: white;
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
  <div class="title">Éditeur de Page</div>
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
      
      // Card Block
      {
        id: "responsive-card",
        label: "Card",
        content: `
          <div class="card">
          <a href="#">
            <img src="../../dist/assets/images/imageParDefaut.jpg" class="card__image" alt="Card Image">
            <h3 class="card__title">Card Title</h3>
          </a>
          </div>
        `,
        category: "Cards",
      },
      
      // Circular Card Block
      {
        id: "circular-card",
        label: "Circular Card",
        content: `
          <div class="circular-card">
            <a href="#" class="circular-card__link">
              <img src="../../dist/assets/images/imageParDefaut.jpg" class="circular-card__image" alt="Circular Card Image">
              <h3 class="circular-card__title">Card Title</h3>
            </a>
          </div>
        `,
        category: "Cards",
      },

      // Block de texte (Titre et texte avec fond en couleur et coins arrondis)
      {
        id: "block-texte",
        label: "Block de Texte",
        content: {
          tagName: 'div',
          classes: ['text-block'],
          components: `
            <div class="text-block" style="background-color: #f8c630; padding: 20px; border-radius: 10px;">
              <h2>Titre du bloc</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>`,
        },
        category: "Text",
      },

      // Commentaire (Formulaire)
      {
        id: "commentaire",
        label: "Formulaire de Commentaire",
        content: {
          tagName: 'div',
          classes: ['comment-section'], // Utilisation de la classe principale définie dans le CSS
          components: `
            <form id="commentForm" class="comment-section__form">
              <div class="comment-section__field">
                <label for="content_review">Laissez un commentaire</label>
                <textarea name="content_review" placeholder="Laissez un commentaire..." required></textarea>
              </div>
              <div class="comment-section__actions">
                <button type="submit" class="comment-section__submit">Poster le commentaire</button>
              </div>
            </form>
            <div id="commentsList" class="comment-section__list"></div>`,
        },
        category: "Forms",
      },


      // Contact Form (Formulaire de Contact)
      {
        id: "contact-form",
        label: "Contact Form",
        content: {
          tagName: 'form',
          classes: ['no-style-form', 'contact-form'], // Appliquer les classes pour réinitialiser et styliser le formulaire
          components: `
            <form class="contact-form">
              <div class="container">
                <div class="form-group">
                  <label for="name">Nom:</label>
                  <input type="text" id="name" name="name" placeholder="Votre nom" required>
                </div>
                
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" placeholder="Votre email" required>
                </div>
                
                <div class="form-group">
                  <label for="message">Message:</label>
                  <textarea id="message" name="message" placeholder="Votre message" required></textarea>
                </div>

                <div class="form-group">
                  <input type="submit" value="Envoyer">
                </div>
              </div>
            </form>`,
        },
        category: "Forms",
      },


      
      {
        id: "hero-image-left",
        label: "Hero Image Left",
        content: {
          tagName: 'div',
          classes: ['hero', 'hero-left'],
          components: `
            <div class="hero__content">
              <img class="hero__image" src="../../dist/assets/images/imageParDefaut.jpg" alt="Hero Image">
              <div class="hero__text-box">
                <h2>Titre Hero</h2>
                <p>Texte descriptif du bloc hero avec l'image à gauche.</p>
              </div>
            </div>`,
        },
        category: "Hero",
      },


      // Hero Image Right
      {
        id: "hero-image-right",
        label: "Hero Image Right",
        content: {
          tagName: 'div',
          classes: ['hero', 'hero-right'],
          components: `
            <div class="hero__content" style="flex-direction: row-reverse;">
              <img class="hero__image" src="../../dist/assets/images/imageParDefaut.jpg" alt="Hero Image">
              <div class="hero__text-box">
                <h2>Titre Hero</h2>
                <p>Texte descriptif du bloc hero avec l'image à droite.</p>
              </div>
            </div>`,
        },
        category: "Hero",
      },
      {
        id: "recettes-section",
        label: "Recettes Section",
        content: {
          tagName: 'section',
          classes: ['recettes'],
          components: `
            <div class="recettes">
              <h1>Nos Recettes</h1>
              <div class="recettes__grid">
                <div class="card">
                  <a href="/recette1" class="card__link">
                    <img src="../../dist/assets/images/recette1.jpg" alt="Recette 1" class="card__image">
                    <h2 class="card__title">Recette 1</h2>
                    <p class="card__description">Description courte de la recette 1.</p>
                  </a>
                </div>
                <div class="card">
                  <a href="/recette2" class="card__link">
                    <img src="../../dist/assets/images/recette2.jpg" alt="Recette 2" class="card__image">
                    <h2 class="card__title">Recette 2</h2>
                    <p class="card__description">Description courte de la recette 2.</p>
                  </a>
                </div>
                <div class="card">
                  <a href="/recette3" class="card__link">
                    <img src="../../dist/assets/images/recette3.jpg" alt="Recette 3" class="card__image">
                    <h2 class="card__title">Recette 3</h2>
                    <p class="card__description">Description courte de la recette 3.</p>
                  </a>
                </div>
              </div>
            </div>
          `,
        },
        category: "Recettes",
      },
      {
        id: "circular-card-grid",
        label: "Circular Card Grid",
        content: {
          tagName: 'div',
          classes: ['circular-card-grid'],
          components: `
            <div class="circular-card">
              <a href="/link1" class="circular-card__link">
                <div class="circular-card__image">
                  <img src="../../dist/assets/images/card1.jpg" alt="Card 1">
                </div>
                <h2 class="circular-card__title">Card 1</h2>
              </a>
            </div>
            <div class="circular-card">
              <a href="/link2" class="circular-card__link">
                <div class="circular-card__image">
                  <img src="../../dist/assets/images/card2.jpg" alt="Card 2">
                </div>
                <h2 class="circular-card__title">Card 2</h2>
              </a>
            </div>
            <div class="circular-card">
              <a href="/link3" class="circular-card__link">
                <div class="circular-card__image">
                  <img src="../../dist/assets/images/card3.jpg" alt="Card 3">
                </div>
                <h2 class="circular-card__title">Card 3</h2>
              </a>
            </div>
            <div class="circular-card">
              <a href="/link4" class="circular-card__link">
                <div class="circular-card__image">
                  <img src="../../dist/assets/images/card4.jpg" alt="Card 4">
                </div>
                <h2 class="circular-card__title">Card 4</h2>
              </a>
            </div>
            <div class="circular-card">
              <a href="/link5" class="circular-card__link">
                <div class="circular-card__image">
                  <img src="../../dist/assets/images/card5.jpg" alt="Card 5">
                </div>
                <h2 class="circular-card__title">Card 5</h2>
              </a>
            </div>
            <div class="circular-card">
              <a href="/link6" class="circular-card__link">
                <div class="circular-card__image">
                  <img src="../../dist/assets/images/card6.jpg" alt="Card 6">
                </div>
                <h2 class="circular-card__title">Card 6</h2>
              </a>
            </div>
          `,
        },
        category: "Recettes",
      },
      {
        id: "recipe-detail",
        label: "Recipe Detail",
        content: {
          tagName: 'div',
          classes: ['recipe-detail'],
          components: `
            <div class="recipe-detail">
              <h1 class="recipe-detail__title">Titre de la Recette</h1>
              <div class="recipe-detail__info">
                <div class="recipe-detail__image">
                  <img src="../../dist/assets/images/recette-detail.jpg" alt="Recette Image">
                </div>
                <div class="recipe-detail__description">
                  <p>Voici une description détaillée de la recette. Elle donne un aperçu de ce que cette recette offre et pourquoi elle est délicieuse.</p>
                </div>
              </div>
              <div class="recipe-detail__ingredients">
                <h2>Ingrédients</h2>
                <ul>
                  <li>1 tasse de farine</li>
                  <li>2 œufs</li>
                  <li>1/2 tasse de lait</li>
                  <li>Une pincée de sel</li>
                </ul>
              </div>
              <div class="recipe-detail__instructions">
                <h2>Instructions</h2>
                <ol>
                  <li>Mélanger les ingrédients secs.</li>
                  <li>Ajouter les œufs et le lait, puis bien mélanger.</li>
                  <li>Cuire dans une poêle chaude pendant 2 à 3 minutes de chaque côté.</li>
                  <li>Servir chaud.</li>
                </ol>
              </div>
            </div>
          `,
        },
        category: "Recettes",
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

  // Chargez le contenu existant
  const existingContent = <?php echo json_encode($page->getContent_page()); ?>;
    if (existingContent) {
      const contentObj = JSON.parse(existingContent);
      editor.setComponents(contentObj.components);
      editor.setStyle(contentObj.styles);
    }

  document.getElementById('pageForm').addEventListener('submit', function(e) {
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