<?php

namespace App\Utils;

use Exception;

class Encrypt
{
    /**
     * Encrypt a message
     *
     * @param string $message - message to encrypt
     * @param string $key - encryption key
     * @return string
     * @throws \Exception
     */
    public static function safeEncrypt(string $message, string $key): string
    {
        $nonce = '123412341234123412341234'; //random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $cypher = base64_encode(
            $nonce .
            sodium_crypto_secretbox(
                $message,
                $nonce,
                str_pad($key, SODIUM_CRYPTO_SECRETBOX_KEYBYTES)
            )
        );
        return $cypher;
    }

    /**
     * Decrypt a message
     *
     * @param string $cipher - message encrypted with safeEncrypt()
     * @param string $key - encryption key
     * @return string
     * @throws Exception
     */
    public static function safeDecrypt(string $cipher, string $key): string
    {
        $decoded = base64_decode($cipher);
        if ($decoded === false) {
            throw new Exception('the encoding failed');
        }
        if (mb_strlen($decoded, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES)) {
            throw new Exception('the message was truncated');
        }

        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $cipherText = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

        $message = sodium_crypto_secretbox_open(
            $cipherText,
            $nonce,
            str_pad($key, SODIUM_CRYPTO_SECRETBOX_KEYBYTES)
        );

        if ($message === false) {
            throw new \Exception('the message was tampered with in transit');
        }
        return $message;
    }
}
