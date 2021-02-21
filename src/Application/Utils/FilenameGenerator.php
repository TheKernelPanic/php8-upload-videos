<?php

declare(strict_types=1);

namespace Src\Application\Utils;

use function strlen;
use function substr;
use function rand;

/**
 * Class FilenameGenerator
 * @package Src\Application\Utils
 */
class FilenameGenerator
{
    public const DEFAULT_LENGTH = 32;

    /**
     * @param string $extension
     * @param int $length
     * @return string
     */
    public static function generate(string $extension, int $length = self::DEFAULT_LENGTH): string
    {
        $filename = '';
        $randomize = 'abcdef0123456789';

        while (strlen($filename) < $length) {
            $filename .= substr($randomize, rand(0, strlen($randomize)), 1);
        }
        return "{$filename}.{$extension}";
    }
}