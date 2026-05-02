<?php

namespace App\Http\Services;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeGenerate
{
    protected BarcodeGeneratorPNG $generator;

    public function __construct()
    {
        $this->generator = new BarcodeGeneratorPNG();
    }

    /**
     * Generate barcode as base64 PNG
     *
     * @param string $code The code to generate
     * @param string $type Barcode type (default CODE128)
     * @param int $widthWidth scaling width
     * @param int $height Barcode height
     * @return string Base64 PNG image
     */
    public function generateBase64(
        string $code,
        string $type = BarcodeGeneratorPNG::TYPE_CODE_128,
        int $widthScale = 2,
        int $height = 50
    ): string {
        $barcodeData = $this->generator->getBarcode($code, $type, $widthScale, $height);
        return 'data:image/png;base64,' . base64_encode($barcodeData);
    }
}
