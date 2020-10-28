<?php namespace Catalog\Controllers\Account;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Catalog\Libraries\Chat;

class Server 
{
    public function index()
    {
    	new Chat();
    	
        $server = IoServer::factory(
            new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
            54314
        );

        $server->run();
    }

    //--------------------------------------------------------------------
}
