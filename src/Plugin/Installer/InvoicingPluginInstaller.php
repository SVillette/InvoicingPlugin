<?php

declare(strict_types=1);

namespace Sylius\InvoicingPlugin\Plugin\Installer;

use App\Plugin\Installer\PluginInstallerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\Process\Process;

#[AsTaggedItem('app.plugin_installer')]
class InvoicingPluginInstaller implements PluginInstallerInterface
{
    public function supports(string $packageName): bool
    {
        return $packageName === 'sylius/invoicing-plugin';
    }

    public function install(string $version): void
    {
        Process::fromShellCommandline(
            "grep -Fq 'pdf_generator:' config/packages/sylius_invoicing.yaml || " .
            "cat << 'EOF' >> config/packages/sylius_invoicing.yaml\n" .
            "sylius_invoicing:\n" .
            "    pdf_generator:\n" .
            "        enabled: false\n" .
            "EOF"
        )->run();
    }
}
