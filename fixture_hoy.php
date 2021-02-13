<?php
header('Access-Control-Allow-Origin: *');
$dia=date('d');
$mes=date('m');
$anio=date('Y');
$fecha=$anio."-".$mes."-".$dia;

$ligas = array("3265","3052","1291","3053","3054","3055","3059","2656","1374","1342","1374","1342","3265","2755","2833","2790","2664","2857","1264","1250","1251","2771","2777","2656");


function fixtureDetalle($id){
	
	$curl = curl_init();

	curl_setopt_array($curl, [
		CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v2/fixtures/id/".$id."?timezone=America%2FArgentina%2FBuenos_Aires",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => [
			"x-rapidapi-host: api-football-v1.p.rapidapi.com",
			"x-rapidapi-key: 142ea3510bmsh5626fb90d592b6ep13e368jsn603aeba1b8d1"
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	return json_decode($response, true);
}	

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v2/fixtures/date/".$fecha."?timezone=America%2FArgentina%2FBuenos_Aires",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: api-football-v1.p.rapidapi.com",
		"x-rapidapi-key: 142ea3510bmsh5626fb90d592b6ep13e368jsn603aeba1b8d1"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} 


$obj = json_decode($response, true);
$final = array();
foreach($obj['api']['fixtures'] as $fixture) {
  
  
  if (in_array($fixture['league_id'], $ligas)){
	  #$array1=$array;
	  $array2 = fixtureDetalle($fixture['fixture_id']);
	  array_push($final, $array2['api']['fixtures'][0]);
	  #$array = array_merge($array1, $array2);
  }
}

header('Content-Type: application/json');	
print json_encode($final);
#print json_encode($obj['api']['fixtures']);
?>


