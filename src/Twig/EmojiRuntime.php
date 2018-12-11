<?php
/**
 * Created by PhpStorm.
 * User: kay
 * Date: 25.11.18
 * Time: 12:03
 */

namespace App\Twig;

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Twig\Extension\RuntimeExtensionInterface;

class EmojiRuntime implements RuntimeExtensionInterface
{
    const EMOJI_MAP = [
        [
            'strings' => ['☺️'],
            'image' => 'beaming2'
        ], [
            'strings' => ['🙂', ':)', ':-)', ':-)️', '☺'],
            'image' => 'smiling'
        ], [
            'strings' => ['😟'],
            'image' => 'slightly_frowning'
        ], [
            'strings' => ['🙃'],
            'image' => 'smiling_reverse'
        ], [
            'strings' => ['😉', ';)', ';-)'],
            'image' => 'winking'
        ], [
            'strings' => ['😀', ':D', ':-D'],
            'image' => 'grinning'
        ], [
            'strings' => ['😄'],
            'image' => 'grinning2'
        ], [
            'strings' => ['😃'],
            'image' => 'grinning3'
        ], [
            'strings' => ['😯'],
            'image' => 'hushed'
        ], [
            'strings' => ['😛', ':-P', ':p'],
            'image' => 'stuck_out_tongue'
        ], [
            'strings' => ['😜', ';-P', ';p'],
            'image' => 'stuck_out_tongue_and_winking'
        ], [
            'strings' => ['😝'],
            'image' => 'tongue_out_and_squinting'
        ], [
            'strings' => ['😕'],
            'regex' => '/(?<!(https)|(http)|(ftp)):-?\//',
            'image' => 'confused'
        ], [
            'strings' => ['😂'],
            'image' => 'tears_of_joy'
        ], [
            'strings' => ['😐', ':|', ':-|'],
            'image' => 'neutral'
        ], [
            'strings' => ['❤️', '<3'],
            'image' => 'heart'
        ], [
            'strings' => ['😬'],
            'image' => 'grimacing'
        ], [
            'strings' => ['🙈'],
            'image' => 'no_see'
        ], [
            'strings' => ['🙊'],
            'image' => 'no_speak'
        ], [
            'strings' => ['🙉'],
            'image' => 'no_hear'
        ], [
            'strings' => ['💪'],
            'image' => 'biceps'
        ], [
            'strings' => ['🍺'],
            'image' => 'beer'
        ], [
            'strings' => ['🍻'],
            'image' => 'cheers'
        ], [
            'strings' => ['😊'],
            'image' => 'beaming'
        ], [
            'strings' => ['🎉'],
            'image' => 'party'
        ], [
            'strings' => ['😅'],
            'image' => 'smiling_cold_sweat'
        ], [
            'strings' => ['😖'],
            'image' => 'confounded'
        ], [
            'strings' => ['🔥'],
            'image' => 'fire'
        ], [
            'strings' => ['😍'],
            'image' => 'heart_eyes'
        ], [
            'strings' => ['😱'],
            'image' => 'scream'
        ], [
            'strings' => ['😒'],
            'image' => 'unamused'
        ], [
            'strings' => ['👉'],
            'image' => 'hand_pointing_right'
        ], [
            'strings' => ['😨'],
            'image' => 'fearful'
        ], [
            'strings' => ['🙄'],
            'image' => 'annoyed'
        ], [
            'strings' => ['🤔'],
            'image' => 'thinking'
        ], [
            'strings' => ['😮'],
            'image' => 'open_mouth'
        ], [
            'strings' => ['👌'],
            'image' => 'ok_hand'
        ], [
            'strings' => ['😭'],
            'image' => 'crying'
        ], [
            'strings' => ['✌'],
            'image' => 'victory_hand'
        ], [
            'strings' => ['😎'],
            'image' => 'glasses'
        ], [
            'strings' => ['😰'],
            'image' => 'cold_sweat'
        ], [
            'strings' => ['👍'],
            'image' => 'thumbs_up'
        ], [
            'strings' => ['💁'],
            'image' => 'woman_tipping_hand'
        ], [
            'strings' => ['👽'],
            'image' => 'alien'
        ], [
            'strings' => ['🙏'],
            'image' => 'folded_hands'
        ], [
            'strings' => ['🙌'],
            'image' => 'raising_both_hands'
        ], [
            'strings' => ['🐷'],
            'image' => 'pig'
        ], [
            'strings' => ['🐽'],
            'image' => 'pig_nose'
        ], [
            'strings' => ['✊'],
            'image' => 'raised_fist'
        ], [
            'strings' => ['😶'],
            'image' => 'no_mouth'
        ], [
            'strings' => ['😵'],
            'image' => 'dizzy'
        ], [
            'strings' => ['😩'],
            'image' => 'weary'
        ], [
            'strings' => ['😫'],
            'image' => 'tired'
        ], [
            'strings' => ['😴'],
            'image' => 'sleepy'
        ], [
            'strings' => ['😆'],
            'image' => 'smiling_with_closed_eyes'
        ], [
            'strings' => ['😞', ':(', ':-('],
            'image' => 'disappointed'
        ], [
            'strings' => ['💥'],
            'image' => 'explosion'
        ], [
            'strings' => ['👾'],
            'image' => 'space_invaders'
        ], [
            'strings' => ['💃'],
            'image' => 'dancing_woman'
        ], [
            'strings' => ['🤗'],
            'image' => 'hugging_face'
        ], [
            'strings' => ['🌞'],
            'image' => 'sun'
        ], [
            'strings' => ['🤘'],
            'image' => 'metal_hand'
        ], [
            'strings' => ['🌛'],
            'image' => 'quarter_moon'
        ], [
            'strings' => ['☕'],
            'image' => 'coffee'
        ], [
            'strings' => ['🍸'],
            'image' => 'cocktail_glass'
        ], [
            'strings' => ['🍷'],
            'image' => 'wine'
        ], [
            'strings' => ['💇'],
            'image' => 'woman_haircut'
        ], [
            'strings' => ['🚲'],
            'image' => 'bike'
        ], [
            'strings' => ['😸'],
            'image' => 'cat_grinning'
        ], [
            'strings' => ['👄'],
            'image' => 'mouth'
        ], [
            'strings' => ['😇'],
            'image' => 'innocent'
        ], [
            'strings' => ['😏'],
            'image' => 'smirking'
        ], [
            'strings' => ['👊'],
            'image' => 'fist'
        ], [
            'strings' => ['🐏'],
            'image' => 'ram'
        ], [
            'strings' => ['🐐'],
            'image' => 'goat'
        ], [
            'strings' => ['👹'],
            'image' => 'japanese_ogre'
        ], [
            'strings' => ['👣'],
            'image' => 'feet'
        ], [
            'strings' => ['👗'],
            'image' => 'dress'
        ], [
            'strings' => ['❄'],
            'image' => 'snowflake'
        ], [
            'strings' => ['🛀'],
            'image' => 'bathtub'
        ], [
            'strings' => ['🇫🇷'],
            'image' => 'france'
        ], [
            'strings' => ['🇳🇴'],
            'image' => 'norway'
        ], [
            'strings' => ['🇩🇪'],
            'image' => 'germany'
        ], [
            'strings' => ['🎤'],
            'image' => 'microphone'
        ], [
            'strings' => ['Du: 󰀀', 'Micky: 󰀀'],
            'image' => 'svg-thumb'
        ],
    ];

