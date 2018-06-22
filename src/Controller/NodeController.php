<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Node;
use App\Form\NodeType;
use App\Helper\RouterHelper;
use App\Repository\NodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Main controller for this app.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class NodeController
{
    /**
     * Templating engine renders a view and returns a Response.
     *
     * @var EngineInterface
     */
    private $templating;

    /**
     * Repository for an node entity.
     *
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * The factory to create a form.
     *
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * Interface to an entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Helper for router, redirect, generate url from route name etc.
     *
     * @var RouterHelper
     */
    private $routerHelper;

    /**
     * Class constructor.
     *
     * @param EngineInterface        $templating     Templating engine renders a view and returns a Response
     * @param NodeRepository         $nodeRepository Repository for an node entity
     * @param FormFactoryInterface   $formFactory    The factory to create a form
     * @param EntityManagerInterface $entityManager  Interface to an entity manager
     * @param RouterHelper           $routerHelper   Helper for router, redirect, generate url from route name etc
     */
    public function __construct(
        EngineInterface $templating,
        NodeRepository $nodeRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RouterHelper $routerHelper
    )
    {
        $this->templating = $templating;
        $this->nodeRepository = $nodeRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->routerHelper = $routerHelper;
    }

    /**
     * List of all root nodes.
     *
     * @Route("/", name="root")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function root(): Response
    {
        $menu = $this
            ->nodeRepository
            ->findBy(
                ['parent' => null]
            );

        return $this
            ->templating
            ->renderResponse('menu/index.html.twig', ['menu' => $menu]);
    }

    /**
     * Create one Node.
     *
     * @Route("/create", name="node_create")
     * @Method({"GET","POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $node = new Node();
        $form = $this->formFactory->create(NodeType::class, $node);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($node);
            $this->entityManager->flush();

            return $this->routerHelper->redirectToRoute('root');
        }

        return $this
            ->templating
            ->renderResponse('node/create.html.twig', [
                'node' => $node,
                'form' => $form->createView(),
            ]);
    }

    /**
     * Edit selected Node.
     *
     * @Route("/{id}/edit", name="node_edit", requirements={"id"="\d+"})
     * @Method({"GET","POST"})
     *
     * @param Request $request
     * @param Node    $node
     *
     * @return Response
     */
    public function edit(Request $request, Node $node): Response
    {
        $form = $this->formFactory->create(NodeType::class, $node);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();

            return $this->routerHelper->redirectToRoute('root');
        }

        return $this
            ->templating
            ->renderResponse('node/edit.html.twig', [
                'node' => $node,
                'form' => $form->createView(),
            ]);
    }

    /**
     * Delete one Node.
     *
     * @Route("/{id}/delete", name="node_delete", requirements={"id"="\d+"})
     * @Method({"GET", "DELETE"})
     *
     * @param Node $node
     *
     * @return Response
     */
    public function delete(Node $node): Response
    {
        /*
         * Assign all children to parent in this Node.
         */
        if ($node->hasChildren()) {

            /** @var Node $child */
            foreach ($node->getChildren() as $child) {
                $child->setParent($node->getParent());
            }
        }

        /*
         * Remove the Node.
         */
        $this->entityManager->remove($node);
        $this->entityManager->flush();

        return $this->routerHelper->redirectToRoute('root');
    }
}
