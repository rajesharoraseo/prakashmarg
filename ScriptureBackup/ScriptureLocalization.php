<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureLocalization {
    public static function getMapping() {
        return [
            'translatable_fields' => [
                'alternative_names',
                'short_description',
                'core_philosophy',
                'historical_period'
            ]
        ];
    }
}
