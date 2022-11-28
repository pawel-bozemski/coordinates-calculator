<?php
header("Access-Control-Allow-Origin: *");

function vincentyFormula(
  $latitudeA,
  $longitudeA,
  $latitudeB,
  $longitudeB,
  $earthRadius = 6371000
) {
  // convert from degrees to radians
  $latA = deg2rad($latitudeA);
  $lonA = deg2rad($longitudeA);
  $latB = deg2rad($latitudeB);
  $lonB = deg2rad($longitudeB);

  $deltaLon = $lonB - $lonA;
  $a = pow(cos($latB) * sin($deltaLon), 2) +
    pow(cos($latA) * sin($latB) - sin($latA) * cos($latB) * cos($deltaLon), 2);
  $b = sin($latA) * sin($latB) + cos($latA) * cos($latB) * cos($deltaLon);

  $angle = atan2(sqrt($a), $b);
  echo round($angle * $earthRadius);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $postData = json_decode(file_get_contents("php://input"), true);

  if ($postData['coordA']['hemisphereLat'] == 'S') {
    $postData['coordA']['lat'] = $postData['coordA']['lat'] * -1;
  }
  if ($postData['coordA']['hemisphereLong'] == 'W') {
    $postData['coordA']['long'] = $postData['coordA']['long'] * -1;
  }
  if ($postData['coordB']['hemisphereLat'] == 'S') {
    $postData['coordA']['lat'] = $postData['coordA']['lat'] * -1;
  }
  if ($postData['coordB']['hemisphereLong'] == 'W') {
    $postData['coordA']['long'] = $postData['coordA']['long'] * -1;
  }
  vincentyFormula($postData['coordA']['lat'], $postData['coordA']['long'], $postData['coordB']['lat'], $postData['coordB']['long']);
}
