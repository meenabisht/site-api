<?php

namespace Drupal\weather;

use Guzzle\Http\Client;

class WeatherService {  
  public function WeatherMethod($city) {
    $app = \Drupal::config('weather.settings')->get('app');
    $client = new \GuzzleHttp\Client();
    $response = $client->get('https://samples.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$app);
    // kint($response);
    // die();    
    // $step * round($response / $step) ;
    // $response = $response - $step * round($double_value / $step);
    if ($response->getType() == 'decimal') {
      $response = round($response,0);
      return $response;
    }    
    return $response->getBody()->getContents();
  }
}
