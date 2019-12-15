<?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



//POST 값을 읽어온다.
$Building=isset($_POST['Building']) ? $_POST['Building'] : '';
$Time = isset($_POST['Time']) ? $_POST['Time'] : '';

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");



$sql="SELECT * FROM TimeTable WHERE CLASSTIME LIKE '$Time' AND CLASSBUILDING = '$Building'";
$stmt = $con->prepare($sql);
$stmt->execute();
if ($stmt->rowCount() == 0){
    $failureMSG = "fail";
    echo "fail";
}
else{
  		$data = array(); 
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        	extract($row);

            array_push($data, 
                array(
                'CLASSNAME'=>$row["CLASSNAME"],
		'CLASSBUILDING'=>$row["CLASSBUILDING"],
		'CLASSROOM'=>$row["CLASSROOM"],
		'Time'=>$row["CLASSTIME"]
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

?>



<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
if(isset($sucessMSG)) echo $sucessMSG;
if(isset($failureMSG)) echo $failureMSG;
if(!$android){
    echo "this service is for android only";
}
?>
