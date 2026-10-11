<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureRelationships {
    public static function getRules() {
        return [
            'associated_deity'   => [ 'target' => 'pm_deity', 'type' => 'many_to_many' ],
            'associated_temple'  => [ 'target' => 'pm_temple', 'type' => 'many_to_many' ],
            'associated_festival'=> [ 'target' => 'pm_festival', 'type' => 'many_to_many' ],
            'author_saint'       => [ 'target' => 'pm_saint', 'type' => 'many_to_many' ],
        ];
    }
}
