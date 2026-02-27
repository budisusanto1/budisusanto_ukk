<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Recaptcha extends BaseConfig
{
    /**
     * Google reCAPTCHA Site Key
     */
    public string $siteKey = '6LfVIncsAAAAANbNeP7L3Fywsg8snysdavyDU8gJ';

    /**
     * Google reCAPTCHA Secret Key
     */
    public string $secretKey = '6LfVIncsAAAAAFrxTVYD2HuaDGvn2qmXp1vOx6vC';

    /**
     * reCAPTCHA Verification URL
     */
    public string $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * reCAPTCHA Version (v2 or v3)
     */
    public string $version = 'v2';

    /**
     * Score threshold for reCAPTCHA v3 (0.0 - 1.0)
     */
    public float $scoreThreshold = 0.5;
}
