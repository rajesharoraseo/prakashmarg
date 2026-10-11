<?php
namespace PrakashMarg\Core\Entities\Scripture;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureValidation {
    public static function getRules() {
        return [
            'native_name' => 'required|string',
            'scripture_type' => 'required|string',
            'total_verses' => 'nullable|integer|min:0',
            'pdf_download_link' => 'nullable|url',
        ];
    }
}
