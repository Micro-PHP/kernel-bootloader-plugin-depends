<?php

declare(strict_types=1);

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Framework\Kernel\Boot;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\PluginBootLoaderInterface;
use Micro\Framework\Kernel\Plugin\PluginDependedInterface;
use Micro\Kernel\App\AppKernelInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class DependedPluginsBootLoader implements PluginBootLoaderInterface
{
    /**
     * @param AppKernelInterface $kernel
     */
    public function __construct(
        private KernelInterface $kernel
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function boot(object $applicationPlugin): void
    {
        if (!($applicationPlugin instanceof PluginDependedInterface)) {
            return;
        }

        $dependedPlugins = $applicationPlugin->getDependedPlugins();
        if(!$dependedPlugins) {
            return;
        }

        foreach ($dependedPlugins as $plugin) {
            $this->kernel->loadPlugin($plugin);
        }
    }
}