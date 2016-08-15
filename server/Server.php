<?php
/**
 * Class Server
 * Based on: https://github.com/ghedipunk/PHP-Websockets/
 */
include dirname(__FILE__).'/../config.php';
require_once(dirname(__FILE__).'/WebSocketServer.php');

class Server extends WebSocketServer {
    private static $instance;
    private $lastCheck = 0;
    private $checkPeriod = 1;
    private $latestDate = 0;
    //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.

    public function __construct($addr, $port, $bufferLength = 2048)
    {
        parent::__construct($addr, $port, $bufferLength);
    }

    public function process ($user, $message) {
        $this->stdout($message);
        $this->answerOne($user, json_decode($message, true));
        //$this->send($user,$message);
    }

    private function answerOne($user, $message) {
        if(is_string($message['$type'])) {
            switch ($message['$type']) {
                case 'ping':
                    $return['$type'] = 'pong';
                    $return['seq']   = 1;
                    $this->prepare($user,$return);
                    break;
                case 'getList':
                    $return['$type'] = 'list';
                    if($message['latest'] < \app\CurrencyController::getLatestDate()) {
                        $return['list'] = \app\CurrencyController::getLatest();
                    }
                    $this->prepare($user,$return);
                    break;
                case 'getInnerList':
                    $return['$type'] = 'listInner';
                    $return['list']   = \app\CurrencyController::getCurrencyDetails($message['bank'], $message['currency']);
                    $this->prepare($user,$return);
                    break;
                case 'getInterval':
                    $return['$type'] = 'listDetailed';
                    $return['list']   = \app\CurrencyController::getIntervalList($message['from'], $message['to']);
                    $this->prepare($user,$return);
                    break;
                default:
                    break;
            }
        }
    }

    private function prepare($user,$return) {
        if(is_array($return)) {
            $this->send($user, json_encode($return));
        }
    }

    public function sendAll($message) {
        $this->stdout('Sending all');
        foreach ($this->users as $user) {
            $this->send($user,$message);
        }
    }

    public function userFunc() {
        if(time() - $this->checkPeriod > $this->lastCheck) {
            $updated = strtotime(\app\CurrencyController::getLatestDate());
            if($updated > $this->latestDate) {
                $this->latestDate = time();
                $return = [];
                $return['$type'] = 'list';
                $return['list']   = \app\CurrencyController::getLatest();
                $this->sendAll(json_encode($return));
                $this->lastCheck = time();
            }
        }
    }

    protected function connected ($user) {
        // Do nothing: This is just an echo server, there's no need to track the user.
        // However, if we did care about the users, we would probably have a cookie to
        // parse at this step, would be looking them up in permanent storage, etc.
    }

    protected function closed ($user) {
        // Do nothing: This is where cleanup would go, in case the user had any sort of
        // open files or other objects associated with them.  This runs after the socket
        // has been closed, so there is no need to clean up the socket itself here.
    }
}