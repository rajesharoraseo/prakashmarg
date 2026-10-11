<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureVersion {
    public static function getRules() {
        return [
            'api_version' => 'v1',
            'schema_version' => '1.0.0',
        ];
    }
}
