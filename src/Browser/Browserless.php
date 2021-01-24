<?php declare(strict_types=1);

namespace Zeus\Browser;

use Zeus\Browser\Clients\BrowserlessClient;

/**
 * Uses a Browserless client to make the necessary calls to the Browserless service.
 * One client could use a HTTP connection using Guzzle or another client could use a Websocket connection.
 *
 * @package Zeus\Browser
 */
class Browserless implements CommunicatesWithBrowser
{
    private BrowserlessClient $client;

    public function __construct(BrowserlessClient $client)
    {
        $this->client = $client;
    }

    public function content(string $url): string
    {
        return $this->client->post('/content', [
            'json' => [
                'url' => $url
            ]
        ]);
    }

    public function healthCheck(string $url): void
    {
        $result = $this->client->post('/function', [
            'json' => [
                'context' => [
                    'url' => $url
                ],
                'code' => 'module.exports=async({page:t,context:e})=>{const{url:s}=e;let a;return(t.on("requestfinished",(t)=>{a={status:parseInt(t.response().status())}}),t.on("requestfailed",(t)=>{a={status:parseInt(t.response().status())}}),t.on("error",(t)=>{a={status:0}}),await t.goto(s),{data:a,type:"application/json"})}'
            ]
        ]);

        $healthCheck = json_decode($result);

        if ($healthCheck->status !== 200) {
            throw new WebsiteFailedHealthCheckException(
                sprintf('The website about to be crawled failed a health check (%s)', $url)
            );
        }
    }
}
