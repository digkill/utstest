<?php
/**
 * Created by PhpStorm.
 * User: prg
 * Date: 09.11.2016
 * Time: 16:33
 */
namespace Uts\HotelBundle\CustomPagination;

use Uts\HotelBundle\Repository\SearchResult;
use Zend\Paginator\Adapter\AdapterInterface;

class Adapter implements AdapterInterface
{
    private $repository = null;
    private $requestId = 0;
    public function __construct(SearchResult $repository, $requestId)
    {
        $this->repository = $repository;
        $this->requestId = $requestId;
    }
    /**
     * Returns a collection of items for a page.
     *
     * @param  int $offset Page offset
     * @param  int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->repository->createNewQueryForPagination($this->requestId, $offset, $itemCountPerPage);
    }
    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->repository->getTotalCountForPagination($this->requestId);
    }
}