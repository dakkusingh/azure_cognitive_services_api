<?php

namespace Drupal\azure_cognitive_services_api\Service\Vision;

use Drupal\azure_cognitive_services_api\Service\Client;

class FacesApi {

  const API_URL = '/face/v1.0/';

  /**
   * @var Drupal\azure_cognitive_services_api\Service\Client
   */
  public $client;

  /**
   * Constructor for the Okta Users class.
   *
   * @param Drupal\azure_cognitive_services_api\Service\Client
   *   A Client.
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  // See https://westus.dev.cognitive.microsoft.com/docs/services/563879b61984550e40cbbe8d/operations/563879b61984550f3039523a
  public function detect() {}
  public function findsimilars() {}
  public function group() {}
  public function identify() {}
  public function verify() {}

}