<?php

namespace Drupal\azure_cognitive_services_api\Service\Vision;

use Drupal\azure_cognitive_services_api\Service\Client;
use Drupal\Core\Config\ConfigFactory;

class FacesApi {

  const API_URL = '/face/v1.0/';

  /**
   * Constructor for the Faces API class.
   */
  public function __construct(ConfigFactory $config_factory) {
    $this->client = new Client($config_factory, 'faces');
  }

  // See https://westus.dev.cognitive.microsoft.com/docs/services/563879b61984550e40cbbe8d/operations/563879b61984550f3039523a
  public function detect($photoUrl,
                         $faceId = true,
                         $faceLandmarks = false,
                         $faceAttributes = true
  ) {
    $uri = self::API_URL . 'detect';
    $params = [];

    if ($faceId) {
      $params['returnFaceId'] = true;
    }
    if ($faceLandmarks) {
      $params['returnFaceLandmarks'] = true;
    }
    if ($faceAttributes) {
      $params['returnFaceAttributes'] = implode(',', self::allowedFaceAttributes());
    }

    if (count($params) > 0) {
      $queryString = http_build_query($params);
      $uri = urldecode($uri . '?' . $queryString);
    }

    $result = $this->client->doRequest($uri, 'POST', ['url' => $photoUrl]);

    return $result;
  }

  public function findsimilars() {}
  public function group() {}
  public function identify() {}

  public function verify() {}

  private function allowedFaceAttributes() {
    return [
      'age',
      'gender',
      'smile',
      'facialHair',
      'glasses',
      'emotion',
      'hair',
      'makeup',
      'occlusion',
      'accessories',
      'blur',
      'exposure',
      'noise',
    ];
  }
}