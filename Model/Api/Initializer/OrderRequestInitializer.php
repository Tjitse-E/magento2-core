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

namespace MultiSafepay\ConnectCore\Model\Api\Initializer;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use MultiSafepay\Api\Transactions\TransactionResponse;
use MultiSafepay\ConnectCore\Factory\SdkFactory;
use MultiSafepay\ConnectCore\Model\Api\Builder\OrderRequestBuilder;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\InvalidApiKeyException;
use Psr\Http\Client\ClientExceptionInterface;

class OrderRequestInitializer
{
    /**
     * @var SdkFactory
     */
    private $sdkFactory;

    /**
     * @var OrderRequestBuilder
     */
    private $orderRequestBuilder;

    /**
     * OrderRequestInitializer constructor.
     *
     * @param OrderRequestBuilder $orderRequestBuilder
     * @param SdkFactory $sdkFactory
     */
    public function __construct(
        OrderRequestBuilder $orderRequestBuilder,
        SdkFactory $sdkFactory
    ) {
        $this->orderRequestBuilder = $orderRequestBuilder;
        $this->sdkFactory = $sdkFactory;
    }

    /**
     * @param $order
     * @return TransactionResponse
     * @throws ClientExceptionInterface
     * @throws InvalidApiKeyException
     * @throws ApiException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function initialize($order): TransactionResponse
    {
        $multiSafepaySdk = $this->sdkFactory->get();
        $transactionManager = $multiSafepaySdk->getTransactionManager();
        return $transactionManager->create($this->orderRequestBuilder->build($order));
    }
}
