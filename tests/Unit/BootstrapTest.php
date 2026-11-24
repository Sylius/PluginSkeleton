<?php

declare(strict_types=1);

namespace Acme\SyliusExamplePlugin\Tests\Unit;

use Acme\SyliusExamplePlugin\AcmeSyliusExamplePlugin;
use Acme\SyliusExamplePlugin\DependencyInjection\AcmeSyliusExampleExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class BootstrapTest extends TestCase
{
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();
    }

    public function testPluginCanBeInstantiated(): void
    {
        $plugin = new AcmeSyliusExamplePlugin();

        self::assertInstanceOf(AcmeSyliusExamplePlugin::class, $plugin);
    }

    public function testPluginPathIsCorrect(): void
    {
        $plugin = new AcmeSyliusExamplePlugin();
        $path = $plugin->getPath();

        self::assertStringEndsWith('PluginSkeleton', $path);
        self::assertDirectoryExists($path);
    }

    public function testExtensionCanBeLoaded(): void
    {
        $extension = new AcmeSyliusExampleExtension();

        self::assertInstanceOf(AcmeSyliusExampleExtension::class, $extension);
    }

    public function testExtensionLoadsServices(): void
    {
        $extension = new AcmeSyliusExampleExtension();
        $extension->load([], $this->container);

        self::assertTrue($this->container->hasDefinition('Acme\SyliusExamplePlugin\Controller\GreetingController'));
    }

    public function testPluginBuildsContainerWithCompilerPass(): void
    {
        $plugin = new AcmeSyliusExamplePlugin();
        $plugin->build($this->container);

        $compilerPasses = $this->container->getCompilerPassConfig()->getBeforeOptimizationPasses();
        $compilerPassClasses = array_map(fn ($pass) => $pass::class, $compilerPasses);

        self::assertContains('Sylius\Telemetry\TelemetryCompilerPass', $compilerPassClasses);
    }

    public function testPluginBootstrapsSuccessfully(): void
    {
        $extension = new AcmeSyliusExampleExtension();
        $plugin = new AcmeSyliusExamplePlugin();

        $extension->load([], $this->container);
        $plugin->build($this->container);

        self::assertTrue($this->container->hasDefinition('Acme\SyliusExamplePlugin\Controller\GreetingController'));
        $compilerPasses = $this->container->getCompilerPassConfig()->getBeforeOptimizationPasses();
        self::assertNotEmpty($compilerPasses);
    }
}
