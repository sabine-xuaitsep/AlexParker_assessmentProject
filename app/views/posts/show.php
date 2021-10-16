<?php
/*
  ./app/views/posts/index.php

  Available VARIABLES: 
    - $post: ARRAY(id, title, text, created_at, quote, category_id, catName)
*/

use Core\Functions;

?>

<div class="row">
  <div class="sub-title">
    <a href="index.html" title="Go to Home Page"
      ><h2>Back Home</h2></a
    >
    <a href="#comment" class="smoth-scroll"
      ><i class="icon-bubbles"></i
    ></a>
  </div>

  <div class="col-md-12 content-page">
    <div class="col-md-12 blog-post">
      <div>
        <img src="images/blog/1.jpg" alt="">
      </div>

      <!-- Post Headline Start -->
      <div class="post-title">
        <h1>
          <?php echo $post['title']; ?>
        </h1>
      </div>
      <!-- Post Headline End -->

      <!-- Post Detail Start -->
      <div class="post-info">
        <span><?php echo Functions\datify($post['created_at'], "F d, Y"); ?></span> | <span><?php echo $post['catName']; ?></span>
      </div>
      <!-- Post Detail End -->

      <p>
        <?php echo $post['text']; ?>
      </p>

      <!-- Post Blockquote (Italic Style) Start -->
      <blockquote class="margin-top-40 margin-bottom-40">
        <p>
          <?php echo $post['quote']; ?>
        </p>
      </blockquote>
      <!-- Post Blockquote (Italic Style) End -->

      <!-- Post Buttons -->
      <div>
        <a href="posts/<?php echo $post['id']; ?>/<?php echo Functions\slugify($post['title']); ?>/edit/form.html" type="button" class="btn btn-primary"
          >Edit Post</a
        >
        <a
          href="#"
          type="button"
          class="btn btn-secondary"
          role="button"
          >Delete Post</a
        >
      </div>
      <!-- Post Buttons End -->
    </div>
  </div>
</div>