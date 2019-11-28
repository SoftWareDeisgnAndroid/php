<?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



//POST 값을 읽어온다.
$ID=isset($_POST['ID']) ? $_POST['ID'] : '';
$PW=isset($_POST['PW']) ? $_POST['PW'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if ($ID != "" ){

    $sql="select * from memberinfo WHERE ID ='$ID' and PW ='$PW'";
    $stmt = $con->prepare($sql);
    $stmt->execute();
 
    if ($stmt->rowCount() == 0){

        $failureMSG = "fail";
    }
	else{

   		$data = array(); 
        $sucessMSG = "login sucess";
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        	extract($row);

            array_push($data, 
                array(
                'ID'=>$row["ID"]
            ));
        }


        if (!$android) {
            echo "<pre>"; 
            print_r($data); 
            echo '</pre>';
        }else
        {
            header('Content-Type: application/json; charset=utf8');
            $json = json_encode(array("MYJSON"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            echo $json;
        }
    }
}
else {
    echo "Ask me something! ";
}

?>



<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
if(isset($sucessMSG)) echo $sucessMSG;
if(isset($failureMSG)) echo $failureMSG;
if(!$android){
    echo "this service is for android only";
}
?>
