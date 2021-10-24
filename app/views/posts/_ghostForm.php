<?php
/*
  ./app/views/posts/_ghostForm.php

  available VARIABLES:
    - $id if update route
    - $_FILES['image']['name'] in $file: ARRAY(ARRAY(...)) 
    - $_POST: ARRAY(title, text, quote, image, category_id)
*/
?>

<?php if(isset($id)): ?>
  <input
    type="hidden"
    name="id"
    id="postID"
    value="<?php echo $id; ?>"
  />
<?php endif; ?>

<input
  type="hidden"
  name="title"
  id="postTitle"
  value="<?php echo htmlentities($_POST['title']); ?>"
/>

<input
  type="hidden"
  name="text"
  id="postText"
  value="<?php echo htmlentities($_POST['text']); ?>"
/>

<input
  type="hidden"
  name="image"
  id="fileName"
  value="<?php echo htmlentities($_FILES['image']['name']); ?>"
/>

<?php if(isset($_POST['quote'])): ?>
  <input
    type="hidden"
    name="quote"
    id="postQuote"
    value="<?php echo htmlentities($_POST['quote']); ?>"
  />
<?php endif; ?>

<?php if(isset($_POST['category_id'])): ?>
  <input
    type="hidden"
    name="category_id"
    id="postCatID"
    value="<?php echo $_POST['category_id']; ?>"
  />
<?php endif; ?>

