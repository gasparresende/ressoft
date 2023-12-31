<?php

require_once 'Crypt/HMAC2.php';
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Outside the Internal Function tests, tests do not distinguish between hash and mhash
 * when available. All tests use Hashing algorithms both extensions implement.
 */

class Crypt_HMAC2Test extends PHPUnit_Framework_TestCase 
{

    // MD5 tests taken from RFC 2202

    public function testHmacMD5_1()
    {
        $data = 'Hi There';
        $key = str_repeat("\x0b", 16);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('9294727a3638bb1c13f48ef8158bfc9d', $hmac->hash($data));
    }

    public function testHmacMD5_2()
    {
        $data = 'what do ya want for nothing?';
        $key = 'Jefe';
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('750c783e6ab0b503eaa86e310a5db738', $hmac->hash($data));
    }

    public function testHmacMD5_3()
    {
        $data = str_repeat("\xdd",50);
        $key = str_repeat("\xaa", 16);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('56be34521d144c88dbb8c733f0e8b3f6', $hmac->hash($data));
    }

    public function testHmacMD5_4()
    {
        $data = str_repeat("\xcd",50);
        $key = "\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19";
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('697eaf0aca3a3aea3a75164746ffaa79', $hmac->hash($data));
    }

    public function testHmacMD5_5()
    {
        $data = 'Test With Truncation';
        $key = str_repeat("\x0c",16);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('56461ef2342edc00f9bab995690efd4c', $hmac->hash($data));
    }

    public function testHmacMD5_6()
    {
        $data = 'Test Using Larger Than Block-Size Key - Hash Key First';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('6b1ab7fe4bd7bf8f0b62e6ce61b9d0cd', $hmac->hash($data));
    }

    public function testHmacMD5_7()
    {
        $data = 'Test Using Larger Than Block-Size Key and Larger Than One Block-Size Data';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('6f630fad67cda0ee1fb1f562db3aa53e', $hmac->hash($data));
    }

    // SHA1 tests taken from RFC 2202

    public function testHmacSHA1_1()
    {
        $data = 'Hi There';
        $key = str_repeat("\x0b", 20);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('b617318655057264e28bc0b6fb378c8ef146be00', $hmac->hash($data));
    }

    public function testHmacSHA1_2()
    {
        $data = 'what do ya want for nothing?';
        $key = 'Jefe';
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('effcdf6ae5eb2fa2d27416d5f184df9c259a7c79', $hmac->hash($data));
    }

    public function testHmacSHA1_3()
    {
        $data = str_repeat("\xdd",50);
        $key = str_repeat("\xaa", 20);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('125d7342b9ac11cd91a39af48aa17b4f63f175d3', $hmac->hash($data));
    }

    public function testHmacSHA1_4()
    {
        $data = str_repeat("\xcd",50);
        $key = "\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19";
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('4c9007f4026250c6bc8414f9bf50c86c2d7235da', $hmac->hash($data));
    }

    public function testHmacSHA1_5()
    {
        $data = 'Test With Truncation';
        $key = str_repeat("\x0c",20);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('4c1a03424b55e07fe7f27be1d58bb9324a9a5a04', $hmac->hash($data));
    }

    public function testHmacSHA1_6()
    {
        $data = 'Test Using Larger Than Block-Size Key - Hash Key First';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('aa4ae5e15272d00e95705637ce8a3b55ed402112', $hmac->hash($data));
    }

    public function testHmacSHA1_7()
    {
        $data = 'Test Using Larger Than Block-Size Key and Larger Than One Block-Size Data';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('e8e99d0f45237d786d6bbaa7965c7808bbff1a91', $hmac->hash($data));
    }

    // RIPEMD160 tests taken from RFC 2286

    public function testHmacRIPEMD160_1()
    {
        $data = 'Hi There';
        $key = str_repeat("\x0b", 20);
        $hmac = new Crypt_HMAC2($key, 'RIPEMD160');
        $this->assertEquals('24cb4bd67d20fc1a5d2ed7732dcc39377f0a5668', $hmac->hash($data));
    }

    public function testHmacRIPEMD160_2()
    {
        $data = 'what do ya want for nothing?';
        $key = 'Jefe';
        $hmac = new Crypt_HMAC2($key, 'RIPEMD160');
        $this->assertEquals('dda6c0213a485a9e24f4742064a7f033b43c4069', $hmac->hash($data));
    }

    public function testHmacRIPEMD160_3()
    {
        $data = str_repeat("\xdd",50);
        $key = str_repeat("\xaa", 20);
        $hmac = new Crypt_HMAC2($key, 'RIPEMD160');
        $this->assertEquals('b0b105360de759960ab4f35298e116e295d8e7c1', $hmac->hash($data));
    }

