<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureAnalytics {
    public static function getEvents() {
        return [
            'track_views' => true,
            'track_downloads' => true, // specifically for pdfs
        ];
    }
}
