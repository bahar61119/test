<?php

defined('BASEPATH') OR exit('No direct script access allowed');
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
  
        $this->db->where('question',  $question);
        $q = $this->db->get('greetings');
        //echo print_r($q->result_array());
        $answer = "";
        if ($q->num_rows()) {
            foreach($q->result_array() as $r)
            {
                $answer = $r['answer'];
            }
        } else if(strcmp ($str[0], 'good')==0) {
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
  
        $question = $this->input->get('q');
        //echo $question;  
        $str = preg_split("/[\s,?]+/",  $question);
        
        $city_index = 0;
        for($i=0;$i<count($str);$i++)
        {
            if(strcmp($str[$i], "in")==0)
            {
                $city_index = $i+1;
                break;
            }
        }
        $city = "";
        
        for($i=$city_index;$i<count($str);$i++)
        {
            $city.=$str[$i]." ";
        }
        
        $city = trim($city,"?");
        $city = urlencode($city);
        
        //$country="IN"; //Two digit country code
        $url="http://api.openweathermap.org/data/2.5/weather?q=".$city."&units=metric&cnt=7&lang=en";
        
        $json=file_get_contents($url);
        //echo $json;
        $data=json_decode($json,true);
        //echo print_r($data);
        
        $answer = "";
        foreach($str as $word)
        {
            if($word == "temperature")
            {
                $answer .= $data['main']['temp']. " K";
                
                break;
            }
            else if($word == "humidity") {
                $answer .= $data['main']['humidity'];
                break;
            }
            else  if($word == "Rain"){
                if($data['weather'][0]['id']>=500 && $data['weather'][0]['id']<600)
                {
                    $answer .= "Yes";
                }
                else  $answer .= "No";
                break;
            }
            else if($word == "Clouds"){
                if($data['weather'][0]['id']>800 && $data['weather'][0]['id']<900)
                {
                    $answer .= "Yes";
                }
                else  $answer .= "No";
                break;
            }
            else if($word == "Clear"){
                if($data['weather'][0]['id']==800)
                {
                    $answer .= "Yes";
                }
                else  $answer .= "No";
                break;
            }
        }
        
        $d['answer']= $answer;
	$response = json_encode($d);
        
	echo $response;
  
    }
    
    function qa()
    {
        $question = urlencode($this->input->get('q'));
        
        $url="http://quepy.machinalis.com/engine/get_query?question=".$question;
        $json=file_get_contents($url);
        
        $answer = "";
        // echo $json;
        $data = json_decode($json);
        //echo $data->queries[0]->query;
        $query = urlencode($data->queries[0]->query);
        if($query==null) $answer = "Your majesty! Jon Snow knows nothing! So do I!";
        else {
            $target = trim($data->queries[0]->target,'?');
            //echo $target.'</br>';
            //echo $query;

            $url = "http://dbpedia.org/sparql?query=".$query."&format=json";
            $json=file_get_contents($url);

            $data = json_decode($json);
            //echo print_r($data->results->bindings);

            $lang = "xml:lang";

            //if(isset($data->results->bindings[0]->$target->$lang)) echo $data->results->bindings[0]->$target->$lang;
            $value = "value";

            
            if(count($data->results->bindings)==0) $answer = "Your majesty! Jon Snow knows nothing! So do I!";
            else if(count($data->results->bindings)==1) $answer.= $data->results->bindings[0]->$target->$value;
            else
            {
                //echo print_r($data->results->bindings);
                $flag = true;
                foreach($data->results->bindings as $row)
                {
                    if(isset($row->$target->$lang) && $row->$target->$lang=="en") 
                    {
                        $answer.= $row->$target->$value;
                        $flag = false;
                    }
                }
                if($flag) 
                {
                    $answer.= $data->results->bindings[0]->$target->$value;
                }
            }
        }
        
        $d['answer']= $answer;
	$response = json_encode($d);
        
	echo $response;
        
    }

    

}

