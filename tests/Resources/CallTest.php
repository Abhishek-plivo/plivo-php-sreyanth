<?php

namespace Resources;


use Plivo\Http\PlivoRequest;
use Plivo\Http\PlivoResponse;
use Plivo\Tests\BaseTestCase;

/**
 * Class CallTest
 * @package Resources
 */
class CallTest extends BaseTestCase
{
    function testExceptionCallCreate()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/',
            [
                'from' => '919999999999',
                'to' => '919999999999',
                'answer_url' => '919999999999',
                'answer_method' => 'POST',
            ]);
        $body = file_get_contents(__DIR__ . '/../Mocks/callCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->create(
            '919999999999', ['919999999999'], '919999999999', 'POST');

        $this->assertRequest($request);

        self::assertNotNull($actual);

        foreach ($actual as $actualCall) {
            self::assertEquals(substr($actualCall->resourceUri, 0, 33), "/v1/Account/MAXXXXXXXXXXXXXXXXXX/");
        }
    }

    function testCallCreate()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/',
            [
                'from' => '919999999999',
                'to' => '919999999998',
                'answer_url' => 'http://answer.url',
                'answer_method' => 'POST',
            ]);
        $body = file_get_contents(__DIR__ . '/../Mocks/callCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->create(
            '919999999999', ['919999999998'], 'http://answer.url', 'POST');

        $this->assertRequest($request);

        self::assertNotNull($actual);

        foreach ($actual as $actualCall) {
            self::assertEquals(substr($actualCall->resourceUri, 0, 33), "/v1/Account/MAXXXXXXXXXXXXXXXXXX/");
        }
    }

    function testCallList()
    {
        $request = new PlivoRequest(
            'GET',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/',
            ['subaccount' => 'subacc']);
        $body = file_get_contents(__DIR__ . '/../Mocks/callListResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $actual = $this->client->call->list(['subaccount' => 'subacc']);

        $this->assertRequest($request);

        self::assertNotNull($actual);

        foreach ($actual as $actualCall) {
            self::assertEquals(substr($actualCall->resourceUri, 0, 33), "/v1/Account/MAXXXXXXXXXXXXXXXXXX/");
        }
    }

    function testCallDetails()
    {
        $request = new PlivoRequest(
            'GET',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/4d04c52e-cea3-4458-bbdb-0bfc314ee7cd/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/callGetResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $actual = $this->client->call->get("4d04c52e-cea3-4458-bbdb-0bfc314ee7cd");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->getId(), "4d04c52e-cea3-4458-bbdb-0bfc314ee7cd");
    }

    function testLiveCallList()
    {
        $request = new PlivoRequest(
            'GET',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/',
            ['status'=>'live']);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallListGetResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $actual = $this->client->call->listLive;

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertGreaterThan(0, count($actual));

        foreach ($actual as $actualCall) {
            self::assertEquals(36, strlen($actualCall));
        }
    }

    function testLiveCallDetails()
    {
        $request = new PlivoRequest(
            'GET',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/d0a87a1a-b0e9-4ab2-ac07-c22ee87cd04a/',
            ['status'=>'live']);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallGetResponse.json');

        $this->mock(new PlivoResponse($request,200, $body));

        $actual = $this->client->call->getLive("d0a87a1a-b0e9-4ab2-ac07-c22ee87cd04a");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->id, "d0a87a1a-b0e9-4ab2-ac07-c22ee87cd04a");
    }

    function testLiveCallTransfer()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/',
            [
                'legs'=>'both',
                'aleg_url' => 'http://a.leg',
                'bleg_url' => 'http://b.leg'
            ]);
        $body = file_get_contents(__DIR__ . '/../Mocks/callUpdateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->transfer("dfshjkasfhjkasfhjkashf",
            ['legs'=>'both',
            'aleg_url' => 'http://a.leg',
            'bleg_url' => 'http://b.leg']);

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "call transfered");
    }

    function testException1LiveCallTransfer()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest();
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallPlayCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $this->client->call->transfer("dfshjkasfhjkasfhjkashf",
            ['legs'=>'both',
                'bleg_url' => 'http://b.leg']);
    }

    function testException2LiveCallTransfer()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest();
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallPlayCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $this->client->call->transfer("dfshjkasfhjkasfhjkashf",
            ['legs'=>'aleg',
                'bleg_url' => 'http://b.leg']);
    }

    function testException3LiveCallTransfer()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest();
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallPlayCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $this->client->call->transfer("dfshjkasfhjkasfhjkashf",
            ['legs'=>'bleg']);
    }

    function testException4LiveCallTransfer()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest();
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallPlayCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $this->client->call->transfer("dfshjkasfhjkasfhjkashf",
            ['legs'=>'some other leg']);
    }

    function testException5LiveCallTransfer()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest();
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallPlayCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $this->client->call->transfer("dfshjkasfhjkasfhjkashf",
            ['bleg_url' => 'http://b.leg']);
    }

    function testLiveCallPlay()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Play/',
            ['urls'=>'']);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallPlayCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->play("dfshjkasfhjkasfhjkashf", [""]);

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "play started");
    }

    function testExceptionLiveCallPlay()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Play/',
            ['urls'=> '']);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallPlayCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));
        $this->client->call->play(null, [""]);
    }

    function testLiveCallStartPlay()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Play/',
            ['urls'=>'']);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallPlayCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->startPlaying("dfshjkasfhjkasfhjkashf", [""]);

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "play started");
    }

    function testLiveCallStopPlay()
    {
        $request = new PlivoRequest(
            'DELETE',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Play/',
            []);
        $body = '{}';

        $this->mock(new PlivoResponse($request,204, $body));

        $actual = $this->client->call->stopPlaying("dfshjkasfhjkasfhjkashf");

        $this->assertRequest($request);

        self::assertNull($actual);
    }

    function testLiveCallSpeak()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Speak/',
            ['text'=>'Speak this']);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallSpeakCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->speak("dfshjkasfhjkasfhjkashf", "Speak this");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "speak started");
    }

    function testExceptionLiveCallSpeak()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Speak/',
            ['text'=>'Speak this']);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallSpeakCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));
        $this->client->call->speak(null, "Speak this");
    }

    function testLiveCallStartSpeak()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Speak/',
            ['text'=>'Speak this']);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallSpeakCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->startSpeaking("dfshjkasfhjkasfhjkashf", "Speak this");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "speak started");
    }

    function testLiveCallStopSpeak()
    {
        $request = new PlivoRequest(
            'DELETE',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Speak/',
            []);
        $body = '{}';

        $this->mock(new PlivoResponse($request,204, $body));

        $actual = $this->client->call->stopSpeaking("dfshjkasfhjkasfhjkashf");

        $this->assertRequest($request);

        self::assertNull($actual);
    }

    function testLiveCallRecord()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Record/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallRecordCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->record("dfshjkasfhjkasfhjkashf");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "call recording started");
    }

    function testLiveCallStartRecord()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Record/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallRecordCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->startRecording("dfshjkasfhjkasfhjkashf");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "call recording started");
    }

    function testLiveCallStopRecord()
    {
        $request = new PlivoRequest(
            'DELETE',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Record/',
            []);
        $body = '{}';

        $this->mock(new PlivoResponse($request,204, $body));

        $actual = $this->client->call->stopRecording("dfshjkasfhjkasfhjkashf");

        $this->assertRequest($request);

        self::assertNull($actual);
    }

    function testExceptionLiveCallStartRecord()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/Record/',
            []);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallRecordCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->startRecording("");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "call recording started");
    }

    function testLiveCallDtmf()
    {
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/DTMF/',
            ['digits'=>"123"]);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallDtmfCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->dtmf("dfshjkasfhjkasfhjkashf", "123");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "digits sent");
    }

    function testExceptionLiveCallDtmf()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest(
            'POST',
            'Account/MAXXXXXXXXXXXXXXXXXX/Call/dfshjkasfhjkasfhjkashf/DTMF/',
            ['digits'=>"123"]);
        $body = file_get_contents(__DIR__ . '/../Mocks/liveCallDtmfCreateResponse.json');

        $this->mock(new PlivoResponse($request,201, $body));

        $actual = $this->client->call->dtmf("", "123");

        $this->assertRequest($request);

        self::assertNotNull($actual);

        self::assertEquals($actual->message, "digits sent");
    }

    function testLiveCallCancel()
    {
        $request = new PlivoRequest(
            'DELETE',
            'Account/MAXXXXXXXXXXXXXXXXXX/Request/dfshjkasfhjkasfhjkashf/',
            []);
        $body = '{}';

        $this->mock(new PlivoResponse($request,204, $body));

        $actual = $this->client->call->cancel("dfshjkasfhjkasfhjkashf");

        $this->assertRequest($request);

        self::assertNull($actual);
    }

    function testExceptionLiveCallCancel()
    {
        $this->expectPlivoException('Plivo\Exceptions\PlivoValidationException');
        $request = new PlivoRequest(
            'DELETE',
            'Account/MAXXXXXXXXXXXXXXXXXX/Request/dfshjkasfhjkasfhjkashf/',
            []);
        $body = '{}';

        $this->mock(new PlivoResponse($request,204, $body));

        $actual = $this->client->call->cancel(null);

        $this->assertRequest($request);

        self::assertNull($actual);
    }
}
