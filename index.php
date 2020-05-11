<?php
//database connection
require('dbconnect.php');

// Delete post
if (isset($_POST['deleteBtn'])) {
  try {
    $query = "
      DELETE FROM posts
      WHERE id = :id;
    ";

    $stmt = $dbconnect->prepare($query);
    $stmt->bindValue(':id', $_POST['hidId']);
    $stmt->execute();
  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
  }
}


// Add new post
$message = '';
if (isset($_POST['addBtn'])) {
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  $author = trim($_POST['author']);

  if (empty($title) || empty($content) || empty($author)) {
    $message = 
      '<div class="alert alert-danger" role="alert">
        Title, Content, Author: All field must have value
      </div>';
  } else if(is_numeric($title) || is_numeric($content) || is_numeric($author)){
       $message = 
      '<div class="alert alert-danger" role="alert">
        Title, Content, Author: Only number is not allowed.
      </div>';
  }else if(!preg_match("/^[a-zA-Z ]*$/",$title)){
       $message = 
      '<div class="alert alert-danger" role="alert">
        Title: Only letter and whitespace are allowed.
      </div>';
  }else if(!preg_match("/^[a-zA-Z]$/",$content[0])){
       $message = 
      '<div class="alert alert-danger" role="alert">
        Content: Start with letter.
      </div>';
  }
 
    else if(!preg_match("/^[a-zA-Z ]*$/",$author)){
       $message = 
      '<div class="alert alert-danger" role="alert">
        Author: Only letter and whitespace are allowed.
      </div>';
  }else if(strlen($title) > 30){
       $message = 
      '<div class="alert alert-danger" role="alert">
    Blog title must have less than 30 characters.
      </div>';
  }else if(strlen($author)> 30){
       $message = 
      '<div class="alert alert-danger" role="alert">
        Author name must have less than 30 characters.
      </div>';
  }
    
    
    else {
    try {
      $query = "
        INSERT INTO posts (title, content, author)
        VALUES (:title, :content, :author);
      ";

      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':title', $title);
      $stmt->bindValue(':content', $content);
      $stmt->bindValue(':author', $author);
      $stmt->execute();
        
    $message = 
      '<div class="alert alert-danger" role="alert">
        Successfully uploaded.
      </div>';
        
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
  }
}


// Update blog
if (isset($_POST['updateBtn'])) { 
  $title = trim($_POST['title']);
  $post = trim($_POST['pun']);
  $author = trim($_POST['author']);

  if (empty($post)) {
    $message = 
      '<div class="alert alert-danger" role="alert">
        Blog post field must not be empty
      </div>';
  }else if (empty($title)) {
    $message = 
      '<div class="alert alert-danger" role="alert">
        Title field must not be empty
      </div>';
  }else if (empty($author)) {
    $message = 
      '<div class="alert alert-danger" role="alert">
        Author field must not be empty
      </div>';
  } else {
    try {
      $query = "
        UPDATE posts
        SET content = :post,title = :title,author = :author
        WHERE id = :id;
      ";

      $stmt = $dbconnect->prepare($query);
      $stmt->bindValue(':title', $title);
      $stmt->bindValue(':post', $post);
      $stmt->bindValue(':author', $author);
      $stmt->bindValue(':id', $_POST['id']);
      $stmt->execute();
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
  }
}


// Fetch posts to display on page
try {
  $query = "SELECT * FROM posts;";
  $stmt = $dbconnect->query($query);
  $puns = $stmt->fetchAll();
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}


// echo "<pre>";
// print_r($puns);
// echo "</pre>";
// die; // Stops executing the PHP script

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Blog administrator</title>
  </head>
  <body>

    <div class="container">
      <div class="row">
        <div class="offset-2 col-8">
          <h1 style="text-align:center;">Blog Administration</h1>

          <form action="" method="POST">
            <div class="input-group mb-3">
              <input type="text" name="title" class="form-control" placeholder="Blog tilte">
              
              <input type="text" name="content" class="form-control" placeholder="Blog content">
              
              <input type="text" name="author" class="form-control" placeholder="Author name">
              
              <div class="input-group-append">
                <input type="submit" name="addBtn" value="Add" class="btn btn-outline-secondary" id="button-addon2">
              </div>
            </div>
          </form>

          <?=$message?>

          <h3>Blog Post list</h3>

          <ul class="list-group">
            <?php foreach ($puns as $key => $pun) { ?>
              <li class="list-group-item">
                <p class="float-left">
                  <h3><?=htmlentities($pun['title'])?></h3>
                  <?=htmlentities($pun['content'])?>  
                  <h4><?=htmlentities($pun['author'])?></h4>
                  <?=htmlentities($pun['published_date'])?>
                <p>
                
                <form action="" method="POST" class="float-right">
                  <input type="hidden" name="hidId" value="<?=$pun['id']?>">
                  <input type="submit" name="deleteBtn" value="Delete" class="btn btn-danger">
                </form>

                <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#exampleModal" data-title="<?=htmlentities($pun['title'])?>" data-author="<?=htmlentities($pun['author'])?>" data-pun="<?=htmlentities($pun['content'])?>" data-id="<?=htmlentities($pun['id'])?>">Update</button>
              </li>
            <?php } ?>
            
          </ul>
        </div>
      </div>
    </div>

   
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color:lightblue;" >
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Update Blog</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
                <div class="form-group">
                  
                  <label for="recipient-name" class="col-form-label">Update Title: </label>
                  <input type="text" class="form-control" name="title" for="recipient-name">
                
                  <label for="recipient-name" class="col-form-label">Update content: </label>  
                  <input type="text" class="form-control" name="pun" for="recipient-name">
                  
                  <label for="recipient-name" class="col-form-label">Update author: </label>  
                  <input type="text" class="form-control" name="author" for="recipient-name">
                 
                  <input type="hidden" class="form-control" name="id">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="updateBtn" value="Update" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <script>
  

  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var title = button.data('title'); // Extract info from data-* attributes
    var pun = button.data('pun'); // Extract info from data-* attributes
    var author = button.data('author'); // Extract info from data-* attributes
    var id = button.data('id'); // Extract info from data-* attributes
   
    var modal = $(this);
    modal.find(".modal-body input[name='title']").val(title);
    modal.find(".modal-body input[name='pun']").val(pun);
    modal.find(".modal-body input[name='author']").val(author);
    modal.find(".modal-body input[name='id']").val(id);
  });
</script>

<style>
    {
        background-color: #efebe5;
    }      
</style>
</body>
</html>