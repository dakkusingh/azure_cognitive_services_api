<?php

namespace Drupal\azure_face_api\Service;

use Drupal\azure_cognitive_services_api\Service\Client;
use Drupal\Core\Config\ConfigFactory;

/**
 *
 */
class Face {

  const API_URL = '/face/v1.0/';

  /**
   * Constructor for the Face API class.
   */
  public function __construct(ConfigFactory $config_factory) {
    $this->client = new Client($config_factory, 'face');
    $this->config = $config_factory->get('azure_face_api.settings');
  }

  /**
   * See https://westus.dev.cognitive.microsoft.com/docs/services/563879b61984550e40cbbe8d/operations/563879b61984550f3039523a.
   */
  public function detect($photoUrl,
                         $faceId = TRUE,
                         $faceLandmarks = FALSE,
                         $faceAttributes = TRUE
  ) {
    $uri = self::API_URL . 'detect';
    $params = [];

    if ($faceId) {
      $params['returnFaceId'] = TRUE;
    }
    if ($faceLandmarks) {
      $params['returnFaceLandmarks'] = TRUE;
    }
    if ($faceAttributes) {
      $allowedFaceAttributes = $this->config->get('allowed_face_attributes');
      $params['returnFaceAttributes'] = implode(',', $allowedFaceAttributes);
    }

    if (count($params) > 0) {
      $queryString = http_build_query($params);
      $uri = urldecode($uri . '?' . $queryString);
    }

    $result = $this->client->doRequest($uri, 'POST', ['url' => $photoUrl]);

    return $result;
  }

  /**
   *
   */
  public function findsimilars() {}

  /**
   *
   */
  public function group() {}

  /**
   *
   */
  public function identify() {}

  /**
   *
   */
  public function verify() {}

}
