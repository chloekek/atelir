<?php
declare(strict_types = 1);
require_once __DIR__ . '/../lib/setup.php';

use Atelir\Layout;

final
class FeaturedPost
{
    public string $title;
    public string $excerpt;

    public
    function __construct(string $title, string $excerpt)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
    }
}

Layout::layout('Home', function(): void {
    $fps = [
        new FeaturedPost('Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse eget urna sit amet nulla feugiat finibus. Phasellus porttitor magna ut nulla tristique, in aliquam tortor mattis. Quisque euismod scelerisque ipsum, at egestas metus varius at. Morbi eget risus pulvinar, efficitur magna commodo, egestas nibh. Etiam fringilla turpis a est eleifend, eu suscipit nisl pellentesque. Quisque eu sapien et leo commodo cursus. Quisque dapibus consectetur neque, eu mattis dolor varius eget. Cras ut mi eget ex auctor maximus vulputate sit amet est. Fusce volutpat dignissim fermentum. Etiam sit amet ligula pretium, iaculis nisi eu, ultricies massa. Aliquam non auctor sapien. Nullam eros erat, vestibulum sed quam eget, vulputate accumsan ipsum. Pellentesque tempor diam in magna vehicula porttitor. Donec nisl massa, ultrices eget tellus laoreet, tristique vulputate ex. Aenean et dui nec sem lacinia sodales ac pulvinar metus. Sed a quam velit.'),
        new FeaturedPost('لكن لا بد أن أوضح', 'لكن لا بد أن أوضح لك أن كل هذه الأفكار المغلوطة حول استنكار  النشوة وتمجيد الألم نشأت بالفعل، وسأعرض لك التفاصيل لتكتشف حقيقة وأساس تلك السعادة البشرية، فلا أحد يرفض أو يكره أو يتجنب الشعور بالسعادة، ولكن بفضل هؤلاء الأشخاص الذين لا يدركون بأن السعادة لا بد أن نستشعرها بصورة أكثر عقلانية ومنطقية فيعرضهم هذا لمواجهة الظروف الأليمة، وأكرر بأنه لا يوجد من يرغب في الحب ونيل المنال ويتلذذ بالآلام، الألم هو الألم ولكن نتيجة لظروف ما قد تكمن السعاده فيما نتحمله من كد وأسي.'),
        new FeaturedPost('あの方が言われる事を', 'あの方が言われる事を、何でもしてあげて下さい。 いまはもうこの種のちょうは絶えてしまっている。 あら、申し訳ございません。 ああいう洗練された人々の中で、自分はまったく場違いな気がした。 またいつか風のように走るんだ。 いいからさっき盗ったモノを、カバンの中から出しなさい。 あなたは大学で何を勉強したいのですか。 ９０歳以上生きることは決してまれではない。 あばたもえくぼ」って言うからね。 いい手品師になろうと本気で思っている。'),
    ];
    foreach ($fps as $fp) {
        echo '<article dir="auto">';
        echo '<h1>';
        echo \htmlentities($fp->title);
        echo '</h1>';
        echo '<p>';
        echo \htmlentities($fp->excerpt);
        echo '</p>';
        echo '</article>';
    }
});
