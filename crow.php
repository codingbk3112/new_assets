<?php
$html = file_get_contents('https://www.mypetrolprice.com/diesel-price-in-india.aspx'); //get the html returned from the following url
$html_p = file_get_contents('https://www.mypetrolprice.com/petrol-price-in-india.aspx'); //get the html returned from the following url

$pokemon_doc = new DOMDocument();libxml_use_internal_errors(TRUE);
$petrol_doc = new DOMDocument();
libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned

	$pokemon_doc->loadHTML($html);
	libxml_clear_errors(); //remove errors for yucky html
	
	$petrol_doc->loadHTML($html_p);
	libxml_clear_errors(); //remove errors for yucky html
	
	
	$pokemon_xpath = new DOMXPath($pokemon_doc);
	$petrol_xpath = new DOMXPath($petrol_doc);
	

	//get all the h2's with an id
	$pokemon_row = $pokemon_xpath->query('//div[@id="mainDiv"]');
//	echo $pokemon_row->length;

	$petrol_row = $petrol_xpath->query('//div[@id="mainDiv"]');
//	echo $petrol_row->length;
	
// 	echo $pokemon_row;

    $i =0;
    $ob = array();
$output['datas'] = array();

        
        

	if($pokemon_row->length > 0){
	//	foreach($pokemon_row as $row){


		  //print_r ($pokemon_row);
   

		  for($p=0 ; $p<$petrol_row->length ;$p++){
		  
		 
		  // echo $petrol_row->item($value1)->nodeValue;
		 // echo $petrol_row->$i;
// 		 $petrol_row as $dd;

///		 echo $p_row; 
		  $data = array();  

// 			$name = $pokemon_xpath->query('//div[@class="W70 fl fnt18"]')->item(0)->nodeValue;
// 			$rate=$pokemon_xpath->query('//b[@class="fnt18"]')->item(0)->nodeValue;
		 //   $change = $pokemon_xpath->query('//div[@class="W60 fl"]')->item(0)->nodeValue;
		    	//div class="W60 fl"
		    	
		    	
		    	
		    	if ($p>=13)
		        $nnn=$pokemon_row->item($p+1)->nodeValue;
	            
	             if ($p>195)
		        $nnn=$pokemon_row->item($p+2)->nodeValue;
	            
	            if($p<13)
	            $nnn=$pokemon_row->item($p)->nodeValue;
	   
	   
	   
		    	$ppp=$petrol_row->item($p)->nodeValue;


		    	
		  //  	else $ppp=$petrol_row->item($value1-1)->nodeValue;
//			echo $row->nodeValue . "<br/>";
     //     echo $nnn."</br>"."</br>";
          $first = array(); $first_p=array();
          $first =explode(" ₹",$ppp);
          
          $first_p=explode(" ₹",$nnn);
          
          //name is ready
  //        array_push($data,$first[0]);
          
          $second = array(); $second_p=array();
          
          
         $second=explode("(",$first[1]);
         
            $second_p=explode("(",$first_p[1]);
            
            // rate is ready
//            array_push($data,$second[0]);
        
            $third = array(); $third_p=array();

          	
            //both change and change symbol ready;          	
          	$third=(explode(") ",$second[1]));
            $third_p=(explode(") ",$second_p[1]));
  
            //print_r($third);
            //remove date
  
            $fourth = array(); $fourth_p = array();
          	$fourth=(explode("-",$third[1]));
            $fourth_p=(explode("-",$third_p[1]));
          
          //  $resa=array();
            // $resa = $third[1];
  
          //  echo $fourth[0];          
            $words = preg_replace('/\d+/u', '', $fourth[0]);
            $words_p=preg_replace('/\d+/u', '', $fourth_p[0]);            
    
            //dont do for cochin and vishakhapattanam


//             if($p!=13 )   
//         {
            
//             if($p!=196)
// {            //echo $i."</br>";
             $output['datas'][$i]=array(
             "id"=>$i,
             "name" =>trim($first[0]),
            "price" =>trim($second[0]),
            "change" =>trim($third[0]),
            "symbol" =>trim($words),
            "price_d" =>trim($second_p[0]),
            "change_d" =>trim($third_p[0]),
            "symbol_d" =>trim($words_p)
		    );
		   
		   
		  // 	if($p>=190 and $p<=200){ echo $p;
		   	
		  // 	   $add=array(  
    //          "id"=>$i,
    //          "name" =>trim($first[0]),
    //         "price" =>trim($second[0]),
    //         "change" =>trim($third[0]),
    //         "symbol" =>trim($words),
    //         "price_d" =>trim($second_p[0]),
    //         "change_d" =>trim($third_p[0]),
    //         "symbol_d" =>trim($words_p)
		  //  );
            
          //  echo json_encode($add)."</br>";
		  // 	}
		   
		   $i++;
		  // } 
    //     }           
        // $i++;
        
        // else
        // $i--;
      
    //         $add=array(  
    //          "id"=>$i,
    //          "name" =>trim($first[0]),
    //         "price" =>trim($second[0]),
    //         "change" =>trim($third[0]),
    //         "symbol" =>trim($words)
		  //  );
            
            
        //   print_r($data[0]."</br>");
        //   print_r($data[1]."</br>");
        //   print_r($data[2]."</br>");
        //   print_r($data[3]."</br>");
// 			echo $name; echo "</t>"; echo $rate; echo "</t>"; echo $change;
		//	echo "</br>";
			
            // array_push($data,$add);
            
           // $data[i]=$add;
            
		///	echo json_encode($add);
// 			array_push($ob,$add);
// 			print_r($output);
           
		}
		
	//	print_r($output['datas']);
// 	var_dump(
//         $output,
//       json_encode($output)
//       );
    //    header('Content-Type: application/json');
   
        echo $val= str_replace('\\/', '/', json_encode($output));

//		echo json_encode($output);
		$fp = fopen('results.json', 'w');
        fwrite($fp, json_encode($output));
        fclose($fp);
// 		echo $output;
        // echo json-encode($ob);
	}
}
?>
