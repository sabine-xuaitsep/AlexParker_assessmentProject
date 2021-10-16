<?php
/*
  ./app/views/posts/postForm.php

  if available:
    VARIABLES: 
    - $post: ARRAY(id, title, text, created_at, quote, category_id, catName)
*/

$postTitle = !($post === []) ? $post['title'] : '';
$postText = !($post === []) ? $post['text'] : '';
$postQuote = !($post === []) ? $post['quote'] : '';

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
    <!-- Post Headline Start -->
    <div class="post-title">
      <h1>Post Form</h1>
    </div>
    <!-- Post Headline End -->

    <!-- Form Start -->
    <form action="posts/add/insert.html" method="post">
      <div class="form-group">
        <label for="title">Title</label>
        <input
          type="text"
          name="title"
          id="title"
          class="form-control"
          placeholder="Enter your title here"
          required="required"
          value="<?php echo $postTitle; ?>"
        />
      </div>
      <div class="form-group">
        <label for="text">Text</label>
        <textarea
          id="text"
          name="text"
          class="form-control"
          rows="5"
          placeholder="Enter your text here"
        ><?php echo $postText; ?></textarea>
      </div>
      <div class="form-group">
        <label for="exampleFormControlFile1"> Image</label>
        <input type="file" class="form-control-file btn btn-primary" id="exampleFormControlFile1">
      </div>
      <div class="form-group">
        <label for="quote">Quote</label>
        <textarea
          id="quote"
          name="quote"
          class="form-control"
          rows="5"
          placeholder="Enter your quote here"
        ><?php echo $postQuote; ?></textarea>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <select
          id="category"
          name="category_id"
          class="form-control"
        >
        <?php 
          if (!($post === [])): ?>
            <option disabled>
              Select your category
            </option>
            <?php 

            // asking all categories to categoriesModel
            include_once '../app/models/categoriesModel.php';
            $categories = App\Models\CategoriesModel\findAll($conn);
            
            foreach($categories as $cat): 

              if($post['category_id'] === $cat['id']): ?>

                <option value="<?php echo $cat['id']; ?>" selected>
                  <?php echo $cat['name']; ?>
                </option>
                
                <?php
              else: ?>
                <option value="<?php echo $cat['id']; ?>">
                  <?php echo $cat['name']; ?>
                </option>
                
                <?php
              endif; 
            
            endforeach;

          else: ?>
            <option disabled selected>
              Select your category
            </option>

            <?php 

            // asking all categories to categoriesModel
            include_once '../app/models/categoriesModel.php';
            $categories = App\Models\CategoriesModel\findAll($conn);
          
            foreach($categories as $cat): ?>

              <option value="<?php echo $cat['id']; ?>">
                <?php echo $cat['name']; ?>
              </option>

            <?php endforeach; 
          endif; 
        ?>
        </select>
      </div>
      <div>
        <input
          class="btn btn-primary"
          type="submit"
          value="submit"
        />
        <input
          class="btn btn-secondary"
          type="reset"
          value="reset"
        />
      </div>
    </form>
    <!-- Form End -->
  </div>
</div>
</div>
