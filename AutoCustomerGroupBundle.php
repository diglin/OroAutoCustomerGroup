<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    DigitalDrink - OroCommerce
 * @copyright   2021 - Diglin (https://www.diglin.com)
 */

namespace Diglin\AutoCustomerGroupBundle;

use Diglin\AutoCustomerGroupBundle\DependencyInjection\AutoCustomerGroupExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AutoCustomerGroupBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new AutoCustomerGroupExtension();
    }
}
