<?php

namespace Tests\Twirp;

use Prophecy\Prophecy\ObjectProphecy;
use Twirp\ChainServerHooks;
use Twirp\Error;
use Twirp\ServerHooks;

final class ChainServerHooksTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ChainServerHooks
     */
    private $hook;

    /**
     * @var ServerHooks|ObjectProphecy
     */
    private $hook1;

    /**
     * @var ServerHooks|ObjectProphecy
     */
    private $hook2;

    public function setUp()
    {
        $this->hook1 = $this->prophesize(ServerHooks::class);
        $this->hook2 = $this->prophesize(ServerHooks::class);

        $this->hook = new ChainServerHooks($this->hook1->reveal(), $this->hook2->reveal());
    }

    /**
     * @test
     */
    public function it_has_a_request_received_hook()
    {
        $actual = ['key' => 'value'];

        $this->hook1->requestReceived([])->willReturn(['key2' => 'value2']);
        $this->hook2->requestReceived(['key2' => 'value2'])->willReturn($actual);

        $expected = $this->hook->requestReceived([]);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_has_a_request_routed_hook()
    {
        $actual = ['key' => 'value'];

        $this->hook1->requestRouted([])->willReturn(['key2' => 'value2']);
        $this->hook2->requestRouted(['key2' => 'value2'])->willReturn($actual);

        $expected = $this->hook->requestRouted([]);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_has_a_response_prepared_hook()
    {
        $actual = ['key' => 'value'];

        $this->hook1->responsePrepared([])->willReturn(['key2' => 'value2']);
        $this->hook2->responsePrepared(['key2' => 'value2'])->willReturn($actual);

        $expected = $this->hook->responsePrepared([]);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_has_a_response_sent_hook()
    {
        $ctx = ['key' => 'value'];

        $this->hook1->responseSent($ctx)->shouldBeCalled();
        $this->hook2->responseSent($ctx)->shouldBeCalled();

        $this->hook->responseSent($ctx);
    }

    /**
     * @test
     */
    public function it_has_an_error_hook()
    {
        $actual = ['key' => 'value'];
        $error = $this->prophesize(Error::class)->reveal();

        $this->hook1->error([], $error)->willReturn(['key2' => 'value2']);
        $this->hook2->error(['key2' => 'value2'], $error)->willReturn($actual);

        $expected = $this->hook->error([], $error);

        $this->assertEquals($expected, $actual);
    }
}
