<?php

namespace Imanee\Tests;

use Imanee\Imanee;
use Imanee\PixelMath;
use PHPUnit_Framework_TestCase;

class PixelMathTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PixelMath
     */
    private $pixelMath;

    public function setUp()
    {
        $this->pixelMath = new PixelMath();
    }

    /**
     * This test test both best fit and max fit since the are expected to
     * behave the same when dimensions match
     */
    public function testShouldReturnDimensionsThatExactlyFitInTargetImage()
    {
        $this->assertEquals(
            array(
                'width' => 100,
                'height' => 80
            ),
            $this->pixelMath->getBestFit(
                100,
                80,
                1000,
                800
            )
        );

        $this->assertEquals(
            array(
                'width' => 100,
                'height' => 80
            ),
            $this->pixelMath->getMaxFit(
                100,
                80,
                1000,
                800
            )
        );
    }

    public function testShouldReturnDimensionsUsingTargetDimensionsAsAMaximumWhenProportionsDoNotMatch()
    {
        $this->assertEquals(
            array(
                'width' => 20,
                'height' => 80
            ),
            $this->pixelMath->getBestFit(
                100,
                80,
                200,
                800
            )
        );
    }

    public function testShouldReturnDimensionsUsingTargetDimensionsAsAMinimumWhenProportionsDoNotMatch()
    {
        $this->assertEquals(
            array(
                'width' => 800,
                'height' => 100
            ),
            $this->pixelMath->getMaxFit(
                80,
                100,
                1600,
                200
            )
        );
    }

    /**
     * @dataProvider coordinatesProvider
     */
    public function testShouldReturnCorrectCoordinatesForEachPosition(array $resourceSize, array $size, $position, $expectedCoordinates)
    {
        $this->assertEquals(
            $expectedCoordinates,
            $this->pixelMath->getPlacementCoordinates($resourceSize, $size, $position)
        );
    }

    /**
     * @return array
     */
    public function coordinatesProvider()
    {
        return array(
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_TOP_LEFT,
                'expectedCoordinates' => array(0, 0)
            ),
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_TOP_CENTER,
                'expectedCoordinates' => array(45, 0)
            ),
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_TOP_RIGHT,
                'expectedCoordinates' => array(90, 0)
            ),
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_MID_LEFT,
                'expectedCoordinates' => array(0, 47)
            ),
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_MID_CENTER,
                'expectedCoordinates' => array(45, 47)
            ),
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_MID_RIGHT,
                'expectedCoordinates' => array(90, 47)
            ),
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_BOTTOM_LEFT,
                'expectedCoordinates' => array(0, 95)
            ),
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_BOTTOM_CENTER,
                'expectedCoordinates' => array(45, 95)
            ),
            array(
                'resourceSize' => array('width' => 10, 'height' => 5),
                'size' => array('width' => 100, 'height' => 100),
                'pos' => Imanee::IM_POS_BOTTOM_RIGHT,
                'expectedCoordinates' => array(90, 95)
            ),
        );
    }
}
