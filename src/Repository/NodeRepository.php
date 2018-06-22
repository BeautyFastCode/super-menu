<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Node;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Repository for the Node entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class NodeRepository extends ServiceEntityRepository
{
    /**
     * Class constructor
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Node::class);
    }

    /**
     * Returns query builder, that returns all nodes,
     * (optional) - returns only nodes without current node and its children in tree.
     *
     * @param Node $node (optional) The current node
     *
     * @return QueryBuilder
     */
    public function getNodes(Node $node = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('n');

        if ($node === null or $node->getId() === null) {
            return $queryBuilder;
        }

        /*
         * Nodes without children in tree.
         */
        foreach ($node->getTreeIds() as $id) {
            $queryBuilder
                ->andWhere(sprintf('n.id != %s', $id));
        }

        /*
         * Nodes without current (parent) node.
         */

        return $queryBuilder
            ->andWhere('n.id != :nodeId')
            ->setParameter('nodeId', $node->getId());
    }
}
