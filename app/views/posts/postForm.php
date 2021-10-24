<?php
/*
  ./app/views/posts/postForm.php

  if available:
    VARIABLES: 
    - $post: ARRAY(id, title, text, created_at, quote, image, category_id, catName)
*/

// TODO: 
//  possibility to delete linked picture

$formAction = ($post === []) ? 'add/insert' : $post['id'] . '/' . Core\Functions\slugify($post['title']) . '/edit/update';

$postTitle = ($post === []) ? '' : htmlentities($post['title']);
$postText = ($post === []) ? '' : $post['text'];
$postQuote = ($post === []) ? '' : $post['quote'];

?>

<div class="row">
<div class="sub-title">
  <a href="" title="Go to Home Page"
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
    <form 
      action="posts/<?php echo $formAction; ?>.html"
      method="post" 
      enctype="multipart/form-data"
    >

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
          required="required"
        ><?php echo $postText; ?></textarea>
      </div>

      <?php 
        if(!($post === [] || $post['image'] === '')): ?>
          <div class="form-group">
            <label for="choosenImage">Image choisie</label>
            <div><?php echo $post['image']; ?></div>
            <input
              type="hidden"
              name="image"
              id="choosenImage"
              class="form-control"
              placeholder="Enter your title here"
              value="<?php echo $post['image']; ?>"
            />
            <div>
              <img src="images/blog/<?php echo $post['image']; ?>" alt="" style="width:25%">
            </div>
          </div>
          <?php
        endif;
      ?>
      <div class="form-group">
      <label for="image">
        Image 
        <?php 
          if(!($post === [] || $post['image'] === '')): 
            echo ' (choisir une autre)'; 
          endif; 
        ?>
      </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
        <input 
          type="file" 
          class="form-control-file btn btn-primary" 
          id="image" 
          name="image" 
          accept="image/png, image/jpeg, image/gif"
          aria-describedby="fileHelp"
        />
        <small id="fileHelp">Only .jpg, .jpeg, .png or .gif file, and max. 3 Mo</small>
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
          // asking all categories to categoriesModel
          include_once '../app/models/categoriesModel.php';
          $categories = App\Models\CategoriesModel\findAll($conn);

          // Available VARIABLES: 
          // - $categories: ARRAY(ARRAY(id, name, created_at, postsCount))

          ?>
          <option disabled <?php if($post === [] || $post['category_id'] === NULL): echo ' selected'; endif; ?>>
            Select your category
          </option>

          <?php             
            foreach($categories as $cat): 

              if($post['catName'] === $cat['name']): ?>
    
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
