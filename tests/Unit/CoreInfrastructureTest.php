<?php

defined('ABSPATH') || exit;

declare(strict_types=1);

namespace WPZylos\Framework\Core\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WPZylos\Framework\Core\Application;
use WPZylos\Framework\Core\Paths;
use WPZylos\Framework\Core\ServiceProvider;
use WPZylos\Framework\Core\Contracts\ApplicationInterface;
use WPZylos\Framework\Core\Contracts\ContextInterface;
use WPZylos\Framework\Core\Contracts\ServiceProviderInterface;

/**
 * Tests for core framework classes.
 */
class CoreInfrastructureTest extends TestCase
{
    public function testApplicationClassExists(): void
    {
        $this->assertTrue(class_exists(Application::class));
    }

    public function testApplicationImplementsInterface(): void
    {
        $implements = class_implements(Application::class);
        $this->assertContains(ApplicationInterface::class, $implements);
    }

    public function testPathsClassExists(): void
    {
        $this->assertTrue(class_exists(Paths::class));
    }

    public function testServiceProviderClassExists(): void
    {
        $this->assertTrue(class_exists(ServiceProvider::class));
    }

    public function testServiceProviderImplementsInterface(): void
    {
        $implements = class_implements(ServiceProvider::class);
        $this->assertContains(ServiceProviderInterface::class, $implements);
    }

    public function testApplicationInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(ApplicationInterface::class));
    }

    public function testContextInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(ContextInterface::class));
    }

    public function testServiceProviderInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(ServiceProviderInterface::class));
    }

    public function testApplicationInterfaceHasRequiredMethods(): void
    {
        $methods = get_class_methods(ApplicationInterface::class);
        $this->assertContains('context', $methods);
        $this->assertContains('register', $methods);
        $this->assertContains('boot', $methods);
    }
}
