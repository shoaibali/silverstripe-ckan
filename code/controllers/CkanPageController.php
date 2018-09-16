<?php

class CkanPage_Controller extends Page_Controller {
    
    private static $allowed_actions = [
        'getTags',
        'index',
    ];


    public function index(SS_HTTPRequest $request) 
    {
        return [
            'Title' => 'ckan'
        ];
    }

    public function getTags() 
    {
        $tags = new ArrayList();

        if (!isset($this->CkanSource()->DataURI)) {
            return user_error("API DataURI is missing", E_USER_ERROR);
        }

        $client = new Ckan\CkanClient($this->CkanSource()->DataURI);
        $response = $client->getTags()->getData();

        
        return $response;
    }

    public function Link($action = null) 
    {
        // Construct link with graceful handling of GET parameters
        $link = Controller::join_links('ckan', $ction);

        // Allow Versioned and other extension to update $link by reference.
        $this->extend('updateLink', $link, $action);

        return $link;
    }
}