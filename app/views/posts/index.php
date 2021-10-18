<?php
/*
  ./app/views/posts/index.php

  Available VARIABLES: 
    - $posts: ARRAY(ARRAY(id, title, text, created_at, quote, image, category_id, catName))
    - $nbOfPages: INT
    - $pageNb: INT
*/

use Core\Functions;

?>

<div class="row">
  <div class="col-md-12 content-page">
    <!-- ADD A POST -->
    <div>
      <a href="posts/add/form.html" class="btn btn-primary">
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

    <nav aria-label="Page navigation" style="text-align: center;">
      <ul class="pagination">

        <?php if($pageNb > 1): ?>
          <li class="page-item"><a class="page-link" href="page/<?php echo $pageNb-1; ?>.html">Previous</a></li>
        <?php endif; ?>

        <?php 

          for ($i = 1; $i <= $nbOfPages; $i++):

            if($pageNb === $i):
              ?>
              <li class="page-item active"><a class="page-link" href="page/<?php echo $i; ?>.html"><?php echo $i; ?></a></li>
              <?php
            else:
              ?>
            <li class="page-item"><a class="page-link" href="page/<?php echo $i; ?>.html"><?php echo $i; ?></a></li>
            <?php
            endif;
              ?>
            <?php
          endfor;
        ?>

        <?php if($pageNb < $nbOfPages): ?>
          <li class="page-item"><a class="page-link" href="page/<?php echo $pageNb+1; ?>.html">Next</a></li>
        <?php endif; ?>
        
      </ul>
    </nav>

  </div>
</div>