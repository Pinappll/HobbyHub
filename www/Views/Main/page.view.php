<?= $page->html ?>
<script>
    document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Form submitted');
    debugger;
    let formData = new FormData(this);

    fetch('/api/comments', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadComments(); // Charge les commentaires après soumission
        } else {
            alert('Erreur lors de la soumission du commentaire');
        }
    });
});
function loadComments() {
    fetch('/api/comments?page_id=' + pageId)
        .then(response => response.json())
        .then(data => {
            let commentsList = document.getElementById('commentsList');
            commentsList.innerHTML = '';
            data.comments.forEach(comment => {
                let commentItem = document.createElement('div');
                commentItem.textContent = comment.comment_text;
                commentsList.appendChild(commentItem);
            });
        });
}

document.addEventListener('DOMContentLoaded', function() {
    loadComments();
});

</script>