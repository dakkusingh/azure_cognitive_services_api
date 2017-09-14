<?php

namespace Drupal\azure_emotion_api\Service;

use Drupal\azure_cognitive_services_api\Service\Client;
use Drupal\Core\Config\ConfigFactory;

class Emotion {

  const API_URL = '/emotion/v1.0/';

  /**
   * Constructor for the Emotion API class.
   */
  public function __construct(ConfigFactory $config_factory) {
    $this->client = new Client($config_factory, 'emotion');
  }

  // See https://westus.dev.cognitive.microsoft.com/docs/services/5639d931ca73072154c1ce89/operations/56f23eb019845524ec61c4d7

  public function recognize($photoUrl) {
    $uri = self::API_URL . 'recognize';
    $result = $this->client->doRequest($uri, 'POST', ['url' => $photoUrl]);
    return $result;
  }

  public function recognizeEmotionRectangles() {}
  public function recognizeInVideo() {}

}
