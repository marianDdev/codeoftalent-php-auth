<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;

class TokenService implements TokenServiceInterface
{
    /**
     * @throws Exception
     */
    public function generate(): string
    {
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $algorithm    = new Sha256();
        $signingKey   = InMemory::plainText(random_bytes(32));

        $token = $tokenBuilder
            ->issuedBy('http://localhost')
            ->withClaim('uid', 1)
            ->withHeader('Bearer', 'token')
            ->getToken($algorithm, $signingKey);

        $token->headers();
        $token->claims();

        return $token->toString();
    }
}
