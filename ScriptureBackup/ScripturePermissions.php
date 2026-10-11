<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScripturePermissions {
    public static function getRules() {
        return [
            'read' => 'public',
            'create' => 'edit_scriptures',
            'edit' => 'edit_scriptures',
            'delete' => 'delete_scriptures',
        ];
    }
}
