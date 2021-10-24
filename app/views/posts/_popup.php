<?php
/*
  ./app/views/posts/_popup.php

  Available VARIABLES: 
  - $post: ARRAY(id, title, text, created_at, quote, image, category_id)
*/
?>

<!-- Endpage Box (Popup When Scroll Down) Start -->
<div id="scroll-down-popup" class="endpage-box">

  <h4>Read Also</h4>

  <a href="posts/<?php echo $post['id']; ?>/<?php echo Core\Functions\slugify($post['title']); ?>.html">
    <?php echo $post['title']; ?>
  </a>
  
</div>
<!-- Endpage Box (Popup When Scroll Down) End -->
