<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureSearch {
    public static function getMapping() {
        return [
            'searchable_fields' => [
                'native_name' => 10,
                'alternative_names' => 8,
                'author_sage' => 5,
                'core_philosophy' => 3
            ],
            'filterable_fields' => [ 'language', 'scripture_type' ]
        ];
    }
}
