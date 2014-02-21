<?php
/**
 * User: jonas
 * Date: 2013-03-02
 * Time: 14:56
 *
 * Use with love
 */

namespace Jonlil\CKFinderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jonlil_ckfinder');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.


        $rootNode
            ->children()
                ->scalarNode('accessKey')->defaultNull()->end()
                ->scalarNode('secret')->defaultNull()->end()
                ->scalarNode('bucket')->defaultNull()->end()
                ->scalarNode('service')->defaultValue('php')->end()
                ->booleanNode('thumbnailsEnabled')->defaultTrue()->end()
                ->booleanNode('thumbnailsFile')->defaultTrue()->end()
                ->booleanNode('directAccess')->defaultTrue()->end()
                ->booleanNode('fileDelete')->defaultTrue()->end()
                ->booleanNode('fileView')->defaultTrue()->end()
                ->booleanNode('fileRename')->defaultTrue()->end()
                ->booleanNode('fileUpload')->defaultTrue()->end()
                ->booleanNode('folderDelete')->defaultTrue()->end()
                ->booleanNode('folderRename')->defaultTrue()->end()
                ->booleanNode('folderCreate')->defaultTrue()->end()
                ->booleanNode('folderView')->defaultTrue()->end()
                ->scalarNode('baseDir')->end()
                ->scalarNode('baseUrl')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('license')
                    ->addDefaultsIfNotSet(array(
                        'name' => '',
                        'key' => ''
                    ))
                    ->children()
                        ->scalarNode('name')
                            ->defaultValue('')
                        ->end()
                        ->scalarNode('key')
                            ->defaultValue('')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
