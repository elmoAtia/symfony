<?php

namespace Lobama\Social2Print\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Lobama\Social2PrintBundle\Entity\ScoreType;

class LoadBasicData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        $stLike = new ScoreType();
		$stLike->setOrigin('Facebook');
		$stLike->setName('Like');
		$stLike->setFactor(1);
        $manager->persist($stLike);
        
        $stComment = new ScoreType();
		$stComment->setOrigin('Facebook');
		$stComment->setName('Comment');
		$stComment->setFactor(2);
        $manager->persist($stComment);
        
        $manager->flush();
    }
}
