<?php
namespace PrakashMarg\Core;

if ( ! defined( 'ABSPATH' ) ) exit;

class Core {
    private $services = [];

    public function boot() {
        // Register Core Services
        $this->services['entity_registry'] = new Entities\EntityRegistry();
        
        // Register Entities
        $this->services['temple_service'] = new \PrakashMarg\Core\Entities\Temple\TempleEntity();
        $this->services['scripture_service'] = new \PrakashMarg\Core\Entities\Scripture\ScriptureEntity();
        $this->services['deity_service'] = new \PrakashMarg\Core\Entities\Deity\DeityEntity();
        $this->services['saint_service'] = new \PrakashMarg\Core\Entities\Saint\SaintEntity();
        $this->services['festival_service'] = new \PrakashMarg\Core\Entities\Festival\FestivalEntity();
        
        // Load APIs
        require_once plugin_dir_path( __FILE__ ) . 'Api/SearchEndpoint.php';
        require_once plugin_dir_path( __FILE__ ) . 'Api/ToolsEndpoint.php';

        // Initialize APIs
        new \PrakashMarg\Core\Api\SearchEndpoint();
        new \PrakashMarg\Core\Api\ToolsEndpoint();

        // Boot them
        $this->services['entity_registry']->register_cpts();
    }

    public function get( $key ) {
        return $this->services[$key] ?? null;
    }
}
