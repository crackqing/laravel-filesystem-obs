<?php

namespace JkYang\Obs\Internal\Signature;

use JkYang\Obs\Internal\Common\Model;

interface SignatureInterface
{
    public function doAuth(array &$requestConfig, array &$params, Model $model);
}
