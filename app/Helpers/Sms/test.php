<?php
{
    class whatsAppBot{

        var $APIurl = 'https://api.chat-api.com/instanceYYYYY/';
        var $token = '**************************';

        public function __construct(){

            $json = file_get_contents('php://input');
            $decoded = json_decode($json,true);

            ob_start();
            var_dump($decoded);
            $input = ob_get_contents();
            ob_end_clean();
            file_put_contents('input_requests.log',$input.PHP_EOL,FILE_APPEND);

            if(isset($decoded['messages'])){
                foreach($decoded['messages'] as $message){
                    $text = explode(' ',trim($message['body']));
                    if(!$message['fromMe']){
                        switch(mb_strtolower($text[0],'UTF-8')){
                            case 'hi':  {$this->welcome($message['chatId'],false); break;}
                            case 'file':   {$this->file($message['chatId'],$text[1]); break;}
                            default:        {$this->welcome($message['chatId'],true); break;}
                        }
                    }
                }
            }
        }

        public function welcome($chatId, $noWelcome = false){
            $welcomeString = ($noWelcome) ? "Incorrect command\n" : "WhatsApp Demo Bot PHP\n";
            $this->sendMessage($chatId,
                $welcomeString.
                "Commands:\n".
                "1. chatId - show ID of the current chat\n".
                "2. time - show server time\n".
                "3. me - show your nickname\n".
                "4. file [format] - get a file. Available formats: doc/gif/jpg/png/pdf/mp3/mp4\n".
                "5. ptt - get a voice message\n".
                "6. geo - get a location\n".
                "7. group - create a group with the bot"
            );
        }

        public function file($chatId,$format) {
            $this->sendRequest('sendFile',);
        }

        public function sendMessage($chatId, $text) {
            $this->sendRequest('message',array('chatId'=>$chatId,'body'=>$text));
        }

        public function sendRequest($method,$data) {
            file_get_contents('https://api.chat-api.com/instanceYYYYY/sendFile?token=**************************',false,stream_context_create(['http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => json_encode([
                    'body'=>'https://domain.com/PHP/gifka.gif',
                    'filename'=>'gifka.gif',
                    'caption'=>'Get your file gifka.gif'
                ])
            ]])
            );
        }
    }
    new whatsAppBot();}
?>
