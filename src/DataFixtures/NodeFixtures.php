<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Node;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixture for the Node entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class NodeFixtures extends Fixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        /*
         * Root A
         */
        $rootA = $this->nodeFactory('Root A');
        $manager->persist($rootA);

        for ($i = 0; $i < 2; ++$i) {
            $manager->persist($this->nodeFactory('Menu ' . $i, $rootA));
        }

        /*
         * Multi level menu
         */
        $menuA = $this->nodeFactory('Menu A', $rootA);
        $manager->persist($menuA);

        $menuB = $this->nodeFactory('Sub Menu B', $menuA);
        $manager->persist($menuB);

        $menuC = $this->nodeFactory('Sub Sub Menu C', $menuB);
        $manager->persist($menuC);

        $menuC2 = $this->nodeFactory('Sub Sub Menu C2', $menuB);
        $manager->persist($menuC2);

        $menuD = $this->nodeFactory('Sub Sub Sub Menu D', $menuC);
        $manager->persist($menuD);

        $menuE = $this->nodeFactory('Sub Sub Sub Sub Menu E', $menuD);
        $manager->persist($menuE);

        $menuF = $this->nodeFactory('Sub Sub Sub Sub Sub Menu F', $menuE);
        $manager->persist($menuF);

        /*
         * Root B
         */
        $rootB = $this->nodeFactory('Root B');
        $manager->persist($rootB);

        $menuX = $this->nodeFactory('Menu X', $rootB);
        $manager->persist($menuX);

        $menuY = $this->nodeFactory('Menu Y', $rootB);
        $manager->persist($menuY);

        $menuZ = $this->nodeFactory('Menu Z', $rootB);
        $manager->persist($menuZ);

        $menuV = $this->nodeFactory('Menu V', $rootB);
        $manager->persist($menuV);

        /*
         * Flush
         */
        $manager->flush();

        return;
    }

    /**
     * Node factory
     *
     * @param string    $nodeName
     * @param null|Node $parent
     *
     * @return Node
     */
    private function nodeFactory(string $nodeName, Node $parent = null): Node
    {
        $nodeA = new Node();
        $nodeA
            ->setName($nodeName)
            ->setParent($parent);

        return $nodeA;
    }
}
