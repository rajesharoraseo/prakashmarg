<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureLifecycle {
    public static function getHooks() {
        return [
            'on_create' => [],
            'on_update' => [],
            'on_delete' => [],
        ];
    }
}
