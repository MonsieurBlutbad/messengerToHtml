<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 25.11.18
 * Time: 12:02
*/

namespace App\Twig;

use App\Twig\EmojiRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigTest;

class EmojiExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            // the logic of this filter is now implemented in a different class
            new TwigFilter('emoji_replace', array(EmojiRuntime::class, 'emojiReplace')),

        );
    }

    public function getTests()
    {
        return [
            new TwigTest('only_emoji', array(EmojiRuntime::class, 'isOnlyEmoji')),
        ];
    }
}