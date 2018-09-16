<?php

class CkanSource extends DataObject implements PermissionProvider  {
	

	static $api_access = false;

    private static $db = [
        'Title' => 'Varchar',
        'DataURI' => 'Varchar',
        'APIKey' => 'Varchar(255)',
		'InfoPageLink'       => 'Text',  
    ];

	private static $field_labels = [];

	private static $summary_fields = [
		'Title',
		'DataURI',
		'APIKey',
	];

    public function canView($member = null) {
        return Permission::check('CMS_ACCESS_Ckan_view', 'any', $member);
    }

    public function canEdit($member = null) {
        return Permission::check('CMS_ACCESS_Ckan_edit', 'any', $member);
    }

    public function canDelete($member = null) {
        return Permission::check('CMS_ACCESS_Ckan_delete', 'any', $member);
    }

    public function canCreate($member = null) {
        return Permission::check('CMS_ACCESS_Ckan_create', 'any', $member);
    }

	public function providePermissions() {
		return [
			'CMS_ACCESS_Ckan_view' => 'Read an ckan source object',
			'CMS_ACCESS_Ckan_edit' => 'Edit an ckan source object',
			'CMS_ACCESS_Ckan_delete' => 'Delete an ckan source object',
			'CMS_ACCESS_Ckan_create' => 'Create an ckan source object',
		];
	}

	public function getCMSActions() {
		$actions = parent::getCMSActions();
		
		return $actions;
	}

}