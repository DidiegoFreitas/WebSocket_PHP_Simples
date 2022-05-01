<?php
    namespace SimpleSocket;

    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;
    
    class EventsSocket implements MessageComponentInterface {
        protected $clients;
        protected $debug = true;
        protected $receiveMyMessages = false;

        public function __construct() {
            $this->clients = new \SplObjectStorage;
        }

        public function onOpen(ConnectionInterface $conn) {
            $this->clients->attach($conn);
            $this->log("Nova conexão! ({$conn->resourceId})");
        }

        public function onMessage(ConnectionInterface $from, $msg) {
            foreach ($this->clients as $client) {
                if ($this->receiveMyMessages || ($from !== $client)){
                    $client->send( $this->defaultComunication($from, $client, $msg) );
                }
            }
        }

        public function onClose(ConnectionInterface $conn) {
            $this->clients->detach($conn);
            $this->log("O cliente {$conn->resourceId} foi desconectado!");
        }

        public function onError(ConnectionInterface $conn, \Exception $e) {
            $this->log("Ocorreu um erro: {$e->getMessage()}");
            $conn->close();
        }

        public function defaultComunication($origin, $destination, $originalMessage) {
            $defaultMsg = array(
                'origin' => $origin->resourceId,
                'destination' => $destination->resourceId,
                'msg' => $originalMessage,
            );

            $this->log($defaultMsg);
            return json_encode($defaultMsg);
        }

        public function log($msg) {
            if ($this->debug){
                $aux = $msg;
                if (is_array($msg) || is_object($msg)){
                    $aux = json_encode($msg);
                }
                echo date('Y-m-d H:i:s') . " > $aux" . PHP_EOL;
            }
        }
    }