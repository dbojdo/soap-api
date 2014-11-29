<?php
/**
 * HydratorSerializer.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Nov 25, 2014, 16:19
 */

namespace Webit\SoapApi\Hydrator;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializerInterface;
use Webit\SoapApi\Hydrator\Exception\HydrationException;
use Webit\SoapApi\Util\BinaryStringHelper;

/**
 * Class HydratorSerializer
 * @package Webit\SoapApi\Hydrator
 */
class HydratorSerializer implements HydratorInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var BinaryStringHelper
     */
    private $binaryStringHelper;

    public function __construct(SerializerInterface $serializer, BinaryStringHelper $binaryStringHelper)
    {
        $this->serializer = $serializer;
        $this->binaryStringHelper = $binaryStringHelper;
    }

    /**
     * @param \stdClass $result
     * @param string $resultType
     * @return mixed
     */
    public function hydrateResult(\stdClass $result, $resultType)
    {
        if (!$resultType) {
            return $result;
        }

        $json = @json_encode($result);
        $lastError = json_last_error();

        if ($lastError) {
            if ($lastError != JSON_ERROR_UTF8) {
                throw $this->createEncodingException($lastError);
            }

            $this->binaryStringHelper->encodeBinaryString($result);

            $json = @json_encode($result);
            $lastError = json_last_error();
            if ($lastError != JSON_ERROR_NONE) {
                throw $this->createEncodingException($lastError);
            }
        }

        try {
            $hydrated = $this->serializer->deserialize($json, $resultType, 'json');

            /**
             * Workaround for JMS Serializer bug #9
             * @see https://github.com/schmittjoh/serializer/issues/9
             */
            if (substr($resultType, 0, 16) == 'ArrayCollection' && is_array($hydrated)) {
                $hydrated = new ArrayCollection($hydrated);
            }

            return $hydrated;
        } catch (\Exception $e) {
            throw new HydrationException(
                sprintf('Error during result hydration to type "%s"', $resultType),
                null,
                $e
            );
        }
    }

    /**
     * @param int $lastError
     * @return HydrationException
     */
    private function createEncodingException($lastError)
    {
        $msg = 'Unknown error';
        switch ($lastError) {
            case JSON_ERROR_DEPTH:
                $msg = 'The maximum stack depth has been exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $msg = 'Invalid or malformed JSON';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $msg = 'Control character error, possibly incorrectly encoded';
                break;
            case JSON_ERROR_SYNTAX:
                $msg = 'Syntax error';
                break;
            case JSON_ERROR_UTF8:
                $msg = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $msg = defined(JSON_ERROR_RECURSION) && $lastError == JSON_ERROR_RECURSION
                    ? 'One or more recursive references in the value to be encoded' : '';

                $msg = defined(JSON_ERROR_INF_OR_NAN) && $lastError == JSON_ERROR_INF_OR_NAN
                    ? 'One or more NAN or INF values in the value to be encoded' : '';

                $msg = defined(JSON_ERROR_UNSUPPORTED_TYPE) && $lastError == JSON_ERROR_UNSUPPORTED_TYPE ?
                    'A value of a type that cannot be encoded was given' : '';
        }

        return new HydrationException(
            sprintf('Could not serialized result into JSON. (Error: %s - %s)', $lastError, $msg)
        );
    }
}
