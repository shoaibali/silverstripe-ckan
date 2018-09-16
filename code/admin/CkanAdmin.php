<?php

class CkanAdmin extends ModelAdmin {
	
    private static $managed_models = ['CkanSource'];

    private static $url_segment = 'ckan';

    private static $menu_title = 'ckan';

    private static $menu_icon = '/ckan/images/ckan.png';



}