    public function testHmacRIPEMD160_4()
    {
        $data = str_repeat("\xcd",50);
        $key = "\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19";
        $hmac = new Crypt_HMAC2($key, 'RIPEMD160');
        $this->assertEquals('d5ca862f4d21d5e610e18b4cf1beb97a4365ecf4', $hmac->hash($data));
    }

    public function testHmacRIPEMD160_5()
    {
        $data = 'Test With Truncation';
        $key = str_repeat("\x0c",20);
        $hmac = new Crypt_HMAC2($key, 'RIPEMD160');
        $this->assertEquals('7619693978f91d90539ae786500ff3d8e0518e39', $hmac->hash($data));
    }

    public function testHmacRIPEMD160_6()
    {
        $data = 'Test Using Larger Than Block-Size Key - Hash Key First';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'RIPEMD160');
        $this->assertEquals('6466ca07ac5eac29e1bd523e5ada7605b791fd8b', $hmac->hash($data));
    }

    public function testHmacRIPEMD160_7()
    {
        $data = 'Test Using Larger Than Block-Size Key and Larger Than One Block-Size Data';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'RIPEMD160');
        $this->assertEquals('69ea60798d71616cce5fd0871e23754cd75d5a0a', $hmac->hash($data));
    }

    // hash() free testing (excludes ripemd160)

    // MD5 tests taken from RFC 2202

    public function testHmac_InternalMD5_1()
    {
        $data = 'Hi There';
        $key = str_repeat("\x0b", 16);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('9294727a3638bb1c13f48ef8158bfc9d', $hmac->hash($data), true);
    }

    public function testHmac_InternalMD5_2()
    {
        $data = 'what do ya want for nothing?';
        $key = 'Jefe';
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('750c783e6ab0b503eaa86e310a5db738', $hmac->hash($data), true);
    }

    public function testHmac_InternalMD5_3()
    {
        $data = str_repeat("\xdd",50);
        $key = str_repeat("\xaa", 16);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('56be34521d144c88dbb8c733f0e8b3f6', $hmac->hash($data), true);
    }

    public function testHmac_InternalMD5_4()
    {
        $data = str_repeat("\xcd",50);
        $key = "\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19";
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('697eaf0aca3a3aea3a75164746ffaa79', $hmac->hash($data), true);
    }

    public function testHmac_InternalMD5_5()
    {
        $data = 'Test With Truncation';
        $key = str_repeat("\x0c",16);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('56461ef2342edc00f9bab995690efd4c', $hmac->hash($data), true);
    }

    public function testHmac_InternalMD5_6()
    {
        $data = 'Test Using Larger Than Block-Size Key - Hash Key First';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('6b1ab7fe4bd7bf8f0b62e6ce61b9d0cd', $hmac->hash($data), true);
    }

    public function testHmac_InternalMD5_7()
    {
        $data = 'Test Using Larger Than Block-Size Key and Larger Than One Block-Size Data';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'MD5');
        $this->assertEquals('6f630fad67cda0ee1fb1f562db3aa53e', $hmac->hash($data), true);
    }

    // SHA1 tests taken from RFC 2202

    public function testHmac_InternalSHA1_1()
    {
        $data = 'Hi There';
        $key = str_repeat("\x0b", 20);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('b617318655057264e28bc0b6fb378c8ef146be00', $hmac->hash($data), true);
    }

    public function testHmac_InternalSHA1_2()
    {
        $data = 'what do ya want for nothing?';
        $key = 'Jefe';
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('effcdf6ae5eb2fa2d27416d5f184df9c259a7c79', $hmac->hash($data), true);
    }

    public function testHmac_InternalSHA1_3()
    {
        $data = str_repeat("\xdd",50);
        $key = str_repeat("\xaa", 20);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('125d7342b9ac11cd91a39af48aa17b4f63f175d3', $hmac->hash($data), true);
    }

    public function testHmac_InternalSHA1_4()
    {
        $data = str_repeat("\xcd",50);
        $key = "\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19";
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('4c9007f4026250c6bc8414f9bf50c86c2d7235da', $hmac->hash($data), true);
    }

    public function testHmac_InternalSHA1_5()
    {
        $data = 'Test With Truncation';
        $key = str_repeat("\x0c",20);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('4c1a03424b55e07fe7f27be1d58bb9324a9a5a04', $hmac->hash($data), true);
    }

    public function testHmac_InternalSHA1_6()
    {
        $data = 'Test Using Larger Than Block-Size Key - Hash Key First';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('aa4ae5e15272d00e95705637ce8a3b55ed402112', $hmac->hash($data), true);
    }

    public function testHmac_InternalSHA1_7()
    {
        $data = 'Test Using Larger Than Block-Size Key and Larger Than One Block-Size Data';
        $key = str_repeat("\xaa",80);
        $hmac = new Crypt_HMAC2($key, 'SHA1');
        $this->assertEquals('e8e99d0f45237d786d6bbaa7965c7808bbff1a91', $hmac->hash($data), true);
    }

}
