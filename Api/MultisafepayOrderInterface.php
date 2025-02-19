<?php
/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is provided with Magento in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * Copyright © 2021 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 *
 */

declare(strict_types=1);

namespace MultiSafepay\ConnectCore\Api;

use Magento\Sales\Api\Data\OrderInterface;

interface MultisafepayOrderInterface
{
    /**
     * GET for order api
     * @param string $orderId
     * @param string $secureToken
     * @return OrderInterface|string
     */
    public function getOrder(string $orderId, string $secureToken);
}
