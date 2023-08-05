<?php

namespace App\Http\Controllers;

use App\Models\Interfaces\IStatusCode;
use DomainException;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    const algorithm = 'RS256';

    /**
     * 產生基於SHA256簽章的JWT。
     * 
     * @param array $payload JWT中Payload部分。
     * 
     * @return string
     */
    public static function generateJwt(array $payload)
    {
        // 從Storage中取得Private Key。
        $privateKey = Storage::disk('local')->get("access_rsa");

        // 加上EOD格式才可以正常使用。
        $realPrivateKey = <<<EOD
        $privateKey
        EOD;

        // 產生JWT並回傳。
        $jwt = JWT::encode($payload, $realPrivateKey, self::algorithm);
        return (string) $jwt;
    }

    /**
     * 解開基於SHA256簽章的JWT，這個方法會有各式Exception。
     * 
     * @param string $jwt 欲解開的JWT。
     * 
     * @return stdClass
     * 
     * @throws InvalidArgumentException — Provided key/key-array was empty or malformed
     * @throws DomainException — Provided JWT is malformed
     * 
     * @throws UnexpectedValueException — Provided JWT was invalid
     *
     * @throws SignatureInvalidException
     * Provided JWT was invalid because the signature verification failed
     * 
     * @throws BeforeValidException
     * Provided JWT is trying to be used before it's eligible as defined by 'nbf'
     * 
     * @throws BeforeValidException
     * Provided JWT is trying to be used before it's been created as defined by 'iat'
     * 
     * @throws ExpiredException
     * Provided JWT has since expired, as defined by the 'exp' claim
     */
    public static function decodeJwt(string $jwt)
    {
        // 從Storage中取得Public Key。
        $publicKey = Storage::disk('local')->get("access_rsa.pub");

        // 加上EOD格式才可以正常使用。
        $realPublicKey = <<<EOD
        $publicKey
        EOD;

        // print_r( \openssl_error_string() ); // 詳細錯誤

        // 解開JWT並且回傳Payload的部分。
        $data = JWT::decode($jwt, new Key($realPublicKey, self::algorithm));
        return $data;
    }

    /**
     * 
     */
    public static function verifyAndBase64DecodeJwt(string $jwt)
    {
        $payload = JWT::jsonDecode(JWT::urlsafeB64Decode(explode('.', $jwt)[1]));
        $cloneJwt = self::generateJwt((array)$payload);
        if ($jwt === $cloneJwt) {
            return $payload;
        }
        return false;
    }

    /**
     * 產生Refresh Token(UUID)。
     */
    public static function generateRefreshToken()
    {
        return (string) Str::orderedUuid();
    }
}
