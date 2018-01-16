<?php

namespace App\EntityListener;

use App\Entity\Component\Form\Form;
use App\Factory\FormFactory;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

class FormListener
{
    /**
     * @var FormFactory
     */
    private $formFactory;

    public function __construct(
        FormFactory $formFactory
    )
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @ORM\PreUpdate()
     * @param Form $form
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate (Form $form, PreUpdateEventArgs $event): void
    {
        $this->setForm($form);
    }

    /**
     * @ORM\PostLoad()
     * @param Form $form
     * @param LifecycleEventArgs $event
     */
    public function postLoad (Form $form, LifecycleEventArgs $event): void
    {
        $this->setForm($form);
    }

    private function setForm (Form $form)
    {
        $form->setForm($this->formFactory->createFormView($form));
    }
}