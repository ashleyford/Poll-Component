<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Poll Component</title>
<link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>

$("document").ready(function () {

 	// get poll data from file
    
	function getPoll(){
	
	// done by bearphace.
	
	// this is a comment by ashley
	// Bearphace new branch changes
	
	// yes this is it
	
	$.getJSON('get_poll.php?pollid=<?php echo $_GET['pollid'];?>&type=getpoll&callback=?', function (data) {
		
			console.log(data);
			
			//clear data
			$('#content').html('');
			
			// set global var pollid
			pollid = data[0].pollid;
			
			$("h2 span").html(data[0].pollquestion);		
			var total = 0;
			$.each(data[1], function (i, item) {
			total = parseInt(total)+parseInt(item.value);
			 });
			
			$.each(data[1], function (i, item) {
  
  			// calculate the percentage
			if( total!=0 ){	
			var percent = Math.round(parseInt(item.value) / total * 100);
			}else{
			var percent = 0;	
			}
			 $("#content").append('<tr><td>' + item.id + '</td><td>' + item.name + '</td><td>'+ item.value +'</td><td>' + percent + '%</td><td><input type="button" id="'+item.id+'" value="vote" class="btn poll_vote"/></td></tr>');	
        	});
		
   $("#total span").html('Total number of votes '+total+'');
  
    });
	
	
	};
	
	getPoll();
	
	
	// update the poll
	$('.poll_vote').live("click", function(){

		console.log($(this).attr('id'));
		console.log(pollid);
		
		 $.getJSON('get_poll.php?pollid='+pollid+'&updateid='+$(this).attr('id')+'&type=updatepoll&callback=?', function (data) {
		
			if(data.status=='1'){
				
				//alert('Poll Updated!');
				
				getPoll();
				
				
				}
		
		
		//console.log(data);
		
			});
		
		
	});
	
	
	
});


</script>


</head>





<body>

<?php include('header.php'); ?>

<div class="container">
<?php if (!$_GET['pollid']){ ?>
<h2>Enter a poll id to retrieve the results</h2>
<br/>
<form id="form" method="get" style="width:600px;"> 
		<label>Poll Id (example: <a href="?pollid=4ba8f22efcc39c39443d2eb5fc52f383"/>4ba8f22efcc39c39443d2eb5fc52f383</a>)</label>
        <input type="text" class="xlarge" name="pollid">
<input type="submit" class="btn" value="Retrieve Poll">

</form> 

<?php if (!is_array($_COOKIE['poll'])) {
	//echo "You haven't created any polls yet, when you create a poll";
} else {
	// Loop through each history entry
	?>
    
  <div class="alert alert-success">
  <h4 class="alert-success">We found Polls!</h4>
    
    <?php
	
	if(count($_COOKIE['poll'])>1){ 	
	
	echo 'Here are are a few polls you\'ve recently created:';
	
	}else{
		
    echo 'Here\'s a poll you recently created:';
		
		}
	
	echo '<br/><br/><ol>';
	
	$_COOKIE['poll'] = array_reverse($_COOKIE['poll']);
	
	foreach ($_COOKIE['poll'] AS $entry) {
		echo '<li>'.$entry['pollname'] . ' -  <a href="?pollid='.$entry['pollid'].'">' .$entry['pollid'] . '</a></li>';
	}
	
	echo '</ol></div>';
	
}



} if ($_GET['pollid']){ ?>

<h2>Poll - <span></span></h2><br/>

<?php if($_GET['status']=='created'){?>

<div class="alert alert-success">
  <h4 class="alert-success">Great success!</h4> We created a sparkly new poll for you! here's the poll id. Make sure you keep it in a safe place. You'll now need to copy the string below and paste it into the Poll component in the Sproutbuilder.<br/><br/>
  
  <input type="text" class="span4" value="<?php echo $_GET['pollid'];?>" name="pollid">
  
</div>    
<?php } ?>


<table class="table table-striped table-bordered">
  <thead>
  <tr>
    <th>#</th>
    <th>Option Name</th>
    <th>Value</th>
    <th>Percentage</th>
   </tr>
  </thead>
    <tbody id="content">
    </tbody>
</table>

 <div id="total"><span class="label label-info"></span></div>
<?php } ?>


</div>

</body>
</html>
