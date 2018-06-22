<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Node;
use App\Repository\NodeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form's type used to build a node form.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class NodeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /*
         * Returns the initial data of the form.
         */
        /** @var Node $node */
        $node = $builder->getData();

        /*
         * Fields for build the form.
         */
        $builder
            ->add('name')
            ->add('parent', null, [
                'query_builder' => function (NodeRepository $repository) use ($node) {
                    return $repository->getNodes($node);
                },
            ]);

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Node::class,
        ]);

        return;
    }
}
