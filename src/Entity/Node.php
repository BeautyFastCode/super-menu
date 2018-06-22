<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The Node entity.
 *
 * @ORM\Table(name="nodes")
 * @ORM\Entity(repositoryClass="App\Repository\NodeRepository")
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class Node
{
    /**
     * An entity Id.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The name of an node.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Length(min=6, max=64)
     * @Assert\NotBlank()
     */
    private $name;

    /*
     * Creates a parent / child relationship on this entity,
     * fields children and parent.
     */

    /**
     * One Parent have Many Children.
     *
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Node", mappedBy="parent")
     */
    protected $children;

    /**
     * Many Children have One Parent.
     *
     * @var Node
     *
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", nullable=true)
     */
    protected $parent;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * Returns an entity Id.
     *
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns name.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets name.
     *
     * @param string $name
     *
     * @return Node
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets parent.
     *
     * @param Node $parent
     *
     * @return Node
     */
    public function setParent(Node $parent = null): Node
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Returns parent.
     *
     * @return null|Node
     */
    public function getParent(): ?Node
    {
        return $this->parent;
    }

    /**
     * Returns true if entity have children, otherwise returns false.
     *
     * @return bool
     */
    public function hasChildren(): bool
    {
        if($this->children->isEmpty()) {
            return false;
        }

        return true;
    }

    /**
     * Returns all children.
     *
     * @return null|Collection
     */
    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    /**
     * Adds one children.
     *
     * @param Node $node
     *
     * @return Node
     */
    public function addChildren(Node $node): self
    {
        if ($this->children->contains($node)) {
            return $this;
        }

        $this->children->add($node);

        return $this;
    }

    /**
     * Removes one children.
     *
     * @param Node $node
     *
     * @return Node
     */
    public function removeChildren(Node $node): self
    {
        if (!$this->children->contains($node)) {
            return $this;
        }

        $this->children->removeElement($node);

        return $this;
    }

    /**
     * Returns children ids in all tree depth.
     *
     * @return array The array of ids
     */
    public function getTreeIds(): array
    {
        $tree = [];

        if ($this->hasChildren()) {

            /** @var Node $child */
            foreach ($this->getChildren() as $child) {

                $tree[] = $child->getId();

                if ($child->hasChildren()) {
                    $tree = array_merge($tree, $child->getTreeIds());
                }
            }
        }

        return $tree;
    }

    /**
     * Returns string representation of this node.
     */
    public function __toString()
    {
        return $this->name;
    }
}
