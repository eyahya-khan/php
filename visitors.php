<?php
// database connection
require('dbconnect.php'); 


//read more
session_start();
$_SESSION['abc'] = $_POST['hidId'];


//show the table
try {
	
	$stmt = $dbconnect->query("SELECT * FROM posts");
	$puns = $stmt->fetchAll(); 
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

    <title>Blog List</title>
  </head>
  <body>
   
       <div class="container">
      <div class="row">
        <div class="offset-3 col-6">

          <h1>All Blog Post with first sentence.</h1>
   	
   	<?php foreach ($puns as $key => $pun) { ?>
                      
					<h3 style="background-color:Tomato;">
					<?php echo $pun['title'] ?>
					</h3>
                   
            <!--Counting the first sentence-->
                    <?php
                    $pos = strpos($pun['content'], '.');
                    $firstSentence = substr($pun['content'], 0, $pos+1);
                    echo $firstSentence;
                    ?>
                    
                    <form action="#" method="post">
                    <a href="individual.php">
                <input type="hidden" name="hidId" value="<?=$pun['id']?>">
					read more
                   </a>						
                    </form>
                    
                    
					<h4><?php echo $pun['author'] ?></h4>
					<p><?php echo $pun['published_date'] ?></p>	
    <?php } ?>
		
        </div>
      </div>
    </div>
   
</body>
</html>

