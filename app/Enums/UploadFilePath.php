<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UploadFilePath extends Enum
{
    const CATEGORY = 'images/upload/category';
    const USER = 'images/upload/user';
}
