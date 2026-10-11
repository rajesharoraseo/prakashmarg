<?php
namespace PrakashMarg\Core\Entities\Scripture;

use PrakashMarg\Core\Container\Container;
use PrakashMarg\Core\Container\ServiceProviderInterface;

if ( ! defined( 'ABSPATH' ) ) exit;

class ScriptureServiceProvider implements ServiceProviderInterface {
    public function register( Container $container ) {
        // Register specific scripture services or repositories if they override base implementations
        $container->singleton( 'scripture_repository', function() { return new ScriptureRepository(); } );
        $container->singleton( 'scripture_service', function() { return new ScriptureService(); } );
    }

    public function boot( Container $container ) {
        // Hook into the central Registry Provider to declare this Entity
        add_action( 'pm_core_register_entities', [ $this, 'registerToRegistries' ] );
    }

    public function registerToRegistries( Container $container ) {
        $container->get('entity_registry')->register( 'pm_scripture', ScriptureConfig::getDefinition() );
        $container->get('metadata_registry')->register( 'pm_scripture', ScriptureMetadata::getSchema() );
        $container->get('relationship_registry')->register( 'pm_scripture', ScriptureRelationships::getRules() );
        $container->get('validation_registry')->register( 'pm_scripture', ScriptureValidation::getRules() );
        $container->get('permission_registry')->register( 'pm_scripture', ScripturePermissions::getRules() );
        $container->get('search_registry')->register( 'pm_scripture', ScriptureSearch::getMapping() );
        $container->get('analytics_registry')->register( 'pm_scripture', ScriptureAnalytics::getEvents() );
        $container->get('schema_registry')->register( 'pm_scripture', ScriptureSeo::getMapping() );
        $container->get('ai_registry')->register( 'pm_scripture', ScriptureAI::getMapping() );
        $container->get('localization_registry')->register( 'pm_scripture', ScriptureLocalization::getMapping() );
        $container->get('version_registry')->register( 'pm_scripture', ScriptureVersion::getRules() );
    }
}
