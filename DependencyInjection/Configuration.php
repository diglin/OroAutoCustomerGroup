<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    DigitalDrink - OroCommerce
 * @copyright   2021 - Diglin (https://www.diglin.com)
 */

namespace Diglin\AutoCustomerGroupBundle\DependencyInjection;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\ConfigBundle\DependencyInjection\SettingsBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const ASSIGNMENT_CUSTOMER_GROUP = 'assignment_customer_group';

    /**
     * Returns full key name by it's last part
     *
     * @param $name string last part of the key name (one of the class cons can be used)
     *
     * @return string full config path key
     */
    public static function getConfigKeyByName($name)
    {
        return AutoCustomerGroupExtension::ALIAS . ConfigManager::SECTION_MODEL_SEPARATOR . $name;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(AutoCustomerGroupExtension::ALIAS);
        $rootNode = $treeBuilder->getRootNode();

        SettingsBuilder::append(
            $rootNode,
            [
                self::ASSIGNMENT_CUSTOMER_GROUP => ['type' => 'integer', 'value' => null],
            ]
        );

        return $treeBuilder;
    }
}
