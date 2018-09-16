silverstripe-ckan
=================

[![Build Status](https://travis-ci.org/shoaibali/silverstripe-ckan.svg?branch=master)](https://travis-ci.org/shoaibali/silverstripe-ckan) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/shoaibali/silverstripe-ckan/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/shoaibali/silverstripe-ckan/?branch=master)

*** WORK IN PROGRESS ***

SilverStripe CKAN (Comprehensive Knowledge Archive Network) API client 

## Requirements

* SilverStripe 3.7 (4.x coming soon!)

## Installation

The recommended way to install is [through composer](https://getcomposer.org/download/).

And run these two commands to install it:

    $ curl -sS https://getcomposer.org/installer | php -- --install-dir=bin

Create a composer.json file for your project:

    {
        "repositories": [
            {
                "type": "git",
                "url": "https://github.com/shoaibali/silverstripe-ckan.git"
            }
        ],
        "require": {
            "shoaibali/silverstripe-ckan": "*"
        },
    }

Install dependencies:

    $ composer install


## Usage

Make sure you create a new page type ``CkanPage`` and/or you can use the route ``/ckan``

    <?php

    $apiKey = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';   // CKAN API KEY, if needed / or null by default

    $client = new Ckan\CkanClient($this->CkanSource()->DataURI, $apiKey);
    $response = $client->getTags()->getData();


## CKAN API DOCs

http://docs.ckan.org/en/latest/api/index.html