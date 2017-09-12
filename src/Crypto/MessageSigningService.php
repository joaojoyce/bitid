<?php namespace JoaoJoyce\BitId\Crypto;

use BitWasp\Bitcoin\Address\AddressFactory;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Serializer\Signature\CompactSignatureSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;

class MessageSigningService
{

    public static function verifyMessageSignature($signature, $public_key_address, $uri)
    {

        $signedMessage = self::getSignedMessageFromSignature($signature,$uri);
        /** @var PayToPubKeyHashAddress $address */
        $address = AddressFactory::fromString($public_key_address);

        $message_signer = new MessageSigner(Bitcoin::getEcAdapter());
        return $message_signer->verify($signedMessage,$address);
    }

    public static function getNonceFromUri($uri) {
        $parts = parse_url($uri);
        parse_str($parts['query'], $query);
        return $query['x'];
    }

    private static function getSignedMessageFromSignature($signature,$uri)
    {

        $sig = "-----BEGIN BITCOIN SIGNED MESSAGE-----
$uri
-----BEGIN SIGNATURE-----
$signature
-----END BITCOIN SIGNED MESSAGE-----";

        /** @var CompactSignatureSerializerInterface $compactSigSerializer */
        $compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
        $serializer = new SignedMessageSerializer($compactSigSerializer);
        $signedMessage = $serializer->parse($sig);

        return $signedMessage;
    }

}
