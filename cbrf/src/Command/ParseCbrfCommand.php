<?php
declare(strict_types=1);

namespace App\Command;

use App\Cbrf\Parser;
use DateTime;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ParseCbrfCommand extends Command
{
    protected static $defaultName = 'app:parse-cbrf';

    /**
     * @var Parser
     */
    private $parser;

    /**
     * ParseCbrfCommand constructor.
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('date', null, 'Date for parsing', '-1 day');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws Exception
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = new DateTime($input->getArgument('date'));
        $output->writeln($this->parser->parse($date));

        return 0;
    }
}
