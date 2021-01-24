<?php declare(strict_types=1);

namespace Zeus\Browser\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

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

    public function post(string $uri, array $options): string
    {
        try {
            $response = $this->client->request('POST', $uri, $options);
            return $response->getBody()->getContents();
        } catch (ConnectException $e) {
            throw new UnableToReachBrowserlessException('Unable to connect to the Browserless service');
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
