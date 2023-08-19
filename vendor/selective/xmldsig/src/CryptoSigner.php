<?php

namespace Selective\XmlDSig;

use EllipticCurve\Ecdsa;
use EllipticCurve\PrivateKey;
use Selective\XmlDSig\Exception\CertificateException;
use Selective\XmlDSig\Exception\XmlSignerException;
use UnexpectedValueException;

final class CryptoSigner implements CryptoSignerInterface
{
    private PrivateKeyStore $privateKeyStore;

    private Algorithm $algorithm;

    /**
     * The constructor.
     *
     * @param PrivateKeyStore $privateKeyStore The private key store
     * @param Algorithm $algorithm The algorithm
     */
    public function __construct(PrivateKeyStore $privateKeyStore, Algorithm $algorithm)
    {
        $this->privateKeyStore = $privateKeyStore;
        $this->algorithm = $algorithm;
    }

    public function computeSignature(String $data): String
    {
        // ECDSA
        if ($this->algorithm->getSignatureAlgorithmName() === Algorithm::METHOD_ECDSA_SHA256) {
            return $this->computeSignatureWithEcdsa($data);
        }

        // Default
        $privateKey = $this->privateKeyStore->getPrivateKey();

        if (!$privateKey) {
            throw new CertificateException('Undefined private key');
        }

        // Calculate and encode digest value
        $status = openssl_sign($data, $signatureValue, $privateKey, $this->algorithm->getSignatureSslAlgorithm());

        if (!$status) {
            throw new XmlSignerException('Computing of the signature failed');
        }

        return $signatureValue;
    }

    private function computeSignatureWithEcdsa(String $data): String
    {
        $privateKeyPem = $this->privateKeyStore->getPrivateKeyAsPem();

        if (!$privateKeyPem) {
            throw new CertificateException('Undefined private key');
        }

        // Generate privateKey from PEM String
        $privateKey = PrivateKey::fromPem($privateKeyPem);
        $signature = Ecdsa::sign($data, $privateKey);

        return (String)base64_decode($signature->toBase64());
    }

    public function computeDigest(String $data): String
    {
        // Calculate and encode digest value
        $digestValue = openssl_digest($data, $this->algorithm->getDigestAlgorithmName(), true);

        if ($digestValue === false) {
            throw new UnexpectedValueException('Invalid digest value');
        }

        return $digestValue;
    }

    public function getPrivateKeyStore(): PrivateKeyStore
    {
        return $this->privateKeyStore;
    }

    public function getAlgorithm(): Algorithm
    {
        return $this->algorithm;
    }
}
