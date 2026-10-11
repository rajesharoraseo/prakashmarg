<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureConfig {
    public static function getDefinition() {
        return [
            'type'        => 'pm_scripture',
            'name'        => 'Scripture',
            'plural_name' => 'Scriptures',
            'slug'        => 'scriptures',
            'description' => 'Sacred texts, Granths, Vedas, Puranas, and Itihasas in Sanatan Dharma.',
            'status'      => [ 'draft', 'pending', 'published', 'archived', 'requires_update' ],
            'visibility'  => 'public',
            'caching'     => [ 'ttl' => 86400, 'invalidate_on' => [ 'update', 'delete' ] ],
        ];
    }
}
