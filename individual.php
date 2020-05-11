
<?php
// database connection
require('dbconnect.php'); 

//show specific data
try {
	$stmt = $dbconnect->prepare("SELECT title,content,author,published_date FROM posts
    WHERE id = :id");
    $stmt->bindValue(':id',$_GET['hidID']);
    $stmt->execute();
	$post = $stmt->fetch(); 
    
} catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Indivisual blog post</title>
  </head>
  <body>
   
       <div class="container" style="text-align:center;">
      <div class="row">
        <div class="offset-3 col-6">

          <h1>Individual Blog deatils</h1>
                            
					<h3 style="background-color:lightblue;">
					<?php echo $post['title'] ?>
					</h3>
                    <p style="text-align:justify;text-indent: 50px;">	
                    <?php
                    echo $post['content'];
                    ?>					
                    </p>
					<h4 style="text-align:right;"><?php echo $post['author'] ?></h4>
					<p style="text-align:right;"><?php echo $post['published_date'] ?></p>	
    
        </div>
      </div>
    </div>
   
</body>
</html>
