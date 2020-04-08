<?php 


main();


function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';
	// line below stopped working on CSIS server
	// $json_string = file_get_contents($apiCall); 
	$json_string = curl_get_contents($apiCall);
	$obj = json_decode($json_string);
	$data = $obj->Countries;
	
    usort($data, 'comparator');
    
    $i;
    
    //print_r($data);

	// echo html head section
	echo '<html>';
	echo '<head>';
	echo '<meta charset="utf-8">';
    echo '<link   href="css/bootstrap.min.css" rel="stylesheet">';
    echo '<script src="js/bootstrap.min.js"></script>';
	echo '</head>';
	
	// open html body section
	echo '<body>';
	
	
	echo '
	<div class="container">
	<div class="row">
                <h3>Covid-19 Cases</h3>
    </div>
	<div class="row">
	<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Country</th>
                <th>Number of cases</th>
            </tr>
        </thead>
        <tbody>';
        
    $i = 0;
        
    foreach($data as $row){
        
        echo '<tr>';
        echo '<td>'. $row->Country . '</td>';
        echo '<td>'. $row->TotalConfirmed . '</td>';
        echo '</tr>';
        
        $i++;
        if($i == 10){
            break;
        }
    }
        
    echo '</tbody>
    </table>
    </div>
    </div>';
	
	
	
	// close html body section
	echo '</body>';
	echo '</html>';
}

function comparator($object1, $object2) { 
    return $object1->TotalConfirmed < $object2->TotalConfirmed; 
} 


#-----------------------------------------------------------------------------
// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>



