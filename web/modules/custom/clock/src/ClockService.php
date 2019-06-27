<?php

namespace Drupal\clock;

use Guzzle\Http\Client;

class ClockService {  
  public function ClockMethod($city) {
    $app = \Drupal::config('clock.settings')->get('app');
    $client = new \GuzzleHttp\Client();
    $response = $client->get('http://worldclockapi.com/api/json/est/now?q='.$city.'&appid='.$app);
    return $response->getBody()->getContents();
  }
}
