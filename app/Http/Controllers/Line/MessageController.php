<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use LINE\LINEBot\Event\FollowEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Event\UnfollowEvent;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

class MessageController extends Controller
{
    private $customer_service;
    private $channel_secret;
    private $access_token;

    public function __construct()
    {
        $this->customer_service = app()->make('CustomerService');

        $this->channel_secret = config('services.line.channel_secret');
        $this->access_token = config('services.line.access_token');
    }

    public function webhook(Request $request)
    {
        $request_body = $request->getContent();
        $hash = hash_hmac('sha256', $request_body, $this->channel_secret, true);
        $signature = base64_encode($hash);

        if ($signature === $request->header('X-Line-Signature')) {
            $client = new CurlHTTPClient($this->access_token);
            $bot = new LINEBot($client, ['channelSecret' => $this->channel_secret]);

            $events = $bot->parseEventRequest($request_body, $signature);

            foreach ($events as $event) {
                $line_id = $event->getUserId();
                $reply_token = $event->getReplyToken();

                switch ($event) {
                    case ($event instanceof FollowEvent):
                        $customer = $this->customer_service->findCustomer($line_id);

                        if (is_null($customer)) {
                            $this->customer_service->setIsFollowed($line_id);
                            $builder = new TextMessageBuilder('ニックネームが未登録です。ニックネームを入力してください。');
                            $bot->replyMessage($reply_token, $builder);
                        } elseif ($customer->trashed()) {
                            $customer->restore();
                        }

                        return;
                    case ($event instanceof TextMessage):
                        $customer = $this->customer_service->findCustomer($line_id);

                        if (!is_null($customer->is_followed) && is_null($customer->is_confirm_send)) {
                            $positive = new MessageTemplateActionBuilder('はい', 'はい');
                            $negative = new MessageTemplateActionBuilder('いいえ', 'いいえ');
                            $buttons = [$positive, $negative];
                            $confirm = new ConfirmTemplateBuilder("ニックネームは「{$event->getText()}」でよろしいですか？", $buttons);
                            $builder = new TemplateMessageBuilder('confirm', $confirm);

                            $this->customer_service->updateNickname($event, $customer);

                            $bot->replyMessage($reply_token, $builder);
                            return;
                        }

                        if ($event->getText() === 'はい') {
                            $builder = new TextMessageBuilder("{$customer->nickname}様、ご登録ありがとうございます。");
                            $bot->replyMessage($reply_token, $builder);
                            return;
                        } elseif ($event->getText() === 'いいえ') {
                            $this->customer_service->deleteNickname($customer);
                            $builder = new TextMessageBuilder('他のニックネームをご入力ください。');
                            $bot->replyMessage($reply_token, $builder);
                            return;
                        }
                    case ($event instanceof UnfollowEvent):
                        $this->customer_service->deleteCustomer($line_id);
                        $message = new TextMessageBuilder('ブロックされますと、解除された際に再度ご登録が必要になります。ご了承くださいませ。');
                        $bot->replyMessage($reply_token, $message);
                        return;
                }
            }
        }

        return '200';
    }
}
