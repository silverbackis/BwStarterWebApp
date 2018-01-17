<?php

namespace App\DataFixtures\Page;

use Doctrine\Common\Persistence\ObjectManager;
use Silverback\ApiComponentBundle\DataFixtures\Page\AbstractPage;

class GalleryPage extends AbstractPage
{
    /**
     * @param ObjectManager $manager
     * @throws \BadMethodCallException
     */
    public function load(ObjectManager $manager)
    {
        parent::load($manager);

        $this->entity->setTitle('Gallery');
        $this->entity->setMetaDescription('Image gallery component');
        $this->addHero('Gallery', 'Here you can see an image gallery');
        $this->addGallery();

        $this->flush();
        $this->addReference('page.gallery', $this->entity);
    }
}
