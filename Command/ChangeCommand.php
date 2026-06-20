<?php
namespace Ibrows\LoggableBundle\Command;

use Ibrows\LoggableBundle\Util\Changer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeCommand extends Command
{
    /**
     * @var Changer
     */
    private $changer;

    public function __construct(Changer $changer)
    {
        $this->changer = $changer;
        parent::__construct();
    }

    /* (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this->setName('ibrows:loggable:change')->setDescription('apply all ready changes');
        $this->addOption('nowdate', null, InputOption::VALUE_OPTIONAL, 'taken as curernt time');
    }

    /* (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTime($input->getOption('nowdate'));
        $output->writeln("ibrows:loggable:change");
        $output->writeln("-----------");
        $this->applyChanges($output, $now);

        return Command::SUCCESS;
    }


    /**
     * @param OutputInterface $output
     * @return array with skipped and ready counts
     */
    protected function applyChanges($output, $now)
    {
        $changer = $this->changer;
        $changer->setOutput($output);
        $changer->applyChanges($now);
    }
}
