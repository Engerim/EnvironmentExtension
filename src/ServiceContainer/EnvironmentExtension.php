<?php declare(strict_types = 1);

namespace Tourstream\Behat\EnvironmentExtension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\Compiler\ResolveEnvPlaceholdersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\PathException;

/**
 * @author Alexander Miehe <alexander.miehe@tourstream.eu>
 */
class EnvironmentExtension implements ExtensionInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
    }

    /**
     * @inheritDoc
     */
    public function getConfigKey()
    {
        return 'tourstream_env';
    }

    /**
     * @inheritDoc
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * @inheritDoc
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('env_file')->defaultValue('%paths.base%/.env')->end();
    }

    /**
     * @inheritDoc
     */
    public function load(ContainerBuilder $container, array $config)
    {
        try {
            (new Dotenv())->load($container->getParameterBag()->resolveValue($config['env_file']));
        } catch (PathException $e) {

        }

        $getEnvironmentVariableValue = \Closure::bind(
            function (): void {
                $bag = $this->getParameterBag();
                $this->parameterBag = new EnvPlaceholderParameterBag($this->resolveEnvPlaceholders($bag->all(), true));
            },
            $container,
            ContainerBuilder::class
        );

        $container->addCompilerPass(new ResolveEnvPlaceholdersPass(), PassConfig::TYPE_AFTER_REMOVING, -1000);

        $getEnvironmentVariableValue();

    }

}
