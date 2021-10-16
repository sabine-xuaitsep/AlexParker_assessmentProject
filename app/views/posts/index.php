<?php
/*
  ./app/views/posts/index.php

  Available VARIABLES: 
    - $posts: ARRAY(ARRAY(id, title, text, created_at, quote, category_id, catName))
*/

use Core\Functions;

?>

<div class="row">
  <div class="col-md-12 content-page">
    <!-- ADD A POST -->
    <div>
      <a href="form.html" type="button" class="btn btn-primary">
        Add a Post
      </a>
    </div>
    <!-- ADD A POST END -->

    <!-- Blog Post Start -->
    <?php foreach($posts as $post): ?>
      <div class="col-md-12 blog-post">
        <div class="post-title">
          <a href="posts/<?php echo $post['id']; ?>/<?php echo Functions\slugify($post['title']); ?>.html">
            <h1>
              <?php echo $post['title']; ?>
            </h1>
          </a>
        </div>
        <div class="post-info">
          <span>
            <?php echo Functions\datify($post['created_at']); ?>
          </span> | <span>
            <?php echo $post['catName']; ?>
          </span>
        </div>
        <p>
          <?php echo Functions\truncate($post['text']); ?>
        </p>
        <a
        href="posts/<?php echo $post['id']; ?>/<?php echo Functions\slugify($post['title']); ?>.html"
        class="
        button button-style button-anim
        fa fa-long-arrow-right
        "
        >
          <span>Read More</span>
        </a>
      </div>
    <?php endforeach; ?>
    <!-- Blog Post End -->

  </div>
</div>