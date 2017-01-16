<?php

namespace Test;

use Deimos\Cookie\Cookie;
use DeimosTest\TestSetUp;

class CookieTest extends TestSetUp
{

    /**
     * @runInSeparateProcess
     */
    public function testTest()
    {

        $mt_rand = mt_rand();
        $this->cookie->set('test', $mt_rand);

        $this->cookie->set('required', $mt_rand);

        $this->cookie->getRequired('required');

        $this->assertTrue(isset($this->cookie->required));

        $rand = mt_rand();

        $this->assertNull($this->cookie->flash('test'));

        $this->cookie->flash('test', $rand);

        $this->assertEquals(
            $rand,
            $this->cookie->flash('test')
        );

        $this->assertNull($this->cookie->flash('test'));

        $this->cookie->testSet = 'magic';

        $this->assertEquals(
            'magic',
            $this->cookie->get('testSet')
        );

        $this->assertEquals(
            $mt_rand,
            $this->cookie->test
        );

        $this->cookie->removeAll();
        $this->assertFalse(isset($this->cookie->test));

    }

    /**
     * @runInSeparateProcess
     * @expectedException \Deimos\Helper\Exceptions\ExceptionEmpty
     */
    public function testGetRequired()
    {
        $this->cookie->getRequired('required');
    }

    /**
     * @runInSeparateProcess
     */
    public function testSecret()
    {
        $rand = mt_rand();
        $this->cookie->set('secret', $rand, [
            Cookie::OPTION_SECURE => [
                Cookie::SECURE_ALGORITHM => 'AES-256-CTR',
                Cookie::SECURE_IV => '_gPuZWJ/Tm^1!y4d',
                Cookie::SECURE_SECRET => 'MTNE]8Gpz&B709%yXDQ1[4.k!#\';n}Pu-hvU&mK{?dlSoxg:s/qab"C@FV6HR,*t'
            ]
        ]);

        $this->assertEquals(
            $rand,
            $this->cookie->secret
        );

        $this->cookie->set('notSecret', $rand, [
            Cookie::OPTION_SECURE => null,
            Cookie::OPTION_LIFETIME => 1
        ]);

        $this->assertNotEquals(
            $rand,
            $this->cookie->notSecret
        );

        $this->assertEquals(
            $rand,
            $this->cookie->get('notSecret', null, [
                Cookie::OPTION_SECURE => null
            ])
        );
    }

}
