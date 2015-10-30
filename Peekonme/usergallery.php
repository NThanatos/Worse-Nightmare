<?php
	session_start();
	
	if ((!isset($_SESSION['username']))) 
	{
		header('Location: login.php');
	}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Gamers Nation</title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/elastislide.css" />

        <script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	
            <div class="rg-image-wrapper">
            {{if itemsCount > 1}}
            <div class="rg-image-nav">
            <a href="#" class="rg-image-nav-prev">Previous Image</a>
            <a href="#" class="rg-image-nav-next">Next Image</a>
            </div>
            {{/if}}
            <div class="rg-image"></div>
            <div class="rg-loading"></div>
            <div class="rg-caption-wrapper">
            <div class="rg-caption" style="display:none;">
            <p></p>
            </div>
            </div>
            </div>
        </script>

    </head>
    <?php include 'header.inc.php'; ?>
    <body>
        <div class="container-fluid">
            <?php include '/include/userdetail.inc.php'; ?>

            <?php include '/include/mainNav.inc.php'; ?>
        </div>
        <?php
        $count = 0;
        $sql = "SELECT * FROM supplier_own_game WHERE Supplier_UserID = \"" . $username . "\"";
        if ($result = mysqli_query($connection, $sql)) 
		{
            while ($row = mysqli_fetch_assoc($result)) 
			{
                $count++;
            }
        }

        
            ?>

            <div class="container">
                <div class="content">
                    <h1>Your listed items for sale<span>A Place For you to sell your games</span></h1>
                    <?php if ($count != 0) { ?>
                    <div id="rg-gallery" class="rg-gallery">
                        <div class="rg-thumbs">
                            <!-- Elastislide Carousel Thumbnail Viewer -->
                            <div class="es-carousel-wrapper">
                                <div class="es-nav">
                                    <span class="es-nav-prev">Previous</span>
                                    <span class="es-nav-next">Next</span>
                                </div>
                                <div class="es-carousel">
                                    <ul>

                                        <!-- DESC cannot be empty if not will take from previous value-->

                                        <?php
                                        $sql = "SELECT * FROM supplier_own_game WHERE user_name = \"" . $username . "\"";
                                        if ($result = mysqli_query($connection, $sql)) 
										{
                                            while ($row = mysqli_fetch_assoc($result)) 
											{
                                                echo '<li>';
                                                echo '<a href="#">';
                                                echo '<img src="' . $row['imagePath'] . '" data-large="' . $row['imagePath'] . '" alt="' . $row['imageName'] . '" data-title="' . $row['imageName'] . '"/>';
                                                echo '</a>';
                                                echo '</li>';
                                            }
                                        }
                                        ?>

                                    </ul>
                                </div>
                            </div>
                            <!-- End Elastislide Carousel Thumbnail Viewer -->
                        </div><!-- rg-thumbs -->
                    </div><!-- rg-gallery -->
                    <?php
                }
                ?>
            </div><!-- content -->
        </div><!-- container -->   
        <?php include 'footer.inc.php'; ?>


          

    </body>   

</html>

