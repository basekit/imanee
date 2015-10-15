<?php
/**
 * SepiaFilter Tests
 */

namespace imanee\tests\Filter\Imagick;


use Imanee\Filter\Imagick\SepiaFilter;

class SepiaFilterTest extends \PHPUnit_Framework_TestCase
{
    protected $model;

    public function setup()
    {
        $this->model = new SepiaFilter();
    }

    public function tearDown()
    {
        $this->model = null;
    }

    public function testShouldReturnName()
    {
        $this->assertEquals('filter_sepia', $this->model->getName());
    }

    public function testShouldApplyFilter()
    {
        $imagick = $this->getMockBuilder('\Imagick')
            ->setMethods(array('sepiaToneImage'))
            ->getMock();

        $imagick->expects($this->once())
            ->method('sepiaToneImage')
            ->with(90);

        $imanee = $this->getMockBuilder('Imanee\Imanee')
            ->setMethods(array('getResource'))
            ->getMock();

        $imresource = $this->getMockBuilder('Imanee\ImageResource\ImagickResource')
            ->setMethods(array('getResource'))
            ->getMock();

        $imanee->expects($this->once())
            ->method('getResource')
            ->will($this->returnValue($imresource));

        $imresource->expects($this->once())
            ->method('getResource')
            ->will($this->returnValue($imagick));

        $this->model->apply($imanee, array( 'threshold' => 90 ));
    }
}
