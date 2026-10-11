<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureMetadata {
    public static function getSchema() {
        return [
            // Core
            'alternative_names'    => [ 'type' => 'string', 'multiple' => true ],
            'native_name'          => [ 'type' => 'string' ],
            'language'             => [ 'type' => 'string', 'default' => 'Sanskrit' ],
            'short_description'    => [ 'type' => 'string', 'max_length' => 160 ],
            
            // Text Details
            'author_sage'          => [ 'type' => 'string' ],
            'scripture_type'       => [ 'type' => 'string' ], // e.g., Veda, Purana, Itihasa, Upanishad, Stotra
            'total_verses'         => [ 'type' => 'integer' ],
            'structure_details'    => [ 'type' => 'json' ], // To store Kand, Adhyaya, Parva structure
            
            // Historical & Philosophical
            'core_philosophy'      => [ 'type' => 'string' ],
            'historical_period'    => [ 'type' => 'string' ],
            
            // Media
            'pdf_download_link'    => [ 'type' => 'url' ],
            'audio_chant_url'      => [ 'type' => 'url' ],
        ];
    }
}
