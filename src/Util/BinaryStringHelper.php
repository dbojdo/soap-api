<?php
/**
 * File: BinaryStringHelper.php
 * Created at: 2014-11-29 00:14
 */
 
namespace Webit\SoapApi\Util;

/**
 * Class BinaryStringHelper
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class BinaryStringHelper
{
    /**
     * Encode detected binary strings to base64
     * Check recursively public properties of \stdClass only
     *
     * @param \stdClass $obj
     */
    public function encodeBinaryString(\stdClass $obj)
    {
        foreach (get_object_vars($obj) as $var => $value) {
            if ($obj->{$var} instanceof \stdClass) {
                $this->encodeBinaryString($obj->{$var});
            } else if ($this->isBinaryString($obj->{$var})) {
                $obj->{$var} = base64_encode($obj->{$var});
            }
        }
    }

    /**
     * @param string $string
     * @return bool
     */
    private function isBinaryString($string)
    {
        $file = tempnam(sys_get_temp_dir(), 'binary-check');
        file_put_contents($file, $string);
        $finfo = new \finfo();
        $result = substr($finfo->file($file, FILEINFO_MIME), 0, 4) != 'text';
        unlink($file);

        return $result;
    }
}
 