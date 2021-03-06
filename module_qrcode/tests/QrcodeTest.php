<?php

namespace Kajona\Qrcode\Tests;

use Kajona\Qrcode\System\Qrcode;
use Kajona\System\Tests\Testbase;

class QrcodeTest extends Testbase
{

    public function testQrcode()
    {

        $objQrCode = new Qrcode();

        $strImage1 = $objQrCode->getImageForString("Kajona Test Image");
        $this->assertFileExists(_realpath_ . $strImage1);

        $strImage2 = $objQrCode->getImageForString(_webpath_);
        $this->assertFileExists(_realpath_ . $strImage2);

    }


}
