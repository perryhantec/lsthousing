<?php

namespace common\components;

use Yii;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer as SignatureCompactSerializer;
use Jose\Component\Signature\Serializer\JWSSerializerManager;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Encryption\Algorithm\KeyEncryption\RSAOAEP256;
use Jose\Component\Encryption\Algorithm\ContentEncryption\A128GCM;
use Jose\Component\Encryption\Compression\CompressionMethodManager;
use Jose\Component\Encryption\Compression\Deflate;
use Jose\Component\Encryption\Serializer\CompactSerializer as EncryptionCompactSerializer;
use Jose\Component\Encryption\Serializer\JWESerializerManager;
use Jose\Component\Encryption\JWEBuilder;
use Jose\Component\Encryption\JWEDecrypter;
use Jose\Component\Encryption\JWELoader;
use InvalidArgumentException;
use Exception;
use Error;

class FPSPayment {

    private static function getMerchantPrivateKey($usage)
    {
        return JWKFactory::createFromKeyFile(
            Yii::getAlias('@cert/fps/'.Yii::$app->params['fpsMerchantPrivateKey']), // The filename
            null,                   // Secret if the key is encrypted
            [
                'kid' => Yii::$app->params['fpsMerchantPrivateKeyID'],
                'use' => $usage,
            ]
        );
    }

    private static function getHsbcPublicKey($usage)
    {
        return JWKFactory::createFromKeyFile(
            Yii::getAlias('@cert/fps/'.Yii::$app->params['fpsHSBCPublicKey']), // The filename
            null,                   // Secret if the key is encrypted
            [
                'kid' => Yii::$app->params['fpsHSBCPublicKeyID'],
                'use' => $usage,
            ]
        );
    }

    public static function encodeOutgoingMessage($payload)
    {
        try {
            $signatureSerializer = new SignatureCompactSerializer();
            $encryptionSerializer = new EncryptionCompactSerializer();
            $merchantPrivateKey = self::getMerchantPrivateKey('sig');
            $hsbcPublicKey = self::getHsbcPublicKey('enc');

            $jwsBuilder = new JWSBuilder(new AlgorithmManager([
                new RS256(),
            ]));
            $jws = $jwsBuilder
                ->create()
                ->withPayload(json_encode($payload))
                ->addSignature($merchantPrivateKey, [
                    'kid' => Yii::$app->params['fpsMerchantPrivateKeyID'],
                    'alg' => 'RS256',
                ])
                ->build();
            $token = $signatureSerializer->serialize($jws, 0);

            // The key encryption algorithm manager with the A256KW algorithm.
            $keyEncryptionAlgorithmManager = new AlgorithmManager([
                new RSAOAEP256(),
            ]);
            // The content encryption algorithm manager with the A256CBC-HS256 algorithm.
            $contentEncryptionAlgorithmManager = new AlgorithmManager([
                new A128GCM(),
            ]);
            // The compression method manager with the DEF (Deflate) method.
            $compressionMethodManager = new CompressionMethodManager([
                new Deflate(),
            ]);
            $jweBuilder = new JWEBuilder(
                $keyEncryptionAlgorithmManager,
                $contentEncryptionAlgorithmManager,
                $compressionMethodManager
            );
            $jwe = $jweBuilder
                ->create()              // We want to create a new JWE
                ->withPayload($token)   // We set the payload
                ->withSharedProtectedHeader([
                    'kid' => Yii::$app->params['fpsHSBCPublicKeyID'],
                    'alg' => 'RSA-OAEP-256',  // Key Encryption Algorithm
                    'enc' => 'A128GCM',       // Content Encryption Algorithm
                ])
                ->addRecipient($hsbcPublicKey)    // We add a recipient (a shared key or public key).
                ->build();              // We build it

            return $encryptionSerializer->serialize($jwe, 0);

        } catch (InvalidArgumentException $exception) {
            Yii::debug($exception);
            return null;

        } catch (Exception $exception) {
            Yii::debug($exception);
            return null;

        } catch (Error $error) {
            Yii::debug($error);
            return null;

        }
    }

    public static function decodeIncomingMessage(string $token)
    {
        try {
            $signatureSerializer = new SignatureCompactSerializer();
            $encryptionSerializer = new EncryptionCompactSerializer();
            $merchantPrivateKey = self::getMerchantPrivateKey('enc');
            $hsbcPublicKey = self::getHsbcPublicKey('sig');

            // The key encryption algorithm manager with the A256KW algorithm.
            $keyEncryptionAlgorithmManager = new AlgorithmManager([
                new RSAOAEP256(),
            ]);

            // The content encryption algorithm manager with the A256CBC-HS256 algorithm.
            $contentEncryptionAlgorithmManager = new AlgorithmManager([
                new A128GCM(),
            ]);

            // The compression method manager with the DEF (Deflate) method.
            $compressionMethodManager = new CompressionMethodManager([
                new Deflate(),
            ]);

            // We instantiate our JWE Decrypter.
            $jweDecrypter = new JWEDecrypter(
                $keyEncryptionAlgorithmManager,
                $contentEncryptionAlgorithmManager,
                $compressionMethodManager
            );

            // The serializer manager. We only use the JWE Compact Serialization Mode.
            $jweSerializerManager = new JWESerializerManager([
                new EncryptionCompactSerializer(),
            ]);

            // $jweLoader = new JWELoader(
            //     $serializerManager,
            //     $jweDecrypter,
            //     $headerCheckerManager
            // );
            //
            // $jwe = $jweLoader->loadAndDecryptWithKey($token, $key, $recipient);

            // We try to load the token.
            $jwe = $encryptionSerializer->unserialize($token);

            // We decrypt the token. This method does NOT check the header.
            if (!$jweDecrypter->decryptUsingKey($jwe, $merchantPrivateKey, 0))
                return null;

            // The algorithm manager with the RS256 algorithm.
            $algorithmManager = new AlgorithmManager([
                new RS256(),
            ]);

            // We instantiate our JWS Verifier.
            $jwsVerifier = new JWSVerifier(
                $algorithmManager
            );

            // The serializer manager. We only use the JWS Compact Serialization Mode.
            $jwsSerializerManager = new JWSSerializerManager([
                new SignatureCompactSerializer(),
            ]);

            // We try to load the token.
            $jws = $jwsSerializerManager->unserialize($jwe->getPayload());
            Yii::debug($jws);

            // We verify the signature. This method does NOT check the header.
            // The arguments are:
            // - The JWS object,
            // - The key,
            // - The index of the signature to check. See
            if (!$jwsVerifier->verifyWithKey($jws, $hsbcPublicKey, 0))
                return null;

            return json_decode($jws->getPayload(), true);

        } catch (InvalidArgumentException $exception) {
            Yii::debug($exception);
            return null;

        } catch (Exception $exception) {
            Yii::debug($exception);
            return null;

        } catch (Error $error) {
            Yii::debug($error);
            return null;

        }
    }

}