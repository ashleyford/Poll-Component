<?php

class Poll{

    private $caching_path = "poll_files/";
	
	public function getPoll($pollid){
	
	if($pollid == false){
		echo 'No Poll Id';
		return;
		}			
	
	$filename = $this->caching_path . $pollid;	
	
	if(!file_exists($filename)){
	echo $filename.' No Poll File exists';
	return;
	}
		
		$content = file_get_contents($filename);
		return $content;
	}
	
		
	public function updatePoll($pollid, $id){
		
	$filename = $this->caching_path . $pollid;	
	$content = file_get_contents($filename);
	$content_array = json_decode($content, true);
	
	// update the value in the array
	$content_array[1][$id]['value'] = $content_array[1][$id]['value']+1;
	
	//print_r($content_array);
	
	$content = json_encode($content_array);
		
		$rh = fopen($filename,'w+');
		fwrite($rh,$content);
		fclose($rh);
		
	
	   $return_result = array(
			'status' => '1',
		);
	
		return $return_result;
		
	}
		
	public function createPoll($pollname, $pollquestion, $options){
	
	$pollid  = strtolower($pollname);
	$pollid .= rand(34943, 9999999);
	$pollid = md5($pollid);
	
	$filename = $this->caching_path . $pollid;	
		
		$master_array = array();
		$optionsNumber = count($options);
			
		$i=0;	
		foreach($options as $option){	
			
	// build the array of poll values etc
	$dataPoints = array(
			'id' => ''.$i.'',
			'name' => ''.$option.'',
			'value' => '0',		
			);
	
	// push the individual values into the master array
	array_push($master_array, $dataPoints);
	$i++;
	}
		
		$content_data = array(
		array(
			'pollname' => ''.$pollname.'',
			'pollid' => ''.$pollid.'',
			'pollquestion' => ''.$pollquestion.'',
			'created' => strtotime("now"),
		 ),
		
		$master_array
		
	);

	$json = json_encode($content_data);
	
	$rh = fopen($filename,'w+');
		  fwrite($rh,$json);
		  fclose($rh);
	
	
	return $pollid;

		
	}
	
	
	
	
}