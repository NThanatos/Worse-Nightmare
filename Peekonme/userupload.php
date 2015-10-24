<?php
	require_once('../../../protected/config1.php');
	session_start();
	
	if ((!isset($_SESSION['username']))) 
	{
		header('Location: login.php');
	}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Gamers Nation</title>
                
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet"/>
    </head>
    
    <?php include 'header.inc.php'; ?>
    <body>
        
        <div class="container-fluid">
            <?php include '/include/userdetail.inc.php'; ?>
            
                <?php include '/include/mainNav.inc.php'; ?>
            </div>
                <div class="content">
                    <h1>Upload your Games <span>Share with the rest of the world your amazing game!<br>
                        </span></h1>


                    <form class="form-horizontal" id="imageDesc" method="POST" action="userupload.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label  class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">

                                <?php
                                function test_input($data) 
								{
                                    $data = trim($data);
                                    $data = stripslashes($data);
                                    $data = htmlspecialchars($data);
                                    return $data;
                                }
                                
                                // Check if a file has been uploaded
                                if (isset($_FILES['fileToUpload'])) 
								{
                                    // Connect to the database
                                    $dbLink = new mysqli('127.0.0.1', 'root', '', 'peekonmedb');
                                    // Make sure the file was sent without errors
                                    if ($_FILES['fileToUpload']['error'] == 0) 
									{
                                        if (mysqli_connect_errno()) 
										{
                                            die("MySQL connection failed: " . mysqli_connect_error());
                                        }

                                        // Gather all required data
//                                      $imageName = $dbLink->real_escape_string($_FILES['fileToUpload']['name']);
                                        $imageType = $dbLink->real_escape_string($_FILES['fileToUpload']['type']);
                                        $imageData = $dbLink->real_escape_string(file_get_contents($_FILES['fileToUpload']['tmp_name']));
                                        $imageSize = intval($_FILES['fileToUpload']['size']);

                                        $imageExt = strtolower(end(explode('.', $_FILES['fileToUpload']['name'])));
                                        $extensions = array("jpeg", "jpg", "png");

                                        if (in_array($imageExt, $extensions) == false) 
										{
                                            $msgEx = "Extension not allowed, please choose a JPEG or PNG file.";
                                            echo '<div class="alert alert-danger col-lg-12" role="alert">' . $msgEx . '</div>';
                                        } elseif (in_array($imageExt, $extensions) == True) 
										{
                                            if ($imageSize > 2097152) 
											{
                                                $msgFile = 'File size must be exactly 2 MB or smaller';
                                                echo '<div class="alert alert-danger col-lg-12" role="alert">' . $msgFile . '</div>';
                                            } else 
											{
                                                $imageDir = 'Picture/';
                                                $image = $imageDir . $_FILES['fileToUpload']['name'];
                                                move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageDir . $_FILES['fileToUpload']['name']);

                                                  /* 
												  if(is_dir("$imageDir/".$image)==false)
												  {
                                                  	move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageDir. $_FILES['fileToUpload']['name']);
                                                  }else
												  {
                                                  $new_dir="Picture/".$image.time();
                                                  rename($_FILES['fileToUpload']['tmp_name'],$new_dir);
                                                  } 
												  */

                                                $imageBroken = explode('.', $_FILES['fileToUpload']['name']);
                                                $imageExts = array_pop($imageBroken);
                                                $imageNoExts = implode('.', $imageBroken);
                                                
                                                $imagedesc = test_input($_POST['imageDesc']);
												
												$imagePublisher = test_input($_POST['imagePublisher']);
												$imageYearReleased = test_input($_POST['imageYearReleased']);
												$imagePlatform = test_input($_POST['imagePlatform']);
												$imageRegion = test_input($_POST['imageRegion']);
												$imageStock = test_input($_POST['imageStock']);
												$imagePrice = test_input($_POST['imagePrice']);
												
                                                // Create the SQL query
                                                $query = "
           	 	INSERT INTO `userimages` (
               `user_name`, `imageName`, `type_ID`,`imagePath`, `imageDesc`, `imageType`, `imageSize`, `imageData`, `imageCreated`, `imageLikes`, `Publisher`, `YearReleased`, `Platform`, `Region` , `Stock`, `Price`
           		 )
            VALUES (
               '$_SESSION[username]','{$imageNoExts}', '{$_POST['Privacy']}', '{$image}', '{$imagedesc}' , '{$imageType}', {$imageSize}, '{$imageData}', NOW(), 0, '{$imagePublisher}','{$imageYearReleased}', '{$imagePlatform}', '{$imageRegion}', '{$imageStock}', '{$imagePrice}'
            )";


                                                // Execute the query
                                                $result = $dbLink->query($query);
                                                // Check if it was successfull
                                                if ($result) 
												{
                                                    $msgSuccess = 'Success! Your file was successfully added!';
                                                    echo '<div class="alert alert-success col-lg-12" role="alert">' . $msgSuccess . '</div>';
                                                } else 
												{
                                                    $msgErrorInsert1 = 'Error! Failed to insert the file' . "<pre>{$dbLink->error}</pre>";
                                                    echo '<div class="alert alert-danger col-lg-12" role="alert">' . $msgErrorInsert1 . '</div>';
                                                }
                                            }
                                        } else 
										{
                                            $msgErrorUpload = 'An error accured while the file was being uploaded. '
                                                    . 'Error code: ' . intval($_FILES['fileToUpload']['error']);
                                            echo '<div class="alert alert-danger col-lg-12" role="alert">' . $msgErrorUpload . '</div>';
                                        }
                                    } else 
									{
                                        $msgErrorInsert2 = 'Error! Failed to insert the file';
                                        echo '<div class="alert alert-danger col-lg-12" role="alert">' . $msgErrorInsert2 . '</div>';
                                    }

                                    // Close the mysql connection
                                    $dbLink->close();
                                }
//                                } else {
//                                    $msgChoose = 'Choose a file to upload';
//                                    echo '<div class="alert alert-info col-lg-12" role="alert" >' . $msgChoose . '</div>';
//                                }
                                ?>
                                
                                <input class="col-lg-12" type="file" name="fileToUpload" id="fileToUpload">
                                

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
                                <select class="col-lg-12" name="Privacy" style="color: #606060">
                                    <option class="col-lg-12" value="1" selected>Public</option>
                                    <option class="col-lg-12" value="0">Private</option>
                                </select>   
                            </div>
                        </div>               
<!--
	Start of new Code
-->
                        
						<div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
 								 <input type="text" name="imageName" id="imageName" placeholder="Game Name">
                            </div>
                        </div>
                        
						<div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
 								 <input type="text" name="imagePublisher" id="imagePublisher" placeholder="Publisher">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
 								 <input type="text" name="imageYearReleased" id="imageYearReleased" placeholder="Year Released">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
 								 <input type="text" name="imagePlatform" id="imagePlatform" placeholder="Platform">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
 								 <input type="text" name="imageRegion" id="imageRegion" placeholder="Region">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
 								 <input type="text" name="imageStock" id="imageStock" placeholder="Game Stock">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
 								 <input type="text" name="imagePrice" id="imagePrice" placeholder="Game Price">
                            </div>
                        </div>
<!--
	End of new Code
-->                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
                                <div class="col-lg-13">
                                    <textarea style="color: #606060" rows="4" cols="52" maxlength="1000" name="imageDesc" id="imageDesc" placeholder="Description for Your Image"></textarea>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
                                <input class="col-lg-12" type="submit" value="Upload Image" name="submit">    
                            </div>
                        </div>
                        
                    </form>

                </div>
            
        </div>
        <?php include 'footer.inc.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>