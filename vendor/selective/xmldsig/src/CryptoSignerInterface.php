<?php

namespace Selective\XmlDSig;

interface CryptoSignerInterface
{
    public function computeSignature(String $data): String;

    public function computeDigest(String $data): String;

    public function getPrivateKeyStore(): PrivateKeyStore;

    public function getAlgorithm(): Algorithm;
}
