<?php
namespace DEG\CustomReports\Model;

use Magento\Framework\Api\ExtensionAttribute\JoinDataInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Psr\Log\LoggerInterface as Logger;
use Magento\Framework\App\ObjectManager;


class GenericReportCollection extends \Magento\Framework\Data\Collection\AbstractDb
{
    public function __construct(EntityFactoryInterface $entityFactory,
                                Logger $logger,
                                FetchStrategyInterface $fetchStrategy,
                                AdapterInterface $connection = null,
                                ResourceConnection $resourceConnection = null)
    {
        $resourceConnection = $resourceConnection ?: ObjectManager::getInstance()->get(ResourceConnection::class);

        $connection = $resourceConnection->getConnectionByName('readonly');

        parent::__construct($entityFactory, $logger, $fetchStrategy, $connection);
    }

    /**
     * Intentionally left empty since this is a generic resource.
     */
    public function getResource(){
    }

    /**
     * @param JoinDataInterface $join
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @throws \Exception
     * @return $this
     */
    public function joinExtensionAttribute(
        JoinDataInterface $join,
        JoinProcessorInterface $extensionAttributesJoinProcessor
    ){
        throw new \Exception('joinExtensionAttribute is not allowed in GenericReportCollection');
        return $this;

    }

    /**
     * Render sql select orders
     *
     * @return  $this
     */
    protected function _renderOrders()
    {
        if (!$this->_isOrdersRendered) {
            foreach ($this->_orders as $field => $direction) {
                $this->_select->order(new \Zend_Db_Expr('\''. $field . '\' ' . $direction));
            }
            $this->_isOrdersRendered = true;
        }

        return $this;
    }

}
