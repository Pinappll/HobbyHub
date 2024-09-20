
<style>
  /* Structure du wrapper */
#wrapper {
  display: flex;
  height: 100vh; /* Pleine hauteur */
  overflow: hidden; /* Pour éviter les débordements */
}

#sidebar {
  width: 250px;
  background-color: #353238; /* Couleur cohérente avec le reste du site */
  color: #ffffff; /* Texte blanc */
  padding: 15px;
  overflow-y: auto; /* Pour rendre la sidebar scrollable si besoin */
}

#editor {
  flex: 1;
  overflow-y: auto;
}

/* Supprimer les marges et padding par défaut */
body, html {
  margin: 0;
  padding: 0;
}

/* Enlever la bordure */
#sidebar, #editor {
  border: none;
  outline: none;
}

/* Header */
#header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f8c630; /* Jaune clair, couleur du site */
  padding: 10px;
  border-bottom: 2px solid #92140c; /* Rouge du site */
}

.title {
  font-size: 1.5rem;
  font-weight: bold;
  color: #ffffff;
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

/* Styles des blocs */
#blocks {
  padding: 10px;
  background-color: #444444;
  color: #ffffff;
  border-radius: 5px;
}

.gjs-block {
  border: 1px solid #353238;
  padding: 10px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.gjs-block:hover {
  background-color: #5a5a5a;
}

/* Ajout de styles supplémentaires pour les sections, titres, etc. */
.section {
  padding: 20px;
  background-color: rgba(248, 198, 48, 0.2); /* Fond jaune transparent */
  border-radius: 10px;
  margin-bottom: 20px;
}

.card {
  padding: 20px;
  background-color: #ffffff;
  border: 1px solid #ddd;
  border-radius: 10px;
  margin-bottom: 20px;
}

.map iframe {
  width: 100%;
  height: 300px;
  border: none;
  border-radius: 10px;
}

</style>

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
      // Card Block
      {
        id: "responsive-card",
        label: "Card",
        content: `
          <div class="card">
          <a href="#">
            <img src="../../dist/assets/images/recettes/cake.jpg" class="card__image" alt="Card Image">
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
              <img src="../../dist/assets/images/recettes/cake.jpg" class="circular-card__image" alt="Circular Card Image">
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
          classes: ['comment-form'],
          components: `
            <form id="commentForm" class="comment-form">
              <textarea name="content_review" placeholder="Laissez un commentaire..." required></textarea>
              <button type="submit">Poster le commentaire</button>
            </form>
            <div id="commentsList"></div>`,
        },
        category: "Forms",
      },

      // Contact Form (Formulaire de Contact)
      {
        id: "contact-form",
        label: "Contact Form",
        content: {
          tagName: 'form',
          classes: ['contact-form'],
          components: `
            <form class="contact-form">
              <label for="name">Nom:</label>
              <input type="text" id="name" name="name" required>
              
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
              
              <label for="message">Message:</label>
              <textarea id="message" name="message" required></textarea>
              
              <button type="submit">Envoyer</button>
            </form>`,
        },
        category: "Forms",
      },

      
      // Hero Image Left
      {
        id: "hero-image-left",
        label: "Hero Image Left",
        content: {
          tagName: 'div',
          classes: ['hero', 'hero-left'],
          components: `
            <div class="hero hero-left" style="display: flex; align-items: center;">
              <img src="../../dist/assets/images/recettes/cake.jpg" alt="Hero Image" style="width: 50%; border-radius: 10px;">
              <div style="padding: 20px;">
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
            <div class="hero hero-right" style="display: flex; align-items: center; flex-direction: row-reverse;">
              <img src="../../dist/assets/images/recettes/cake.jpg" alt="Hero Image" style="width: 50%; border-radius: 10px;">
              <div style="padding: 20px;">
                <h2>Titre Hero</h2>
                <p>Texte descriptif du bloc hero avec l'image à droite.</p>
              </div>
            </div>`,
        },
        category: "Hero",
      },

      
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
          </section>`,
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
          </div>`,
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
              <a href="#" class="button button-primary button-sm">Button</a>
            </article>`,
        },
        category: "Basic",
      },
      {
        id: "commentForm",
        label: "Comment",
        content: {
          tagName: 'div',
          classes: ['commentFormDiv'],
          components: `
            <form id="commentForm">
              <textarea name="content_review" placeholder="Laissez un commentaire..." required></textarea>
              <button type="submit">Poster le commentaire</button>
            </form>
            <div id="commentsList"></div>`,
        },
        category: "Basic",
      },
    ],
  },
});

// Ajout dynamique des styles CSS du site dans l'éditeur
editor.on('load', () => {
  const cssLink = editor.Canvas.getDocument().createElement('link');
  cssLink.href = '/easycook-vite/dist/css/style.css'; // Lien vers les styles CSS du site
  //cssLink.href ='../../easycook-vite/dist/css/style.css';
  cssLink.rel = 'stylesheet';
  cssLink.type = 'text/css';
  editor.Canvas.getDocument().head.appendChild(cssLink);
});


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