<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureSeo {
    public static function getMapping() {
        return [
            'schema_type' => 'Book',
            'title_field' => 'native_name',
            'description_field' => 'short_description',
            'author_field' => 'author_sage',
        ];
    }
}
