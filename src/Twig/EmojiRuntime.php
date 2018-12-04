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
            'strings' => ['Du: 󰀀'],
            'svg' => '<svg class="emoji" aria-labelledby="js_8yo" height="100%" role="img" version="1.1" viewBox="0 0 256 256" width="100%" x="0px" y="0px"><title id="js_8yo">„Daumen hoch“-Symbol</title><g><g><polyline fill="transparent" points="256,0 258,256 2,258 "></polyline><path d="M254,147.1c0-12.7-4.4-16.4-9-20.1c2.6-4.2,5.1-10.2,5.1-18c0-15.8-12.3-25.7-32-25.7h-52c-0.5,0-1-0.5-0.9-1 c1.4-8.6,3-24,3-31.7c0-16.7-4-37.5-19.3-45.7c-4.5-2.4-8.3-3.7-14.1-3.7c-8.8,0-14.6,3.6-16.7,5.9c-1.3,1.4-1.9,3.3-1.8,5.2 l1.3,34.6c0.2,2.8-0.3,5.4-1.6,7.7l-24,47.8c-1.7,3.5-4.2,6.6-7.6,8.5c-3.5,2-6.5,5.9-6.5,9.5v94.8C78,230,94,238,112.3,238h86.1 c13.5,0,22.4-4.5,27.2-13.5c4.4-8.2,3.2-15.8,1.4-21.5c7.4-2.3,14.8-8,16.9-18.3c1.3-6.6-0.7-12.1-2.9-16.2 C247.5,165,254,159.8,254,147.1z" fill="#0084ff" stroke="transparent" stroke-linecap="round" stroke-width="5%"></path><path fill="#0084ff" d="M56.2,100H13.8C7.3,100,2,105.3,2,111.8v128.5c0,6.5,5.3,11.8,11.8,11.8h42.4c6.5,0,11.8-5.3,11.8-11.8V111.8 C68,105.3,62.7,100,56.2,100z"></path></g></g></svg>'
        ],
    ];

    public function __construct()
    {
        // this simple example doesn't define any dependency, but in your own
        // extensions, you'll need to inject services using this constructor
    }

    public function isOnlyEmoji($string) {
        $regex = '/^((<img class="emoji"(\s)*src="[\w\/\.]*"(\s)*\/>(\s)*)+)|(<svg class="emoji".*<\/svg>)$/';
        $string = preg_replace($regex, '', $string);
        $string = trim($string);
        return !mb_strlen($string) > 0;
    }

    public function emojiReplace($string)
    {
        $package = new Package(new EmptyVersionStrategy());

        foreach (self::EMOJI_MAP as $emoji) {
            if (array_key_exists('image', $emoji)) {
                $src =  $package->getUrl('build/images/emojis/' . $emoji['image'] . '.png');
                $replacement = '<img class="emoji" src="' . $src . '" />' ;
            } elseif (array_key_exists('svg', $emoji)) {
                $replacement = $emoji['svg'];
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

        return $string;
    }

}