<?php
// database connection
require('dbconnect.php'); 


//show the table
try {
	
	$stmt = $dbconnect->query("SELECT * FROM posts");
	$posts = $stmt->fetchAll(); 
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

    <title>All Blog post</title>
  </head>
  <body>
   
       <div class="container">
      <div class="row">
        <div class="offset-2 col-8">

          <h1 style="text-align:center;">All Blog Post with first sentence</h1>
   	
   	<?php foreach ($posts as $key => $post) { ?>
                      
					<h3 style="background-color:Tomato;text-align:center;">
					<?php echo $post['title'] ?>
					</h3>
                   
            <!--Counting the first sentence-->
                    <?php
                    $pos = strpos($post['content'], '.');
                    $firstSentence = substr($post['content'], 0, $pos+1);
                    echo $firstSentence;
                    ?>
            <!--sending id to individual.php page for fetching specific data-->
                     <br><a href="individual.php?hidID=<?=$post['id']?>">read more</a>
             
					<h4 style="text-align:center;"><?php echo $post['author'] ?></h4>
					<p style="text-align:center;"><?php echo $post['published_date'] ?></p>	
    <?php } ?>
		
        </div>
      </div>
    </div>
   
</body>
</html>

