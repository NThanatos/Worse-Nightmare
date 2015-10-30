<?php
	session_start();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Gamers Nation</title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css"/>
        <link href="css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="js/star-rating.min.js" type="text/javascript"></script>        
    </head>
    
    <?php include 'header.inc.php'; ?>
    
    <body>
        <?php
			$imagename = "";
	
			if (isset($_GET['id'])) 
			{
				$imageid = $_GET['id'];
			} else 
			{
				header('Location: explore.php');
			}
			
			$sql = "SELECT * FROM game WHERE GameID = " . $imageid;
			if ($result = mysqli_query($connection, $sql)) 
			{
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$imagename = $row['Title'];
					$imagesrc = $row['imagePath'];
					$imagePublisher = $row['Publisher'];
					$imageYearReleased = $row['Year_Released'];
					$imagePlatform = $row['Platform'];
					$imageRegion = $row['Region'];
					$imagePrice = $row['Price'];
				}
			}
			
			$sql = "SELECT Stock FROM supplier_own_game WHERE GameID = " . $imageid;
			if ($result = mysqli_query($connection, $sql)) 
			{
				while ($row = mysqli_fetch_assoc($result)) 
				{
					$imageStock = $row['Stock'];
				}
			}			
			
			if (empty($imagename)) 
			{
				header('Location: explore.php');
			}
                        
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $gameComment = test_input($_POST["gameComment"]);
                $gameRating = $_POST["gameRating"];                
                $currentdt = date('Y-m-d H:i:s');
                $sql = "INSERT INTO review_have (GameID,UserID,Rating,Comment,TimeStamp) VALUES (?,?,?,?,?)";
                if ($statement = mysqli_prepare($connection, $sql)) {
                    mysqli_stmt_bind_param($statement, 'sssss', $imageid, $_SESSION['username'], $gameRating, $gameComment, $currentdt);
                    mysqli_stmt_execute($statement);
                }                
            }
        ?>
        
        <div class="container" style="margin: 4em auto;">
			<div class="panel panel-transparent col-md-2">
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <li>Game Title: <strong><?php echo $imagename ?></strong></li>

							<?php if(!empty($imagedesc)) { ?>
                            <li>Description: <strong><?php echo $imagedesc ?></strong></li>
                            <?php } ?>
							
                            </br>
                            
                            <li>Publisher: <strong> <?php echo $imagePublisher ?></strong></li>
                            <li>Year Released: <strong> <?php echo $imageYearReleased ?></strong></li>
                            <li>Platform: <strong> <?php echo $imagePlatform ?></strong></li>
                            <li>Region: <strong> <?php echo $imageRegion ?></strong></li>
                                                        
                            </br>

							<li>Stock: 
                            	<strong> 
									<?php 
										if(!empty($imageStock))
										{
											echo $imageStock;
										}
										else
										{
											echo "Out of Stock";
										}
									?>
                                </strong>
                            </li>
                            <li>Price: <strong> <?php echo $imagePrice ?></strong></li>
                        </ul>
                    </div>
                </div>  
            <div class="col-md-6 text-center">
                <!---
                Possible bug fix for the larger than normal image size
                <img src="<php echo $imagesrc ?>" width="100%"/>
                -->               
                <img src="<?php echo $imagesrc ?>" width="65%"/>
            </div>
			<div class="panel panel-transparent col-md-4">
				<div class="panel-body">
					<ul class="list-unstyled">
                    	<li><strong>Review:</strong></li>
						<li>
							<div>
                                    <?php
                                    $sql = "SELECT * FROM review_have WHERE GameID = \"" . $imageid . "\"";
                                    if ($result = mysqli_query($connection, $sql)) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div>';
											echo $row['Rating'] .' / 5';
                                            echo '<br>';
                                            echo '['. $row['TimeStamp'] .'] ';
											echo '<br>';
                                            echo 'By <strong>'. $row['UserID']. ':</strong>';
                                            echo '<br>';
                                            echo $row['Comment'];
                                            echo '</div>';
                                            echo '<hr>';
                                        }
                                    }
                                    ?>
                        	</div>
						</li>
						<li><br></li>
							<?php
                            if ((isset($_SESSION['username']))) {
                                if(isset($_POST["gameComment"])){
                            ?>
                            <li style="color: #3ADF00;"><strong>Successfully posted the comment!</strong></li>
                            <?php } ?>
                            <li>
                                <form class="form-horizontal" id="Updatecomment" role="form" method="post" action="imagedetail.php?id=<?php echo $imageid ?>">
                                    <div class="form-group">
                                        Comments: <br>
                                        <input id="gameRating" name="gameRating" type="number" class="rating" min=0 max=5 step=0.5 data-size="sm"><br>
                                        <textarea style="color: #606060; width:100%" rows="4" maxlength="300" name="gameComment" id="gameComment" placeholder=""></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary btn-md col-md-5"/>
                                        <p class="btn-md col-md-2"></p>
                                        <a href="index.php" class="btn btn-danger btn-md col-md-5">Cancel</a>
                                    </div>
                                </form>                                        
                            </li>
                            <?php
                            }
                            ?>  
					</ul>
            	</div>
			</div>                           
        </div>

        <?php include 'footer.inc.php'; ?>

    </body>
</html>