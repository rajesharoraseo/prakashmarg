<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureApi {
    public static function getEndpoints() {
        return [
            'rest_base' => 'scriptures',
            'graphql_single_name' => 'scripture',
            'graphql_plural_name' => 'scriptures',
        ];
    }
}
