<?php
/*
  ./app/views/categories/index.php
*/

// asking all categories to categoriesModel
include_once '../app/models/categoriesModel.php';
$categories = App\Models\CategoriesModel\findAll($conn);

// Available VARIABLES: 
// - $categories: ARRAY(ARRAY(id, name, created_at, postsCount))
?>

<ul class="menu-link">

  <?php foreach($categories as $cat): ?>

    <li>
      <a href="categories/<?php echo $cat['id']; ?>/<?php echo Core\Functions\slugify($cat['name']); ?>.html">
        <?php echo $cat['name'] . ' [' . $cat['postsCount'] . ']'; ?>
      </a>
    </li>

  <?php endforeach; ?>

</ul>