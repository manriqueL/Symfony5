<?php 
// src/Command/ScanIpsCommand.php

namespace App\Command;

use App\Service\IpScannerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScanIpsCommand extends Command
{
    protected static $defaultName = 'app:scan-ips';

    private $ipScannerService;

    public function __construct(IpScannerService $ipScannerService)
    {
        parent::__construct();

        $this->ipScannerService = $ipScannerService;
    }

    protected function configure()
    {
        $this->setDescription('Scan and update the status of IPs.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->ipScannerService->scanIps();
        $output->writeln('IPs scanned and updated successfully.');

        return Command::SUCCESS;
    }
}
