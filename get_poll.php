<?php
///////////////////////////////////////////////////////////////////////////////
// Author - Ashley Ford - ashley@papermashup.com
///////////////////////////////////////////////////////////////////////////////

include('poll.class.php');

	$poll = new Poll();
	
		define("CALLBACK", $_GET['callback']); // id within the array to update for a vote
		define("POLLID", $_GET['pollid']); // unique poll id
		define("TYPE", $_GET['type']); // the request type - whether it's to update the poll or to get data
		define("UPDATEID", $_GET['updateid']); // id within the array to update for a vote
	
	// request to get poll data from file
	if(TYPE=='getpoll'){
	$polldata = $poll->getPoll(POLLID);
	$json = json_encode($polldata);
	$json = json_decode($json, true);
	}
	
	// request to update poll file
	if(TYPE=='updatepoll'){
	$polldata = $poll->updatePoll(POLLID, UPDATEID);
	$json = json_encode($polldata);
	}
	
	//send json output to the browser to be parsed by js
	echo CALLBACK.'('. $json . ')';   
	
?>