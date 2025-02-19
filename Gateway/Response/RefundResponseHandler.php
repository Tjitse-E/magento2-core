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

namespace MultiSafepay\ConnectCore\Gateway\Response;

use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Sales\Api\Data\OrderPaymentInterface;
use MultiSafepay\ConnectCore\Logger\Logger;

class RefundResponseHandler implements HandlerInterface
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * CancelResponseHandler constructor.
     *
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param array $handlingSubject
     * @param array $response
     * @return $this|void
     */
    public function handle(array $handlingSubject, array $response)
    {
        $paymentDataObject = SubjectReader::readPayment($handlingSubject);
        /** @var OrderPaymentInterface $payment */
        $payment = $paymentDataObject->getPayment();
        $orderId = $payment->getOrder()->getIncrementId();

        if (!$response) {
            $this->logger->logInfoForOrder(
                $orderId,
                'Something went wrong. Order was not refunded.'
            );

            return $this;
        }

        if (isset($response['refund_id'])) {
            $payment->setTransactionId($response['refund_id']);
        }

        $this->logger->logInfoForOrder(
            $orderId,
            'Order was refunded. Refund ID: ' . $response['refund_id']
        );

        $payment->setIsTransactionClosed(true);

        return $this;
    }
}
