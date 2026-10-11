<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureRevision {
    public static function getRules() {
        return [
            'enable_revisions' => true,
            'max_revisions' => 15,
        ];
    }
}
