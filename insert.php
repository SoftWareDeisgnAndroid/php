<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {


        $id=$_POST['id'];
        $password=$_POST['password'];

        if(empty($id)){
            $errMSG = "insert id";
        }
        else if(empty($password)){
            $errMSG = "insert your password";
        }

        if(!isset($errMSG)) 
        {
            try{
                $stmt = $con->prepare('INSERT IGNORE INTO memberinfo VALUES(:id, :password)');
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':password', $password);

                if($stmt->execute())
                {
                    $successMSG = "Added user sucessfuly";
                }
                else
                {
                    $errMSG = "Error in user adding. Duplicated ID value";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }

?>


<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
   
    if( !$android )
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                Name: <input type = "text" name = "name" />
                Country: <input type = "text" name = "country" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>
