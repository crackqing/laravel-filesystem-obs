<?php

namespace jkyang\Obs\Internal\Signature;

use jkyang\Obs\Internal\Common\Model;

interface SignatureInterface
{
    public function doAuth(array &$requestConfig, array &$params, Model $model);
}
