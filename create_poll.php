<?php
///////////////////////////////////////////////////////////////////////////////
// Author - Ashley Ford - ashley@papermashup.com
///////////////////////////////////////////////////////////////////////////////

include('poll.class.php');

	$poll = new Poll();	
	
	if($_POST['createPoll']){
			
	$pollname = $_POST['pollname'];
	$pollquestion = $_POST['pollquestion'];
	
	$array[] = $_POST['option0'];
	$array[] = $_POST['option1'];
	$array[] = $_POST['option2'];
	$array[] = $_POST['option3'];
	$array[] = $_POST['option4'];
	$array[] = $_POST['option5'];
	$array[] = $_POST['option6'];
	$array[] = $_POST['option7'];
	$array[] = $_POST['option8'];
	$array[] = $_POST['option9'];
	$array[] = $_POST['option10'];
	$array = array_filter($array);
	
	if($pollname==''){ $errors[]  = 'Please give your poll a name!';}
	if(count($array)<2){ $errors[]  = 'Please fill in at least two poll options!';}
	if($pollquestion==''){ $errors[]  = 'Your poll needs to have a question for it to be a poll!';}		
	


	
	if(!$errors){
	
	$pollid = $poll->createPoll($pollname, $pollquestion, $array);
	

// Create MD5 signature of current pollid
$md5sig = md5($pollid);

// Set cookies of current poll
setcookie ("poll[" . $md5sig . "][pollid]", $pollid, time() + (6000*6000));
setcookie ("poll[" . $md5sig . "][pollname]", $pollname, time() + (6000*6000));
//setcookie ("poll[" . $md5sig . "][count]", intval($_COOKIE['history'][$md5sig]['count']) + 1, time() + (6000*6000));

function iif($expression, $returntrue, $returnfalse = '') {
	return ($expression ? $returntrue : $returnfalse);
}

	
	if($pollid){
		header('Location: index.php?pollid='.$pollid.'&status=created') ;
		}
	}
	
	
	
	
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Create a poll</title>
<link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>

<body>


<?php include('header.php'); ?>

<div class="container">

<h2>Create a new poll</h2><br/>




<?php if($errors){ ?>
<div class="alert alert-block">
  <h4 class="alert-heading">Hold up cowboy!</h4>
  <ul> 
 <?php  
 foreach($errors as $error){
 
 echo '<li>'.$error.'</li>'; 
 
 } ?>
</ul>
</div>
<?php } ?>


<form id="myForm" method="post" style="width:400px;"> 
		<label>Poll Name</label>
        <input type="text" value="<?php echo $_POST['pollname'];?>" name="pollname">
    	<label>Poll Question</label>
        <input type="text" value="<?php echo $_POST['pollquestion'];?>" name="pollquestion">
        <fieldset id="polloptions">
        <label>Poll Option <a href="javascript:addOption();">Add poll option</a></label>
        <input type="text" value="<?php echo $_POST['option0'];?>" name="option0"> 
        <input type="text" value="<?php echo $_POST['option1'];?>" name="option1"> 
</fieldset>

 <input type="submit" name="createPoll" class="btn" value="Create Poll">

</form> 


<script> 
        var optionNumber = 2; //The first option to be added is number 3 
        function addOption() { 
		
		if(optionNumber<10){
		
                var theForm = document.getElementById("polloptions"); 
                var newOption = document.createElement("input"); 
                newOption.name = "option"+optionNumber; // poll[optionX]
                newOption.type = "text";
                theForm.appendChild(newOption); 
                optionNumber++;
				
		}
				
        } 
</script>

</div>


</body>
</html>

