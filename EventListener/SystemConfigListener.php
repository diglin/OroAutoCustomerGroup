<?php

declare(strict_types=1);

namespace Diglin\AutoCustomerGroupBundle\EventListener;

use Doctrine\Persistence\ManagerRegistry;
use Diglin\AutoCustomerGroupBundle\DependencyInjection\AutoCustomerGroupExtension;
use Diglin\AutoCustomerGroupBundle\DependencyInjection\Configuration;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\ConfigBundle\Event\ConfigSettingsUpdateEvent;
use Oro\Bundle\CustomerBundle\Entity\CustomerGroup;

class SystemConfigListener
{
    protected ManagerRegistry $registry;

    protected string $ownerClass;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function onFormPreSetData(ConfigSettingsUpdateEvent $event): void
    {
        $settingsKey = implode(ConfigManager::SECTION_VIEW_SEPARATOR, [AutoCustomerGroupExtension::ALIAS, Configuration::ASSIGNMENT_CUSTOMER_GROUP]);
        $settings = $event->getSettings();
        if (is_array($settings)
            && !empty($settings[$settingsKey]['value'])
        ) {
            $settings[$settingsKey]['value'] = $this->registry
                ->getManagerForClass(CustomerGroup::class)
                ->find(CustomerGroup::class, $settings[$settingsKey]['value']);
            $event->setSettings($settings);
        }
    }

    public function onSettingsSaveBefore(ConfigSettingsUpdateEvent $event): void
    {
        $settings = $event->getSettings();

        if (!array_key_exists('value', $settings)) {
            return;
        }

        if (!is_a($settings['value'], CustomerGroup::class)) {
            return;
        }

        /** @var object $owner */
        $owner = $settings['value'];
        $settings['value'] = $owner->getId();
        $event->setSettings($settings);
    }
}
