<?php namespace JoaoJoyce\BitId\Crypto;

use BitWasp\Bitcoin\Address\AddressFactory;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\MessageSigner\SignedMessage;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;
use BitWasp\Buffertools\Buffer;

class MessageSigningService
{

    public static function verifyMessageSignature($signature, $public_key_address)
    {
        $signedMessage = self::getSignedMessageFromSignature($signature);
        /** @var PayToPubKeyHashAddress $address */
        $address = AddressFactory::fromString($public_key_address);

        $message_signer = new MessageSigner(Bitcoin::getEcAdapter());
        return $message_signer->verify($signedMessage,$address);
    }

    public static function getNonceFromSignature($signature) {
        $signedMessage = self::getSignedMessageFromSignature($signature);
        $message = $signedMessage->getMessage();
        $parts = parse_url($message);
        parse_str($parts['query'], $query);
        return $query['x'];
    }

    private static function getSignedMessageFromSignature($signature)
    {
        $compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
        $serializer = new SignedMessageSerializer($compactSigSerializer);
        return $serializer->parse(Buffer::hex($signature)->getBinary());
    }

}
