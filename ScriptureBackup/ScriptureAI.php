<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureAI {
    public static function getMapping() {
        return [
            'context_injection' => true,
            'summary_generation' => true,
        ];
    }
}
