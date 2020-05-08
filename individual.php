
<?php
// database connection
require('dbconnect.php'); 

//
//session_start();
//$_SESSION['abc'] = $_GET['hidID'];


 echo "<pre>";
 print_r($_GET['hidID']);
 echo "</pre>";

//show the table
 
try {
	
	$stmt = $dbconnect->prepare("SELECT title,content,author,published_date FROM posts
    WHERE id = :id");
    $stmt->bindValue(':id',$_GET['hidID']);
	$pun = $stmt->fetch(); 
    
} catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

?>

<?php
echo "<pre>";
 print_r($pun);
 echo "</pre>";
 ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Blog List</title>
  </head>
  <body>
   
       <div class="container">
      <div class="row">
        <div class="offset-3 col-6">

          <h1>Individual Blog</h1>
                            
					<h3 style="background-color:Tomato;">
					<?php echo $pun['title'] ?>
					</h3>
                    <p>	
                    <?php
                    echo $pun['content'];
                    ?>					
                    </p>
					<h4><?php echo $pun['author'] ?></h4>
					<p><?php echo $pun['published_date'] ?></p>	
    
        </div>
      </div>
    </div>
   
</body>
</html>
