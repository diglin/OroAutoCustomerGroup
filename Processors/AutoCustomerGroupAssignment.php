<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    DigitalDrink - OroCommerce
 * @copyright   2021 - Diglin (https://www.diglin.com)
 */

namespace Diglin\AutoCustomerGroupBundle\Processors;

use Diglin\AutoCustomerGroupBundle\DependencyInjection\Configuration;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\CustomerBundle\Entity\Customer;
use Oro\Bundle\CustomerBundle\Entity\CustomerGroup;

class AutoCustomerGroupAssignment
{
    private ObjectManager $manager;
    private ConfigManager $configManager;

    public function __construct(
        ObjectManager $manager,
        ConfigManager $configManager
    ) {
        $this->manager = $manager;
        $this->configManager = $configManager;
    }

    public function assignGroup($customerId): void
    {
        $customerGroupId = $this->getDefaultCustomerGroupIdAssignment();
        $customerGroup = $this->manager->getRepository(CustomerGroup::class)->find($customerGroupId);

        $customer = $this->manager->getRepository(Customer::class)->find($customerId);

        if ($customer && $customerGroup && $customerGroup instanceof CustomerGroup) {
            $this->setGroup($customerGroup, $customer);
        }
    }

    /**
     * TODO: test on OroCommerce EE with multiple websites / organisations
     */
    protected function getDefaultCustomerGroupIdAssignment(): int
    {
        return (int)$this->configManager->get(Configuration::getConfigKeyByName(Configuration::ASSIGNMENT_CUSTOMER_GROUP));
    }

    protected function setGroup(CustomerGroup $group, Customer $customer): void
    {
        $customer->setGroup($group);
        $this->manager->persist($customer);
    }
}
