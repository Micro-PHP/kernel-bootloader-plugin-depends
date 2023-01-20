<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\Kernel\Test\Unit\Boot;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\Boot\DependedPluginsBootLoader;
use Micro\Framework\Kernel\Kernel;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\PluginDependedInterface;
use Micro\Framework\Kernel\Test\Unit\PluginHasDepends;
use PHPUnit\Framework\TestCase;

class DependedPluginsBootLoaderTest extends TestCase
{
    private KernelInterface|null $kernel = null;

    private object $pluginNotHasDepends;

    private PluginDependedInterface $pluginDependedWithEmptyDepends;

    private PluginDependedInterface $pluginDependedWithDepends;

    protected function setUp(): void
    {
    }

    public function testBoot()
    {
        $this->kernel = new Kernel(
            [
                PluginHasDepends::class,
            ],
            [],
            new Container(),
        );

        $bootLoader = new DependedPluginsBootLoader($this->kernel);
        $this->kernel->addBootLoader($bootLoader);
        $this->kernel->run();

        $i = 0;
        foreach ($this->kernel->plugins() as $plugin) {
            ++$i;
        }

        $this->assertEquals(3, $i);
    }
}
