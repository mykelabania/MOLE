<?php

include "connect.php";
session_start("user_credentials");

$subj = $_POST['subj'];
// echo ($subj);
$card = ''; 

$getCards = "SELECT CardTitle FROM `".$subj."_cards`";
$resultCards = mysqli_query($conn, $getCards) or die (mysqli_error($getCards));



while($row = mysqli_fetch_assoc($resultCards)){
	    //iterate over all the fields
	    foreach($row as $key => $val){
	        //generate output
	        if($val != ""){
	        	$getList = "SELECT List From `".$subj."_cards` WHERE `CardTitle` = '".$val."'";
				$resultList = mysqli_query($conn, $getList) 
					or die (mysqli_error($conn));
					
	        	$card .= '<div id = "card" class="card" name="'.$val.'"> '.$val.'
							</div>';

	        }
	    }
	}
	echo ($card);
	// echo("POSITION");
	mysqli_close($conn);
?>