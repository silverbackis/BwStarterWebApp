<?php

namespace App\Factory;

use App\Entity\Component\Form\Form;
use App\Entity\Component\Form\FormView;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

class FormFactory {
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * FormDataProvider constructor.
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router
    )
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @param Form $component
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm (Form $component): FormInterface
    {
        return $this->formFactory->create(
            $component->getClassName(),
            null,
            [
                'method' => 'POST',
                'action' => $this->router->generate('api_forms_validate', [
                    'id' => $component->getId()
                ])
            ]
        );
    }

    /**
     * @param Form $component
     * @return FormView
     */
    public function createFormView (Form $component) {
        $form = $this->createForm($component);
        return new FormView($form->createView());
    }
}
