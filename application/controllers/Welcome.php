<?php

require(APPPATH . '/libraries/REST_Controller.php');

class Welcome extends CI_Controller {

    function index() {
        $data['answer'] = 'Hello, Kitty! rest_of_your_answer';
		
		$response = json_encode($data);
		echo $response;
    }
    
    function greetings()
    {
        $question = $this->input->get('q');
                
        $data = preg_split("/[\s,]+/    ",  $question);
		
	$response = "Hello, Kitty! ".;
        
        
	echo $response;
        
	}

    

}

