<div class="commentsList">
    <?php foreach ($reviews as $review) : ?>
        
        <div class="comment">
            <p class="commentContent"><?php echo $review['content_review']; ?></p>
            <p class="commentAuthor">Par <?php echo $review['firstname_user']; echo " " ; echo $review['lastname_user'] ?></p>
        </div>
    <?php endforeach; ?>
</div>