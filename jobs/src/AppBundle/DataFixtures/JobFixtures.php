<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

/**
 * Class JobFixtures
 *
 * @category Fixture
 * @package  AppBundle\DataFixtures
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class JobFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     *
     * @throws \Exception
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    public function load(ObjectManager $manager)
    {
        $job = new Job(
            804040,
            '10115',
            'title',
            'decription',
            new DateTime('2018-11-11T00:00:00+00:00'),
            null,
            new DateTime('2018-11-11T00:00:00+00:00')
        );
        $manager->persist($job);
        $manager->flush();
    }
}
