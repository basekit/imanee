<?php
/**
 * ModulateFilter Tests
 */

namespace imanee\tests\Filter\Imagick;


use Imanee\Filter\Imagick\ModulateFilter;

class ModulateFilterTest extends \PHPUnit_Framework_TestCase
{
    protected $model;

    public function setup()
    {
        $this->model = new ModulateFilter();
    }

    public function tearDown()
    {
        $this->model = null;
    }

    public function testShouldReturnName()
    {
        $this->assertEquals('filter_modulate', $this->model->getName());
    }

    public function testShouldApplyFilter()
    {
        $imagick = $this->getMockBuilder('\Imagick')
            ->setMethods(array('modulateImage'))
            ->getMock();

        $imagick->expects($this->once())
            ->method('modulateImage')
            ->with(90, 50, 90);

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

        $this->model->apply($imanee, array(
            'brightness' => 90,
            'saturation' => 50,
            'hue'        => 90,
        ));
    }
}
