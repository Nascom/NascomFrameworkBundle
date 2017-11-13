<?php

namespace Nascom\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;

class ValidationCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('validator.builder')) {
            return;
        }

        $finder = new Finder();
        $finder->files()->in($this->getValidationDirs($container));

        $files = [];
        /** @var File $file */
        foreach ($finder as $file) {
            $files[$file->getExtension()][] = $file->getRealPath();
        }

        if (!empty($files['yml'])) {
            $container->getDefinition('validator.builder')->addMethodCall('addYamlMappings', [$files['yml']]);
        }

        if (!empty($files['xml'])) {
            $container->getDefinition('validator.builder')->addMethodCall('addXmlMappings', [$files['xml']]);
        }
    }

    /**
     * Retrieves all validation directories. Checks both the application and the
     * Resource dirs of enabled bundles.
     *
     * @param ContainerBuilder $container
     * @return string[]
     */
    protected function getValidationDirs(ContainerBuilder $container)
    {
        // Fetch the validation directories of enabled bundles.
        $bundles = $container->getParameter('kernel.bundles');
        $validationDirs = array_map(function ($bundleClassName) {
            $bundle = new \ReflectionClass($bundleClassName);
            $bundlePath = dirname($bundle->getFileName());
            return $bundlePath . '/Resources/config/validation';
        }, array_values($bundles));

        // Add the application's validation dir as well.
        $validationDirs[] = $container->getParameter('kernel.root_dir'). '/config/validation';

        // Filter out possible non-existing directories.
        return array_filter($validationDirs, function($directoryName) {
            return is_dir($directoryName);
        });
    }
}
