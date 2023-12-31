<?php

declare(strict_types=1);

namespace Kreait\Firebase\DynamicLink\ShortenLongDynamicLink;

use Beste\Json;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Kreait\Firebase\DynamicLink\ShortenLongDynamicLink;
use Kreait\Firebase\Http\WrappedPsr7Request;
use Psr\Http\Message\RequestInterface;

use const JSON_FORCE_OBJECT;

/**
 * @internal
 */
final class ApiRequest implements RequestInterface
{
    use WrappedPsr7Request;

    public function __construct(ShortenLongDynamicLink $action)
    {
        $uri = Utils::uriFor('https://firebasedynamiclinks.googleapis.com/v1/shortLinks');
        $body = Utils::streamFor(Json::encode($action, JSON_FORCE_OBJECT));

        $headers = [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Content-Length' => (string) $body->getSize(),
        ];

        $this->wrappedRequest = new Request('POST', $uri, $headers, $body);
    }
}
