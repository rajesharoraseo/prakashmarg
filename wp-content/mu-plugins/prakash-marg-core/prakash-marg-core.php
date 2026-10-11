<?php
if ( ! defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/includes/Core.php';
require_once __DIR__ . '/includes/Entities/EntityRegistry.php';
require_once __DIR__ . '/includes/Entities/Temple/TempleEntity.php';
require_once __DIR__ . '/includes/Entities/Scripture/ScriptureEntity.php';
require_once __DIR__ . '/includes/Entities/Deity/DeityEntity.php';
require_once __DIR__ . '/includes/Entities/Saint/SaintEntity.php';
require_once __DIR__ . '/includes/Entities/Festival/FestivalEntity.php';

function pm_core() {
    static $instance = null;
    if ( is_null( $instance ) ) {
        $instance = new \PrakashMarg\Core\Core();
        $instance->boot();
    }
    return $instance;
}

// Boot early
add_action( 'plugins_loaded', 'pm_core' );
