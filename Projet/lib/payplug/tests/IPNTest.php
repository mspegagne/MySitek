<?php

require_once(__DIR__ . "/../lib/Payplug.php");

class IPNTest extends PHPUnit_Framework_TestCase {

    protected static $body;
    protected static $headers;
    protected static $parameters;

    public static function setUpBeforeClass() {
        self::$body = '{"status": 0, "origin": null, "last_name": "Library", "custom_datas": "29", "customer": "2", "first_name": "PHP", "amount": 4364, "email": "testlib@payplug.fr", "state": "paid", "custom_data": "29", "id_transaction": 201925, "order": "42"}';
        self::$headers = array("Payplug-Signature" => "ckHaBITi/jJMbq/pv/SsZv+iSSVs3Vphh92wEyv3Zrjpd9rA/gsRhCdwyYrbi1zn/alnhcnx4O9BsqWt+MmyLf7y4EnzyuM1rUapKuIESYuorxUn2oPivGYRCWXQcIfIC8QCQqy5SxDwyG8Hzp1Eoq+2HfNd3tGRLcPXe8+mXfEWX3Lja65CF5Ut+i9tCOkUNs+FRcpAwjBSd2qCdR0VhF25gVLO0+9vt1gVtL+8Z+ECcvqyT4BEX655V3LZEYhGjfssz5XXKpqynRHSQkt265yKs+W78x+alrm9x6lppTFnRz+e5Z95sTls8JpkVdOR1tfTie0KP9/UaLx53+iD9w==");
        self::$parameters = new Parameters(
            array("EUR"),
            5000,
            1,
            "https://www.payplug.fr/p/MD1iqp-NEeO1vBIxQwfJEg==",
            "-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtN4dpK368PEEYKeee7S5\n1m2a8GUFLDAZ/HgRI1H6diYt87gzDPftn1UyW96YuIBed0T0dtl0tuABaIgGeddR\nuo3zfMpkyYWM2D5UHUEMKzEY5WIyaaWoVYJaZU5DWzCiroKcnUJgKm41RL32/CHU\nSFoymxjOOzpvkazbaY+Ql2GYev2QwKAf7lkH91Wp3frjQYXEFIwYnt6ZET8wPUwX\nMdF0hRaZYlaDQrCB2S/+k4Djb8mXqVkJ0qqgItycL05zyysJw/IGMr2zZ5hQSnfN\nCJ+i33ywnoT/qctGgLW4bGuGdTdcbA7VzdxhXtHaAQjuJvrf+twNCQSLCMbZ6pnK\nzQIDAQAB\n-----END PUBLIC KEY-----\n",
            "-----BEGIN RSA PRIVATE KEY-----\nMIIEpQIBAAKCAQEArgLYrcdMINElMBTcGcpLf83nUzEI1ieLClLliJBY4mE4blDp\nTLkPl10lipYhVP+DXXiq1FXDu3ObfHItpgR8Zm++OJQtOSpLQ29ZEE7w3GDqT1QW\n0qQQAhBop9fOKMic079XSGF9PbirnF/48Vxg1GOnH3G/Gbp8SPy89ZgjwVmQaP3u\nw7sQOQ5qxvc0ElKTUiJz6yidT/EU0GM0Vu/TCusv0kOleLEdnGn6RxZNWLx/tI5V\nmVKiYRnwVjm4AtLzvGgGagXOLyQ9SsL2SwXBVlrtYJIvSdlWM8EIB1Viz4zqOlR3\nTDxjcuH9ZBA1SmDfmaWhuA7I2+G+jKWKjmrQfwIDAQABAoIBAE9OksyY8ZRfXdCN\nIUdL0J8eC9j5lypreU4qO9zC1Q/P+XUlwT6rdXSqCksgY26myYtXTJxbvkp3xRyx\nuSZaEwxoz0xgFEBii0zfubraD6KRNRkUnRZBmd4m9lvQ2m/yBq/nG/OsIvV3bhdm\nEkKGtMb36BpHsC4ctTpanhBc16bt10Vu4dJ736ReJWTffBynX/M80LCG4uzSwVaU\n3EZzZjrEQhKLvINmaNniiJTqOjJGO9Qi0E7KGL2WQnYCmn9X6dEH9B67DCNXhlcm\nVqaSlOB/gZYfqzXJQTIZSF8sEdxEyRV8yJpkTl4boAZ9i/fq2XovIEdeTN3HPTC0\n57d/qlkCgYEAxlNc+d/C+V0K22+9uFabp4QKeHOvg2udQntPcElqKc5Jhs4t8eu9\nwivocSXM8qrvoOCCQSeUIw25rU3y0N8miJSOM/LB+hs/GdiqbJfm5Y0/bz6nOMZM\nlnTKaT623R7pJSpLOyPqh7nmouRJpuoYGLn0mYKh+j2N8m1+3/mcCrsCgYEA4J1a\nnTv1iLyuV8jvEEWa9UdwxHTlmmMgP/4H57aMgNdoGbKJH47hM8EcVjLgGIRUzUFN\nPVJYkcFqfrMb2P1OqWNvzyJygYMjSapdmk+CWkWr6MXmZFGLRDQ5cUKuIRnFjXzM\n1gkQH2TMx2O+jBEMlu/vv7i3LG7uHTf6zl6K/w0CgYEAptwOdsEXhrwMXXFXGtfr\nX/ZM5OjYO2b4Sa37uQpbgs7nt76Sk173KX3NtBzMoULGGAGsNWs6TH/Iv5G8gJWv\nEuyB9B0DrQztey56vKDVCD9dppf9E1xrpY6fmgrEyaevGrDJ2Pkv4n+7F0Og4AlG\nus8Bh4KMC0FswxHy1DhrW+8CgYEAilNdgodyZosMMzOjRjoXfAZLBDGZVMLHEaG3\n7JMXZCFEEs9Icw7i0aSTduJN78tPDjixAJq9wMWEeBKFi9QzpU1/heiI7Al+qdcp\nXeapOD6/59I4WH9/bLlcxstxwSDF8KRy4T0jmLHTCtf6ePfm8O1CkKeI5uxJ5+SZ\nqI3Au+ECgYEAxWVrrLTnKiwG9Eslcp150AtntHdZp40R6km/1X+4GYrK4p8S7G0u\nTxMLe/s+S3dlj8lend6kBR6tjDp5zr9Etn7tgdNZ8izrRjaQieHizQ5WyiVfW92c\nuOC1eePmLvWiWGKQfnNDWlYENUGip3M8nmUTh01U+SclIOmla1Gtgkg=\n-----END RSA PRIVATE KEY-----"
        );
    }

    public static function tearDownAfterClass() {
        Payplug::setConfig(null);
    }

    /**
     * @expectedException ParametersNotSetException
     */
    public function testIPNParametersNotSetException() {
        new IPN(self::$headers, self::$body);
    }

    /**
     * @expectedException InvalidSignatureException
     */
    public function testIPNInvalidSignatureException() {
        Payplug::setConfig(self::$parameters);

        new IPN(array("Payplug-Signature" => "foobar"), self::$body);
    }

    public function testIPN() {
        $ipn = new IPN(self::$headers, self::$body);

        $this->assertEquals(4364, $ipn->amount);
        $this->assertEquals("29", $ipn->customData);
        $this->assertEquals("2", $ipn->customer);
        $this->assertEquals("testlib@payplug.fr", $ipn->email);
        $this->assertEquals("PHP", $ipn->firstName);
        $this->assertEquals(201925, $ipn->idTransaction);
        $this->assertEquals("Library", $ipn->lastName);
        $this->assertEquals(42, $ipn->order);
        $this->assertNull($ipn->origin);
        $this->assertEquals("paid", $ipn->state);
    }
}

