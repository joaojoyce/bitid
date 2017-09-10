<?php namespace JoaoJoyce\BitId\Crypto;

use BitWasp\Bitcoin\Address\AddressFactory;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;
use BitWasp\Buffertools\Buffer;

class MessageSigningService
{

    public static function verifyMessageSignature($url, $signature, $public_key_address)
    {
        $compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
        $serializer = new SignedMessageSerializer($compactSigSerializer);
        $signedMessage = $serializer->parse(Buffer::hex($signature)->getBinary());

        $message_signer = new MessageSigner(Bitcoin::getEcAdapter());

        /** @var PayToPubKeyHashAddress $address */
        $address = AddressFactory::fromString($public_key_address);
        return $message_signer->verify($signedMessage,$address) && $signedMessage->getMessage() == $url;
    }

}
