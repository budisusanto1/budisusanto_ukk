<?php

namespace App\Libraries;

use Config\Services;
use Config\Recaptcha as RecaptchaConfig;

class RecaptchaLibrary
{
    protected RecaptchaConfig $config;

    public function __construct()
    {
        $this->config = new RecaptchaConfig();
    }

    /**
     * Verify reCAPTCHA response
     */
    public function verifyResponse(?string $response): bool
    {
        // Jika response kosong, return false
        if (empty($response)) {
            return false;
        }
        
        $client = Services::curlrequest();
        
        $postData = [
            'secret' => $this->config->secretKey,
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ];

        try {
            $response = $client->post($this->config->verifyUrl, [
                'form_params' => $postData,
                'timeout' => 10
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            if (isset($data['success']) && $data['success'] === true) {
                // For reCAPTCHA v3, check score
                if ($this->config->version === 'v3' && isset($data['score'])) {
                    return $data['score'] >= $this->config->scoreThreshold;
                }
                return true;
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'reCAPTCHA verification failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get reCAPTCHA script tag
     */
    public function getScriptTag(): string
    {
        $siteKey = $this->config->siteKey;
        
        if ($this->config->version === 'v3') {
            return "<script src=\"https://www.google.com/recaptcha/api.js?render={$siteKey}\"></script>";
        }
        
        return "<script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>";
    }

    /**
     * Get reCAPTCHA div for v2
     */
    public function getWidget(): string
    {
        if ($this->config->version === 'v2') {
            return "<div class=\"g-recaptcha\" data-sitekey=\"{$this->config->siteKey}\"></div>";
        }
        
        return '';
    }

    /**
     * Get hidden input for v3
     */
    public function getHiddenInput(): string
    {
        if ($this->config->version === 'v3') {
            return "<input type=\"hidden\" id=\"recaptcha-response\" name=\"g-recaptcha-response\">";
        }
        
        return '';
    }

    /**
     * Get JavaScript for v3
     */
    public function getV3Script(): string
    {
        if ($this->config->version === 'v3') {
            $siteKey = $this->config->siteKey;
            
            return "
            <script>
            function executeRecaptcha() {
                grecaptcha.ready(function() {
                    grecaptcha.execute('{$siteKey}', {action: 'submit'}).then(function(token) {
                        document.getElementById('recaptcha-response').value = token;
                    });
                });
            }
            
            // Execute on page load
            document.addEventListener('DOMContentLoaded', function() {
                executeRecaptcha();
            });
            
            // Execute on form submit
            document.addEventListener('submit', function(e) {
                executeRecaptcha();
            });
            </script>";
        }
        
        return '';
    }
}
