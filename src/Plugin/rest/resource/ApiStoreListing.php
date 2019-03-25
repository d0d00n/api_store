<?php

namespace Drupal\api_store\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides a ApiStoreListing Resource
 *
 * @RestResource(
 *   id = "api_listing",
 *   label = @Translation("ApiStoreListing"),
 *   uri_paths = {
 *     "canonical" = "/api_store/api_listing"
 *   }
 * )
 */
class ApiStoreListing extends ResourceBase {
  /**
   * Responds to entity GET requests.
   * @return \Drupal\rest\JsonResponse
   */
  public function get() {
    $http_client = \Drupal::httpClient();
    $current_user = \Drupal::currentUser();
    $user = \Drupal\user\Entity\User::load($current_user->id());
    $email = $user->getEmail();

    if (!isset($_GET['lang']) ||  $_GET['lang'] !== 'fr') {
      $lang = 'en';
    } else {
      $lang = 'fr';
    }

    $config = \Drupal::config('api_store.settings');
    $listing_endpoint = $config->get('listing_endpoint');

    $res = $http_client->request('GET', $listing_endpoint, [
        'query' => [
            'lang' => $lang,
            'email' => $email
        ]
    ]);

    $output = $res->getBody();

    return new JsonResponse( json_decode($output) );
  }
}
