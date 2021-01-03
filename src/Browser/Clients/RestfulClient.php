<?php declare(strict_types=1);

namespace Zeus\Browser\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Zeus\Browser\Contracts\BrowserlessClient;
use Zeus\Browser\UnableToParseUrlException;

class RestfulClient implements BrowserlessClient
{
    private Client $client;

    public function __construct(string $host, int $port, string $token)
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());

        $stack->unshift(Middleware::mapRequest(function (RequestInterface $request) use ($token): RequestInterface {
            return $request->withUri(Uri::withQueryValue($request->getUri(), 'token', $token));
        }));

        $uri = (new Uri($host))->withPort($port);

        $this->client = new Client([
            'base_uri' => $uri,
            'handler' => $stack
        ]);
    }

    public function content(string $url): string
    {
        try {
            $response = $this->client->request('POST', '/content', [
                'json' => [
                    'url' => $url
                ]
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            throw new UnableToParseUrlException($e->getMessage());
        }
    }
}
