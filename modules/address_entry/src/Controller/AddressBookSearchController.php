<?php
/**
 * @file
 * Contains \Drupal\hello\HelloController.
 */

namespace Drupal\address_entry\Controller;


use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class AddressBookSearchController extends ControllerBase {

    public function searchTerm(Request $request) {
        $getRequest = json_decode($request->getContent());

        $query_search_result = db_query("SELECT *FROM {address_term} WHERE name LIKE '%".$getRequest->name."%' AND email LIKE '%".$getRequest->email."%'")->fetchAll();
        return new JsonResponse($query_search_result);
    }
}