<?php

namespace App\Command;

use App\Sockets\Chat;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
#[AsCommand(
    name: 'StartChat',
    description: 'Add a short description for your command',
)]
class StartChatCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['Chat socket',
                          '***********']);
        $server = IoServer::factory(new HttpServer(new WsServer(new Chat())),8080);
        $server->run();
        return Command::SUCCESS;
    }
}
