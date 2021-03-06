<?php
# Generated by the protocol buffer compiler (protoc-gen-twirp_php {{ .Version }}).  DO NOT EDIT!
# source: {{ .File.Name }}

namespace {{ .File | phpNamespace }};

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Message\StreamFactory;
use Psr\Http\Message\UriInterface;
use Twirp\Context;

/**
 * A Protobuf client that implements the {@see {{ .Service | phpServiceName .File }}} interface.
 * It communicates using Protobuf and can be configured with a custom HTTP Client.
 *
 * Generated from protobuf service <code>{{ .Service | protoFullName .File }}</code>
 */
final class {{ .Service | phpServiceName .File }}Client extends TwirpClient implements {{ .Service | phpServiceName .File }}
{
    /**
     * @var UriInterface
     */
    private $addr;

    /**
     * @param string              $addr
     * @param HttpClient|null     $httpClient
     * @param MessageFactory|null $messageFactory
     * @param StreamFactory|null  $streamFactory
     */
    public function __construct(
        $addr,
        HttpClient $httpClient = null,
        MessageFactory $messageFactory = null,
        StreamFactory $streamFactory = null
    ) {
        parent::__construct($httpClient, $messageFactory, $streamFactory);

        $this->addr = $this->urlBase($addr);
    }
{{ range $method := .Service.Method }}
{{- $inputType := $method.InputType | phpMessageName }}
    /**
     * {@inheritdoc}
     */
    public function {{ $method.Name }}(array $ctx, {{ $inputType }} $in)
    {
        $ctx = Context::withPackageName($ctx, '{{ $.File.Package }}');
        $ctx = Context::withServiceName($ctx, '{{ $.Service.Name }}');
        $ctx = Context::withMethodName($ctx, '{{ $method.Name }}');

        $out = new {{ $method.OutputType | phpMessageName }}();

        $url = $this->addr.'/twirp/{{ $method | protoFullName $.File $.Service }}';

        $this->doProtobufRequest($ctx, $url, $in, $out);

        return $out;
    }
{{ end -}}
}
