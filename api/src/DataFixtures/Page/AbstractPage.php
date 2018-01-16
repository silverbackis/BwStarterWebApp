<?php

namespace App\DataFixtures\Page;

use App\DataFixtures\AbstractFixture;
use App\DataFixtures\CustomEntityInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Silverback\ApiComponentBundle\Entity\Component\ComponentGroup;
use Silverback\ApiComponentBundle\Entity\Component\Content;
use Silverback\ApiComponentBundle\Entity\Component\Form\Form;
use Silverback\ApiComponentBundle\Entity\Component\Hero;
use Silverback\ApiComponentBundle\Entity\Page;

/**
 * Class AbstractPage
 * @package App\DataFixtures\Page
 * @author Daniel West <daniel@silverback.is>
 * @property Page $entity
 */
abstract class AbstractPage extends AbstractFixture
{
    /**
     * @var bool
     */
    protected $flushed = false;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        parent::load($manager);
        if ($this instanceof CustomEntityInterface) {
            $this->entity = $this->getEntity();
        } else {
            $this->entity = new Page();
        }
    }

    protected function addContent (array $ops = null)
    {
        if (!$ops) {
            $ops = ['5', 'medium', 'headers', 'code', 'decorate', 'link', 'bq', 'ul', 'ol'];
        }
        $textBlock = new Content();
        if ($this->entity instanceof ComponentGroup) {
            $textBlock->setGroup($this->entity);
        } else {
            $textBlock->setPage($this->entity);
        }
        $textBlock->setContent(file_get_contents('http://loripsum.net/api/' . join('/', $ops)));
        $this->manager->persist($textBlock);
        return $textBlock;
    }

    protected function addHero (string $title, string $subtitle = null)
    {
        $hero = new Hero();
        if ($this->entity instanceof ComponentGroup) {
            $hero->setGroup($this->entity);
        } else {
            $hero->setPage($this->entity);
        }
        $hero->setTitle($title);
        $hero->setSubtitle($subtitle);
        $this->manager->persist($hero);
        return $hero;
    }

    protected function addForm (string $className, string $successHandler)
    {
        $form = new Form();
        if ($this->entity instanceof ComponentGroup) {
            $form->setGroup($this->entity);
        } else {
            $form->setPage($this->entity);
        }
        $form->setClassName($className);
        $form->setSuccessHandler($successHandler);
        $this->manager->persist($form);
        return $form;
    }

    protected function flush ()
    {
        parent::flush();
        $this->flushed = true;
    }

    protected function redirectFrom (Page $redirectFrom)
    {
        if (!$this->flushed) {
            throw new \BadMethodCallException('You should only call the redirectFrom method after flushing');
        }
        $redirectFrom->getRoutes()->first()->setRedirect($this->entity->getRoutes()->first());
        $this->manager->flush();
    }
}
