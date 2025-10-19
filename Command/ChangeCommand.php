<?php
namespace Ibrows\LoggableBundle\Command;

use Ibrows\LoggableBundle\Util\Changer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'ibrows:loggable:change',
    description: 'Apply all ready changes'
)]
class ChangeCommand extends Command
{
    public function __construct(
        private readonly Changer $changer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('nowdate', null, InputOption::VALUE_OPTIONAL, 'taken as current time');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTime($input->getOption('nowdate'));
        $output->writeln("ibrows:loggable:change");
        $output->writeln("-----------");
        $this->applyChanges($output, $now);

        return Command::SUCCESS;
    }

    protected function applyChanges(OutputInterface $output, \DateTime $now): void
    {
        $this->changer->setOutput($output);
        $this->changer->applyChanges($now);
    }
}
