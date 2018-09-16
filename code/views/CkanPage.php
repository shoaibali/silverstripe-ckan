<?php

class CkanPage extends SiteTree
{
    private static $db = [];

    private static $description = 'Page that shows information from a ckan (Comprehensive Knowledge Archive Network) API';

    private static $icon = 'ckan/images/ckan.png';

    private static $has_one = ['CkanSource' => 'CkanSource'];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $ckanfield = DropdownField::create('CkanSourceID', 'CkanSource', CkanSource::get()->map('ID', 'Title'))
            ->setEmptyString('(Select ckan source API)');

        $fields->addFieldToTab('Root.Main',  $ckanfield, 'Content');

        return $fields;
    }

}