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
        $question = strtolower($this->input->get('q'));
        //echo $question;  
        $str = preg_split("/[\s,]+/",  $question);
        //echo $str[0];  
  
        $this->db->where('question', $question);
        $q = $this->db->get('greetings');
        $answer = "";
        if ($q->num_rows()) {
            foreach($q->result_array() as $r)
            {
                $answer = $r['answer'];
            }
        } else if(strcmp ($str[0], 'good')) {
           $answer = "Hello, Kitty! ";
           $answer .= $str[0]." ".$str[1]." I am Md Habibullah Bin Ismail. It's nice to meet you.";
        } else {
           $answer = "Hello, Kitty! ";
           $answer .= " I am Md Habibullah Bin Ismail. It's nice to meet you.";
        }
	$data['answer']= $answer;
	$response = json_encode($data);
        
	echo $response;
    
        
    }
    
    function weather()
    {
       
        $city="Delhi";
        $country="IN"; //Two digit country code
        $url="http://api.openweathermap.org/data/2.5/weather?q=".$city.",".$country."&units=metric&cnt=7&lang=en";
        $json=file_get_contents($url);
        $data=json_decode($json,true);
        //Get current Temperature in Celsius
        echo $data['main']['temp']."<br>";
        //Get weather condition
        echo $data['weather'][0]['main']."<br>";
        //Get cloud percentage
        echo $data['clouds']['all']."<br>";
        //Get wind speed
        echo $data['wind']['speed']."<br>";
        
        $question = strtolower($this->input->get('q'));
        //echo $question;  
        $str = preg_split("/[\s,]+/",  $question);
  
    }

    

}