    public function __construct()
    {
        // this simple example doesn't define any dependency, but in your own
        // extensions, you'll need to inject services using this constructor
    }

    public function isOnlyEmoji($string) {
        $regex = '/^((<img class="emoji"(\s)*src="[\w\/\.-]*"(\s)*\/>(\s)*)+)$/';
        $string = preg_replace($regex, '', $string);
        $string = trim($string);
        return !(mb_strlen($string) > 0);
    }

    public function emojiReplace($string, $sender)
    {
        $package = new Package(new EmptyVersionStrategy());
        foreach (self::EMOJI_MAP as $emoji) {
            if (array_key_exists('image', $emoji)) {
                $src =  $package->getUrl('/build/images/emojis/' . $emoji['image'] . '-' . $sender . '.jpg');
                $replacement = '<img class="emoji" src="' . $src . '" />' ;
            } else {
                throw new \Exception();
            }
            if (array_key_exists('regex', $emoji)) {
                $string = preg_replace($emoji['regex'], $replacement , $string);
            }
            if (array_key_exists('strings', $emoji)) {
                foreach ($emoji['strings'] as $search) {

                    $string = str_ireplace($search, $replacement, $string);
                }
            }
        }

        if ($this->isOnlyEmoji($string)) {
            $string = str_replace('-' . $sender . '.jpg', '-neutral.jpg', $string);
        }

        return $string;
    }

}