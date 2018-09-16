<?php
/**
 * @package ckan
 * @subpackage tests
 */

class CkanClientTest extends SapphireTest {

    public function testCkanClient(){

        $apiKey = "my_secret_api_key";
        $url = "https://data.govt.nz";

        $client = new Ckan\CkanClient($url, $apiKey);


        $this->assertEquals($apiKey, $client->getApiKey());

        $this->assertEquals($url, $client->getApiUrl());

    }

}