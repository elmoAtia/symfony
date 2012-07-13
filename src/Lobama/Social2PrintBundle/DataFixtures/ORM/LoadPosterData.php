<?php

namespace Lobama\Social2Print\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Lobama\Social2PrintBundle\Entity\PosterFormat;
use Lobama\Social2PrintBundle\Entity\PosterOrderID;

class LoadPosterData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $big = new PosterFormat();
        $big->setPid('P01');
        $big->setName('BIG Poster');
        $big->setHerotag('Format: 600 x 400 mm');
        $big->setKsp1('Fineart-Druck auf Fotopapier');
        $big->setKsp2('Fotopapier 230 g/m²');
        $big->setPrice('14.90');
            $cb_big = new PosterOrderID();
            $cb_big->setProvider('cleverbridge');
            // $cb_big->setOrderid('97528');
            $cb_big->setOrderid('98222');
            $cb_big->setPosterFormat($big);
            $big->addPosterOrderID($cb_big);
        $manager->persist($big);
        
        $xxl = new PosterFormat();
        $xxl->setPid('P02');
        $xxl->setName('XXL Poster');
        $xxl->setHerotag('Format: 900 x 600 mm');
        $xxl->setKsp1('Fineart-Druck auf Fotopapier');
        $xxl->setKsp2('Fotopapier 230 g/m²');
        $xxl->setPrice('19.90');
            $cb_xxl = new PosterOrderID();
            $cb_xxl->setProvider('cleverbridge');
            // $cb_xxl->setOrderid('97529');
            $cb_xxl->setOrderid('98222');
            $cb_xxl->setPosterFormat($xxl);
            $xxl->addPosterOrderID($cb_xxl);
        $manager->persist($xxl);
        
        $basic = new PosterFormat();
        $basic->setPid('P03');
        $basic->setName('Basic Poster');
        $basic->setHerotag('Format: 450 x 300 mm');
        $basic->setKsp1('Fineart-Druck auf Fotopapier');
        $basic->setKsp2('Fotopapier 230 g/m²');
        $basic->setPrice('9.90');
            $cb_basic = new PosterOrderID();
            $cb_basic->setProvider('cleverbridge');
            // $cb_basic->setOrderid('97530');
            $cb_basic->setOrderid('98222');
            $cb_basic->setPosterFormat($basic);
            $basic->addPosterOrderID($cb_basic);
        $manager->persist($basic);
        
        // Flush to DB
        $manager->flush();
    }
}
