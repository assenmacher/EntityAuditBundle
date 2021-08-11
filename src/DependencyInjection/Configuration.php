<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleThings\EntityAudit\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private const ALLOWED_REVISION_ID_FIELD_TYPE = [
        'string',
        'integer',
        'smallint',
        'bigint',
        'guid',
    ];

    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('simple_things_entity_audit');
        $builder->getRootNode()
            ->children()
                ->scalarNode('connection')->defaultValue('default')->end()
                ->scalarNode('entity_manager')->defaultValue('default')->end()
                ->arrayNode('audited_entities')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('global_ignore_columns')
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('table_prefix')->defaultValue('')->end()
                ->scalarNode('table_suffix')->defaultValue('_audit')->end()
                ->scalarNode('revision_field_name')->defaultValue('rev')->end()
                ->scalarNode('revision_type_field_name')->defaultValue('revtype')->end()
                ->scalarNode('revision_locale_field_name')->defaultValue('locale')->end()
                ->scalarNode('revision_table_name')->defaultValue('revisions')->end()
                ->scalarNode('revision_id_field_type')
                    ->defaultValue('integer')
                    // NEXT_MAJOR: Use enumNode() instead.
                    ->beforeNormalization()
                        ->always(static function ($value) {
                            if (null !== $value && !\in_array($value, self::ALLOWED_REVISION_ID_FIELD_TYPE, true)) {
                                @trigger_error(sprintf(
                                    'The value "%s" for the "revision_id_field_type" is deprecated'
                                    .' since sonata-project/entity-audit-bundle 1.3 and will throw an error in version 2.0.'
                                    .' You must pass one of the following values: "%s".',
                                    $value,
                                    implode('", "', self::ALLOWED_REVISION_ID_FIELD_TYPE)
                                ), \E_USER_DEPRECATED);
                            }

                            return $value;
                        })
                    ->end()
                ->end()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('username_callable')->defaultValue('simplethings_entityaudit.username_callable.token_storage')->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
