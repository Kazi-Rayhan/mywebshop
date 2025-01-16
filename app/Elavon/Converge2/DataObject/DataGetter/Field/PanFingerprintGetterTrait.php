<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 */
trait PanFingerprintGetterTrait
{
    /**
     * @return string|null
     */
    public function getPanFingerprint()
    {
        return $this->getDataField(C2ApiFieldName::PAN_FINGERPRINT);
    }
}
