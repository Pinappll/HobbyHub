<?= $page->html ?>
<script>
    
    document.getElementById('commentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('id_user_review', <?php echo json_encode($_SESSION['user_id']); ?>);
    formData.append('id_page_review', <?php echo $idPage ?>);
    try {
        // Utilisation de fetch avec await
        let response = await fetch('/api/reviews', {
            method: 'POST',
            body: formData
        });

        // Attente de la résolution de la promesse JSON
        let data = await response.json();

        // Vérification du succès et rechargement des commentaires si succès
        if (data.status === 'success') {
            loadComments(); // Fonction pour charger les commentaires après soumission
        } else {
            alert('Erreur lors de la soumission du commentaire');
        }
    } catch (error) {
        // Gestion des erreurs
        console.error('Une erreur est survenue :', error);
        alert('Erreur lors de la soumission du commentaire');
    }
});
document.addEventListener('DOMContentLoaded', async function() {
  // Effectuer la requête lorsque le DOM est prêt
  await loadComments();
});

async function loadComments() {
    try {
        // Effectuer la requête POST
        let response = await fetch('/api/list/reviews?id_page_review= <?php echo $idPage ?>', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json' // Précise que le contenu est du JSON
            },
           
        });
        console.log(response);
        // Vérifier si la réponse est correcte
        let htmlContent = await response.text();
        console.log(htmlContent);
        const commentsList = document.getElementById('commentsList');
        commentsList.innerHTML = htmlContent;
        
    } catch (error) {
        console.error("Erreur lors du chargement des commentaires :", error);
    }
}
</script>