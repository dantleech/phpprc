<?php

namespace Phpprc\Tests\Unit\Core\Core\Package;

use PHPUnit\Framework\TestCase;
use Phpprc\Core\Core\Package\Package;
use Phpprc\Core\Core\Package\PackageFactory;
use Phpprc\Core\Core\Package\Packages;
use Phpprc\Core\Core\Package\PackagesFactory;

class PackagesFactoryTest extends TestCase
{
    /**
     * @var PackageFactory|ObjectProphecy
     */
    private $packageFactory;

    /**
     * @var PackagesFactory
     */
    private $factory;

    /**
     * @var ObjectProphecy|Package
     */
    private $package1;

    /**
     * @var ObjectProphecy|Package
     */
    private $package2;

    public function setUp()
    {
        $this->packageFactory = $this->prophesize(PackageFactory::class);
        $this->factory = new PackagesFactory($this->packageFactory->reveal());
        $this->package1 = $this->prophesize(Package::class);
        $this->package2 = $this->prophesize(Package::class);
    }

    public function testFromArrayOfPackageDefinitions()
    {
        $this->packageFactory->createFromFullNameAndConfig('package1', [ 'one' => 1])->willReturn($this->package1->reveal());
        $this->packageFactory->createFromFullNameAndConfig('package2', [ 'two' => 1])->willReturn($this->package2->reveal());

        $packages = $this->factory->createFromArrayOfPackages([
            'package1' => [ 'one' => 1 ],
            'package2' => [ 'two' => 1 ],
        ]);

        $this->assertInstanceOf(Packages::class, $packages);
    }
}
