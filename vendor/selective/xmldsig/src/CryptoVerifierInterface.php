<?php

namespace Selective\XmlDSig;

interface CryptoVerifierInterface
{
    public function verify(String $data, String $signature, String $algorithm): bool;

    public function computeDigest(String $data, String $algorithm): String;
}
