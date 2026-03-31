<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\FoodItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear old data and reseed with furigana
        Question::truncate();
        FoodItem::truncate();
        $this->seedAruIruQuestions();
        $this->seedDashiShiQuestions();
        $this->seedFoodItems();
        echo "Seeded successfully!\n";
    }

    private function seedAruIruQuestions(): void
    {
        $qs = [
            [1,'つくえの<ruby>上<rt>うえ</rt></ruby>にほんが＿＿。','ある','いる','本は物です。物には「ある」/ Books are things. Use aru.'],
            [1,'<ruby>友<rt>とも</rt></ruby>だちが<ruby>部屋<rt>へや</rt></ruby>に＿＿。','いる','ある','友だちは人です。/ Friends are people. Use iru.'],
            [1,'テーブルの<ruby>上<rt>うえ</rt></ruby>にりんごが＿＿。','ある','いる','りんごは物です。/ Apples are things.'],
            [1,'<ruby>先生<rt>せんせい</rt></ruby>が<ruby>教室<rt>きょうしつ</rt></ruby>に＿＿。','いる','ある','先生は人です。/ Teachers are people.'],
            [1,'かばんの<ruby>中<rt>なか</rt></ruby>にペンが＿＿。','ある','いる','ペンは物です。/ Pens are things.'],
            [2,'<ruby>庭<rt>にわ</rt></ruby>にねこが＿＿。','いる','ある','ねこは<ruby>動物<rt>どうぶつ</rt></ruby>です。動物にも「いる」/ Cats are animals. Use iru.'],
            [2,'<ruby>冷蔵庫<rt>れいぞうこ</rt></ruby>に<ruby>牛乳<rt>ぎゅうにゅう</rt></ruby>が＿＿。','ある','いる','牛乳は物です。/ Milk is a thing.'],
            [2,'<ruby>公園<rt>こうえん</rt></ruby>に<ruby>子供<rt>こども</rt></ruby>が＿＿。','いる','ある','子供は人です。/ Children are people.'],
            [2,'<ruby>水<rt>みず</rt></ruby>の<ruby>中<rt>なか</rt></ruby>に<ruby>魚<rt>さかな</rt></ruby>が＿＿。','いる','ある','魚は動物です。/ Fish are animals.'],
            [2,'<ruby>駅<rt>えき</rt></ruby>の<ruby>前<rt>まえ</rt></ruby>にコンビニが＿＿。','ある','いる','コンビニは<ruby>建物<rt>たてもの</rt></ruby>です。/ Buildings use aru.'],
            [3,'<ruby>明日<rt>あした</rt></ruby>テストが＿＿。','ある','いる','テスト(イベント)には「ある」/ Events use aru.'],
            [3,'あの<ruby>人<rt>ひと</rt></ruby>には<ruby>才能<rt>さいのう</rt></ruby>が＿＿。','ある','いる','才能は<ruby>抽象的<rt>ちゅうしょうてき</rt></ruby>。/ Talent is abstract. Use aru.'],
            [3,'<ruby>隣<rt>となり</rt></ruby>の<ruby>家<rt>いえ</rt></ruby>に<ruby>赤<rt>あか</rt></ruby>ちゃんが＿＿。','いる','ある','赤ちゃんは人。/ Babies are people.'],
            [3,'<ruby>来週<rt>らいしゅう</rt></ruby>パーティーが＿＿。','ある','いる','パーティー(イベント)/ Parties use aru.'],
            [3,'<ruby>木<rt>き</rt></ruby>の<ruby>上<rt>うえ</rt></ruby>に<ruby>鳥<rt>とり</rt></ruby>が＿＿。','いる','ある','鳥は動物。/ Birds are animals.'],
            [4,'この<ruby>町<rt>まち</rt></ruby>には<ruby>古<rt>ふる</rt></ruby>いお<ruby>寺<rt>てら</rt></ruby>が＿＿。','ある','いる','お寺は建物。/ Temples are buildings.'],
            [4,'<ruby>私<rt>わたし</rt></ruby>には<ruby>兄弟<rt>きょうだい</rt></ruby>が<ruby>三人<rt>さんにん</rt></ruby>＿＿。','いる','ある','兄弟は人。/ Siblings are people.'],
            [4,'<ruby>彼<rt>かれ</rt></ruby>には<ruby>経験<rt>けいけん</rt></ruby>が＿＿。','ある','いる','経験は抽象的。/ Experience is abstract.'],
            [4,'あそこにタクシーが＿＿。','ある','いる','タクシーは<ruby>乗<rt>の</rt></ruby>り<ruby>物<rt>もの</rt></ruby>。/ Vehicles use aru.'],
            [4,'<ruby>池<rt>いけ</rt></ruby>にカメが＿＿。','いる','ある','カメは動物。/ Turtles are animals.'],
            [5,'<ruby>道<rt>みち</rt></ruby>の<ruby>横<rt>よこ</rt></ruby>に<ruby>自動販売機<rt>じどうはんばいき</rt></ruby>が＿＿。','ある','いる','自動販売機は<ruby>機械<rt>きかい</rt></ruby>。/ Machines use aru.'],
            [5,'<ruby>棚<rt>たな</rt></ruby>の<ruby>上<rt>うえ</rt></ruby>に<ruby>人形<rt>にんぎょう</rt></ruby>が＿＿。','ある','いる','人形は物。/ Dolls use aru.'],
            [5,'<ruby>会議<rt>かいぎ</rt></ruby>に<ruby>参加者<rt>さんかしゃ</rt></ruby>が<ruby>大勢<rt>おおぜい</rt></ruby>＿＿。','いる','ある','参加者は人。/ Participants are people.'],
            [5,'<ruby>彼女<rt>かのじょ</rt></ruby>には<ruby>問題<rt>もんだい</rt></ruby>を<ruby>解決<rt>かいけつ</rt></ruby>する<ruby>力<rt>ちから</rt></ruby>が＿＿。','ある','いる','力(能力)は抽象的。/ Ability is abstract.'],
            [5,'<ruby>森<rt>もり</rt></ruby>の<ruby>中<rt>なか</rt></ruby>にクマが＿＿。','いる','ある','クマは動物。/ Bears are animals.'],
            [6,'この<ruby>計画<rt>けいかく</rt></ruby>にはリスクが＿＿。','ある','いる','リスクは抽象的。/ Risk is abstract.'],
            [6,'<ruby>受付<rt>うけつけ</rt></ruby>に<ruby>案内係<rt>あんないがかり</rt></ruby>が＿＿。','いる','ある','案内係は人。/ Receptionists are people.'],
            [6,'<ruby>日本<rt>にほん</rt></ruby>には<ruby>四季<rt>しき</rt></ruby>が＿＿。','ある','いる','四季は抽象的。/ Seasons are abstract.'],
            [6,'<ruby>近所<rt>きんじょ</rt></ruby>に<ruby>親切<rt>しんせつ</rt></ruby>なおばあさんが＿＿。','いる','ある','おばあさんは人。/ People use iru.'],
            [6,'<ruby>地下<rt>ちか</rt></ruby>に<ruby>駐車場<rt>ちゅうしゃじょう</rt></ruby>が＿＿。','ある','いる','駐車場は<ruby>施設<rt>しせつ</rt></ruby>。/ Facilities use aru.'],
            [7,'この<ruby>提案<rt>ていあん</rt></ruby>には<ruby>説得力<rt>せっとくりょく</rt></ruby>が＿＿。','ある','いる','説得力は抽象的。/ Persuasiveness is abstract.'],
            [7,'<ruby>被災地<rt>ひさいち</rt></ruby>にはまだ<ruby>避難者<rt>ひなんしゃ</rt></ruby>が<ruby>大勢<rt>おおぜい</rt></ruby>＿＿。','いる','ある','避難者は人。/ Evacuees are people.'],
            [7,'<ruby>両者<rt>りょうしゃ</rt></ruby>の<ruby>間<rt>あいだ</rt></ruby>には<ruby>大<rt>おお</rt></ruby>きな<ruby>差<rt>さ</rt></ruby>が＿＿。','ある','いる','差は抽象的。/ Difference is abstract.'],
            [7,'<ruby>映画館<rt>えいがかん</rt></ruby>の<ruby>前<rt>まえ</rt></ruby>に<ruby>長<rt>なが</rt></ruby>い<ruby>行列<rt>ぎょうれつ</rt></ruby>が＿＿。','ある','いる','行列は<ruby>集合体<rt>しゅうごうたい</rt></ruby>。/ A queue uses aru.'],
            [7,'<ruby>研究室<rt>けんきゅうしつ</rt></ruby>に<ruby>教授<rt>きょうじゅ</rt></ruby>が＿＿。','いる','ある','教授は人。/ Professors are people.'],
            [8,'この<ruby>法律<rt>ほうりつ</rt></ruby>には<ruby>矛盾<rt>むじゅん</rt></ruby>が＿＿。','ある','いる','矛盾は抽象的。/ Contradiction is abstract.'],
            [8,'<ruby>委員会<rt>いいんかい</rt></ruby>に<ruby>反対派<rt>はんたいは</rt></ruby>の<ruby>議員<rt>ぎいん</rt></ruby>が＿＿。','いる','ある','議員は人。/ Lawmakers are people.'],
            [8,'<ruby>契約書<rt>けいやくしょ</rt></ruby>に<ruby>不備<rt>ふび</rt></ruby>が＿＿。','ある','いる','不備は抽象的。/ Deficiency is abstract.'],
            [8,'<ruby>海外<rt>かいがい</rt></ruby>にも<ruby>支持者<rt>しじしゃ</rt></ruby>が＿＿。','いる','ある','支持者は人。/ Supporters are people.'],
            [8,'この<ruby>地域<rt>ちいき</rt></ruby>には<ruby>独自<rt>どくじ</rt></ruby>の<ruby>文化<rt>ぶんか</rt></ruby>が＿＿。','ある','いる','文化は抽象的。/ Culture is abstract.'],
            [9,'<ruby>彼<rt>かれ</rt></ruby>の<ruby>発言<rt>はつげん</rt></ruby>には<ruby>含蓄<rt>がんちく</rt></ruby>が＿＿。','ある','いる','含蓄は抽象的。/ Implication is abstract.'],
            [9,'<ruby>当該<rt>とうがい</rt></ruby><ruby>施設<rt>しせつ</rt></ruby>には<ruby>常駐<rt>じょうちゅう</rt></ruby>の<ruby>警備員<rt>けいびいん</rt></ruby>が＿＿。','いる','ある','警備員は人。/ Guards are people.'],
            [9,'その<ruby>主張<rt>しゅちょう</rt></ruby>には<ruby>一理<rt>いちり</rt></ruby>が＿＿。','ある','いる','一理は抽象的。/ A point is abstract.'],
            [9,'<ruby>被告人<rt>ひこくにん</rt></ruby>の<ruby>証言<rt>しょうげん</rt></ruby>には<ruby>信憑性<rt>しんぴょうせい</rt></ruby>が＿＿。','ある','いる','信憑性は抽象的。/ Credibility is abstract.'],
            [9,'<ruby>過疎地<rt>かそち</rt></ruby>にも<ruby>献身的<rt>けんしんてき</rt></ruby>な<ruby>医師<rt>いし</rt></ruby>が＿＿。','いる','ある','医師は人。/ Doctors are people.'],
            [10,'この<ruby>論文<rt>ろんぶん</rt></ruby>には<ruby>看過<rt>かんか</rt></ruby>できない<ruby>誤謬<rt>ごびゅう</rt></ruby>が＿＿。','ある','いる','誤謬は抽象的。/ Fallacy is abstract.'],
            [10,'<ruby>国境<rt>こっきょう</rt></ruby><ruby>付近<rt>ふきん</rt></ruby>に<ruby>難民<rt>なんみん</rt></ruby>が＿＿。','いる','ある','難民は人。/ Refugees are people.'],
            [10,'<ruby>彼<rt>かれ</rt></ruby>の<ruby>作品<rt>さくひん</rt></ruby>には<ruby>崇高<rt>すうこう</rt></ruby>な<ruby>美<rt>び</rt></ruby>が＿＿。','ある','いる','美は抽象的。/ Beauty is abstract.'],
            [10,'<ruby>辺境<rt>へんきょう</rt></ruby>の<ruby>地<rt>ち</rt></ruby>にも<ruby>誇<rt>ほこ</rt></ruby>り<ruby>高<rt>たか</rt></ruby>い<ruby>民<rt>たみ</rt></ruby>が＿＿。','いる','ある','民は人。/ People use iru.'],
            [10,'この<ruby>制度<rt>せいど</rt></ruby>には<ruby>構造的<rt>こうぞうてき</rt></ruby>な<ruby>欠陥<rt>けっかん</rt></ruby>が＿＿。','ある','いる','欠陥は抽象的。/ Defect is abstract.'],
        ];
        foreach ($qs as $q) {
            Question::create(['mode'=>'aru_iru','level'=>$q[0],'sentence'=>$q[1],'correct_answer'=>$q[2],'wrong_answer'=>$q[3],'explanation'=>$q[4]]);
        }
    }

    private function seedDashiShiQuestions(): void
    {
        $qs = [
            [1,'この<ruby>花<rt>はな</rt></ruby>はきれい＿＿、いいにおいもする。','だし','し','「きれい」はな<ruby>形容詞<rt>けいようし</rt></ruby>。な形容詞+だし / Na-adj + dashi.'],
            [1,'このケーキはおいしい＿＿、<ruby>安<rt>やす</rt></ruby>い。','し','だし','「おいしい」はい形容詞。い形容詞+し / I-adj + shi.'],
            [1,'<ruby>彼<rt>かれ</rt></ruby>は<ruby>親切<rt>しんせつ</rt></ruby>＿＿、<ruby>面白<rt>おもしろ</rt></ruby>い。','だし','し','「親切」はな形容詞。/ Na-adj + dashi.'],
            [1,'この<ruby>部屋<rt>へや</rt></ruby>は<ruby>広<rt>ひろ</rt></ruby>い＿＿、<ruby>明<rt>あか</rt></ruby>るい。','し','だし','「広い」はい形容詞。/ I-adj + shi.'],
            [1,'あの<ruby>先生<rt>せんせい</rt></ruby>は<ruby>有名<rt>ゆうめい</rt></ruby>＿＿、すごい。','だし','し','「有名」はな形容詞。/ Na-adj + dashi.'],
            [2,'この<ruby>本<rt>ほん</rt></ruby>はつまらない＿＿、<ruby>長<rt>なが</rt></ruby>い。','し','だし','「つまらない」はい形容詞。/ I-adj + shi.'],
            [2,'この<ruby>町<rt>まち</rt></ruby>は<ruby>静<rt>しず</rt></ruby>か＿＿、きれい。','だし','し','「静か」はな形容詞。/ Na-adj + dashi.'],
            [2,'<ruby>今日<rt>きょう</rt></ruby>は<ruby>暑<rt>あつ</rt></ruby>い＿＿、<ruby>湿度<rt>しつど</rt></ruby>も<ruby>高<rt>たか</rt></ruby>い。','し','だし','「暑い」はい形容詞。/ I-adj + shi.'],
            [2,'あの<ruby>人<rt>ひと</rt></ruby>は<ruby>元気<rt>げんき</rt></ruby>＿＿、<ruby>優<rt>やさ</rt></ruby>しい。','だし','し','「元気」はな形容詞。/ Na-adj + dashi.'],
            [2,'このかばんは<ruby>軽<rt>かる</rt></ruby>い＿＿、<ruby>丈夫<rt>じょうぶ</rt></ruby>だ。','し','だし','「軽い」はい形容詞。/ I-adj + shi.'],
            [3,'この<ruby>仕事<rt>しごと</rt></ruby>は<ruby>大変<rt>たいへん</rt></ruby>＿＿、<ruby>給料<rt>きゅうりょう</rt></ruby>も<ruby>安<rt>やす</rt></ruby>い。','だし','し','「大変」はな形容詞。/ Na-adj + dashi.'],
            [3,'<ruby>日本語<rt>にほんご</rt></ruby>は<ruby>難<rt>むずか</rt></ruby>しい＿＿、<ruby>漢字<rt>かんじ</rt></ruby>も<ruby>多<rt>おお</rt></ruby>い。','し','だし','「難しい」はい形容詞。/ I-adj + shi.'],
            [3,'あのレストランは<ruby>便利<rt>べんり</rt></ruby>＿＿、おいしい。','だし','し','「便利」はな形容詞。/ Na-adj + dashi.'],
            [3,'<ruby>冬<rt>ふゆ</rt></ruby>は<ruby>寒<rt>さむ</rt></ruby>い＿＿、<ruby>日<rt>ひ</rt></ruby>も<ruby>短<rt>みじか</rt></ruby>い。','し','だし','「寒い」はい形容詞。/ I-adj + shi.'],
            [3,'<ruby>彼女<rt>かのじょ</rt></ruby>は<ruby>真面目<rt>まじめ</rt></ruby>＿＿、<ruby>頭<rt>あたま</rt></ruby>もいい。','だし','し','「真面目」はな形容詞。/ Na-adj + dashi.'],
            [4,'この<ruby>映画<rt>えいが</rt></ruby>は<ruby>怖<rt>こわ</rt></ruby>い＿＿、<ruby>長<rt>なが</rt></ruby>すぎる。','し','だし','「怖い」はい形容詞。/ I-adj + shi.'],
            [4,'あの<ruby>歌手<rt>かしゅ</rt></ruby>は<ruby>上手<rt>じょうず</rt></ruby>＿＿、かっこいい。','だし','し','「上手」はな形容詞。/ Na-adj + dashi.'],
            [4,'<ruby>電車<rt>でんしゃ</rt></ruby>は<ruby>速<rt>はや</rt></ruby>い＿＿、<ruby>時間<rt>じかん</rt></ruby>に<ruby>正確<rt>せいかく</rt></ruby>だ。','し','だし','「速い」はい形容詞。/ I-adj + shi.'],
            [4,'この<ruby>公園<rt>こうえん</rt></ruby>は<ruby>安全<rt>あんぜん</rt></ruby>＿＿、<ruby>広<rt>ひろ</rt></ruby>い。','だし','し','「安全」はな形容詞。/ Na-adj + dashi.'],
            [4,'あの<ruby>店<rt>みせ</rt></ruby>は<ruby>近<rt>ちか</rt></ruby>い＿＿、<ruby>品物<rt>しなもの</rt></ruby>もいい。','し','だし','「近い」はい形容詞。/ I-adj + shi.'],
            [5,'<ruby>彼<rt>かれ</rt></ruby>は<ruby>医者<rt>いしゃ</rt></ruby>＿＿、<ruby>経験<rt>けいけん</rt></ruby>も<ruby>豊富<rt>ほうふ</rt></ruby>だ。','だし','し','「医者」は<ruby>名詞<rt>めいし</rt></ruby>。名詞+だし / Noun + dashi.'],
            [5,'この<ruby>料理<rt>りょうり</rt></ruby>は<ruby>珍<rt>めずら</rt></ruby>しい＿＿、<ruby>美味<rt>おい</rt></ruby>しい。','し','だし','「珍しい」はい形容詞。/ I-adj + shi.'],
            [5,'<ruby>今日<rt>きょう</rt></ruby>は<ruby>日曜日<rt>にちようび</rt></ruby>＿＿、<ruby>天気<rt>てんき</rt></ruby>もいい。','だし','し','「日曜日」は名詞。/ Noun + dashi.'],
            [5,'あの<ruby>子<rt>こ</rt></ruby>はまだ<ruby>若<rt>わか</rt></ruby>い＿＿、<ruby>経験<rt>けいけん</rt></ruby>も<ruby>少<rt>すく</rt></ruby>ない。','し','だし','「若い」はい形容詞。/ I-adj + shi.'],
            [5,'このホテルは<ruby>豪華<rt>ごうか</rt></ruby>＿＿、サービスもいい。','だし','し','「豪華」はな形容詞。/ Na-adj + dashi.'],
            [6,'<ruby>値段<rt>ねだん</rt></ruby>も<ruby>手頃<rt>てごろ</rt></ruby>＿＿、<ruby>品質<rt>ひんしつ</rt></ruby>もいい。','だし','し','「手頃」はな形容詞。/ Na-adj + dashi.'],
            [6,'<ruby>通勤<rt>つうきん</rt></ruby><ruby>時間<rt>じかん</rt></ruby>も<ruby>短<rt>みじか</rt></ruby>い＿＿、<ruby>家賃<rt>やちん</rt></ruby>も<ruby>安<rt>やす</rt></ruby>い。','し','だし','「短い」はい形容詞。/ I-adj + shi.'],
            [6,'この<ruby>地域<rt>ちいき</rt></ruby>は<ruby>不便<rt>ふべん</rt></ruby>＿＿、<ruby>物価<rt>ぶっか</rt></ruby>も<ruby>高<rt>たか</rt></ruby>い。','だし','し','「不便」はな形容詞。/ Na-adj + dashi.'],
            [6,'<ruby>彼<rt>かれ</rt></ruby>の<ruby>意見<rt>いけん</rt></ruby>は<ruby>正<rt>ただ</rt></ruby>しい＿＿、<ruby>分<rt>わ</rt></ruby>かりやすい。','し','だし','「正しい」はい形容詞。/ I-adj + shi.'],
            [6,'この<ruby>製品<rt>せいひん</rt></ruby>は<ruby>高品質<rt>こうひんしつ</rt></ruby>＿＿、デザインもいい。','だし','し','「高品質」はな形容詞。/ Na-adj + dashi.'],
            [7,'この<ruby>提案<rt>ていあん</rt></ruby>は<ruby>合理的<rt>ごうりてき</rt></ruby>＿＿、<ruby>実現<rt>じつげん</rt></ruby><ruby>可能<rt>かのう</rt></ruby>だ。','だし','し','「合理的」はな形容詞。/ Na-adj + dashi.'],
            [7,'<ruby>景気<rt>けいき</rt></ruby>は<ruby>悪<rt>わる</rt></ruby>い＿＿、<ruby>先行<rt>せんこう</rt></ruby>きも<ruby>不透明<rt>ふとうめい</rt></ruby>だ。','し','だし','「悪い」はい形容詞。/ I-adj + shi.'],
            [7,'この<ruby>研究<rt>けんきゅう</rt></ruby>は<ruby>画期的<rt>かっきてき</rt></ruby>＿＿、<ruby>応用<rt>おうよう</rt></ruby><ruby>範囲<rt>はんい</rt></ruby>も<ruby>広<rt>ひろ</rt></ruby>い。','だし','し','「画期的」はな形容詞。/ Na-adj + dashi.'],
            [7,'<ruby>人手<rt>ひとで</rt></ruby>が<ruby>足<rt>た</rt></ruby>りない＿＿、<ruby>予算<rt>よさん</rt></ruby>もない。','し','だし','「足りない」はい形容詞的。/ I-adj + shi.'],
            [7,'<ruby>彼女<rt>かのじょ</rt></ruby>は<ruby>誠実<rt>せいじつ</rt></ruby>＿＿、<ruby>責任感<rt>せきにんかん</rt></ruby>もある。','だし','し','「誠実」はな形容詞。/ Na-adj + dashi.'],
            [8,'この<ruby>問題<rt>もんだい</rt></ruby>は<ruby>深刻<rt>しんこく</rt></ruby>＿＿、<ruby>早急<rt>さっきゅう</rt></ruby>な<ruby>対策<rt>たいさく</rt></ruby>が<ruby>必要<rt>ひつよう</rt></ruby>だ。','だし','し','「深刻」はな形容詞。/ Na-adj + dashi.'],
            [8,'<ruby>証拠<rt>しょうこ</rt></ruby>が<ruby>少<rt>すく</rt></ruby>ない＿＿、<ruby>証人<rt>しょうにん</rt></ruby>もいない。','し','だし','「少ない」はい形容詞。/ I-adj + shi.'],
            [8,'<ruby>彼<rt>かれ</rt></ruby>の<ruby>態度<rt>たいど</rt></ruby>は<ruby>横柄<rt>おうへい</rt></ruby>＿＿、<ruby>非協力的<rt>ひきょうりょくてき</rt></ruby>だ。','だし','し','「横柄」はな形容詞。/ Na-adj + dashi.'],
            [8,'<ruby>交通<rt>こうつう</rt></ruby>の<ruby>便<rt>べん</rt></ruby>も<ruby>悪<rt>わる</rt></ruby>い＿＿、<ruby>治安<rt>ちあん</rt></ruby>も<ruby>良<rt>よ</rt></ruby>くない。','し','だし','「悪い」はい形容詞。/ I-adj + shi.'],
            [8,'この<ruby>政策<rt>せいさく</rt></ruby>は<ruby>公平<rt>こうへい</rt></ruby>＿＿、<ruby>透明性<rt>とうめいせい</rt></ruby>もある。','だし','し','「公平」はな形容詞。/ Na-adj + dashi.'],
            [9,'この<ruby>理論<rt>りろん</rt></ruby>は<ruby>斬新<rt>ざんしん</rt></ruby>＿＿、<ruby>実証的<rt>じっしょうてき</rt></ruby>でもある。','だし','し','「斬新」はな形容詞。/ Na-adj + dashi.'],
            [9,'<ruby>彼<rt>かれ</rt></ruby>の<ruby>主張<rt>しゅちょう</rt></ruby>は<ruby>鋭<rt>するど</rt></ruby>い＿＿、<ruby>論理的<rt>ろんりてき</rt></ruby>でもある。','し','だし','「鋭い」はい形容詞。/ I-adj + shi.'],
            [9,'この<ruby>事態<rt>じたい</rt></ruby>は<ruby>異常<rt>いじょう</rt></ruby>＿＿、<ruby>前例<rt>ぜんれい</rt></ruby>がない。','だし','し','「異常」はな形容詞。/ Na-adj + dashi.'],
            [9,'<ruby>手続<rt>てつづ</rt></ruby>きが<ruby>煩<rt>わずら</rt></ruby>わしい＿＿、<ruby>時間<rt>じかん</rt></ruby>もかかる。','し','だし','「煩わしい」はい形容詞。/ I-adj + shi.'],
            [9,'<ruby>彼<rt>かれ</rt></ruby>の<ruby>行動<rt>こうどう</rt></ruby>は<ruby>軽率<rt>けいそつ</rt></ruby>＿＿、<ruby>無責任<rt>むせきにん</rt></ruby>だ。','だし','し','「軽率」はな形容詞。/ Na-adj + dashi.'],
            [10,'この<ruby>戦略<rt>せんりゃく</rt></ruby>は<ruby>緻密<rt>ちみつ</rt></ruby>＿＿、<ruby>柔軟性<rt>じゅうなんせい</rt></ruby>もある。','だし','し','「緻密」はな形容詞。/ Na-adj + dashi.'],
            [10,'<ruby>状況<rt>じょうきょう</rt></ruby>は<ruby>厳<rt>きび</rt></ruby>しい＿＿、<ruby>楽観<rt>らっかん</rt></ruby>できない。','し','だし','「厳しい」はい形容詞。/ I-adj + shi.'],
            [10,'その<ruby>解釈<rt>かいしゃく</rt></ruby>は<ruby>妥当<rt>だとう</rt></ruby>＿＿、<ruby>説得力<rt>せっとくりょく</rt></ruby>もある。','だし','し','「妥当」はな形容詞。/ Na-adj + dashi.'],
            [10,'<ruby>期限<rt>きげん</rt></ruby>も<ruby>近<rt>ちか</rt></ruby>い＿＿、<ruby>準備<rt>じゅんび</rt></ruby>も<ruby>不十分<rt>ふじゅうぶん</rt></ruby>だ。','し','だし','「近い」はい形容詞。/ I-adj + shi.'],
            [10,'この<ruby>思想<rt>しそう</rt></ruby>は<ruby>革新的<rt>かくしんてき</rt></ruby>＿＿、<ruby>時代<rt>じだい</rt></ruby>を<ruby>先取<rt>さきど</rt></ruby>りしている。','だし','し','「革新的」はな形容詞。/ Na-adj + dashi.'],
        ];
        foreach ($qs as $q) {
            Question::create(['mode'=>'dashi_shi','level'=>$q[0],'sentence'=>$q[1],'correct_answer'=>$q[2],'wrong_answer'=>$q[3],'explanation'=>$q[4]]);
        }
    }

    private function seedFoodItems(): void
    {
        $foods = [
            ['ショートケーキ','Strawberry Shortcake','🍰','sweets'],['たい焼き','Taiyaki','🐟','sweets'],
            ['だんご','Dango','🍡','sweets'],['わらび餅','Warabi Mochi','🍵','sweets'],
            ['カステラ','Castella','🍞','sweets'],['どら焼き','Dorayaki','🥞','sweets'],
            ['大福','Daifuku','🤍','sweets'],['クレープ','Crepe','🌮','sweets'],
            ['プリン','Pudding','🍮','sweets'],['抹茶パフェ','Matcha Parfait','🍨','sweets'],
            ['寿司','Sushi','🍣','japanese'],['ラーメン','Ramen','🍜','japanese'],
            ['たこ焼き','Takoyaki','🐙','japanese'],['天ぷら','Tempura','🍤','japanese'],
            ['うどん','Udon','🍲','japanese'],['焼き鳥','Yakitori','🍢','japanese'],
            ['おにぎり','Onigiri','🍙','japanese'],['お好み焼き','Okonomiyaki','🥞','japanese'],
            ['味噌汁','Miso Soup','🥣','japanese'],['牛丼','Gyudon','🥩','japanese'],
            ['そば','Soba','🍝','japanese'],['カツカレー','Katsu Curry','🍛','japanese'],
            ['焼肉','Yakiniku','🥓','japanese'],['とんかつ','Tonkatsu','🍖','japanese'],
            ['刺身','Sashimi','🐟','japanese'],['メロンパン','Melon Pan','🍈','sweets'],
            ['ようかん','Yokan','🟤','sweets'],['アイスクリーム','Ice Cream','🍦','sweets'],
            ['チョコレート','Chocolate','🍫','sweets'],['今川焼き','Imagawayaki','🫓','sweets'],
            ['オムライス','Omurice','🍳','japanese'],['からあげ','Karaage','🍗','japanese'],
            ['餃子','Gyoza','🥟','japanese'],['枝豆','Edamame','🫛','japanese'],
            ['コロッケ','Croquette','🟤','japanese'],['茶碗蒸し','Chawanmushi','🥚','japanese'],
            ['親子丼','Oyakodon','🍚','japanese'],['カレーパン','Curry Bread','🥖','japanese'],
            ['焼きそば','Yakisoba','🍝','japanese'],['たまご焼き','Tamagoyaki','🥚','japanese'],
            ['抹茶ラテ','Matcha Latte','🍵','drinks'],['ラムネ','Ramune','🧊','drinks'],
            ['カルピス','Calpis','🥛','drinks'],['日本酒','Sake','🍶','drinks'],
            ['ほうじ茶','Houjicha','☕','drinks'],['いちご','Strawberry','🍓','fruits'],
            ['みかん','Mandarin Orange','🍊','fruits'],['もも','Peach','🍑','fruits'],
            ['すいか','Watermelon','🍉','fruits'],['ぶどう','Grapes','🍇','fruits'],
            ['肉まん','Nikuman','🫓','japanese'],['白玉','Shiratama','⚪','sweets'],
            ['おでん','Oden','🍢','japanese'],['せんべい','Senbei','🍘','sweets'],
            ['もんじゃ焼き','Monjayaki','🥘','japanese'],['冷やし中華','Hiyashi Chuka','🥗','japanese'],
            ['みたらし団子','Mitarashi Dango','🍡','sweets'],['チーズケーキ','Cheesecake','🧀','sweets'],
            ['和菓子','Wagashi','🌸','sweets'],['まぐろ丼','Maguro Don','🐟','japanese'],
            ['しゃぶしゃぶ','Shabu Shabu','🫕','japanese'],['すき焼き','Sukiyaki','🍲','japanese'],
            ['かき氷','Kakigori','🍧','sweets'],['ちらし寿司','Chirashi Sushi','🍣','japanese'],
            ['抹茶アイス','Matcha Ice Cream','🍨','sweets'],['焼き芋','Yaki Imo','🍠','japanese'],
            ['お茶漬け','Ochazuke','🍚','japanese'],['ハンバーグ','Hamburg Steak','🍔','japanese'],
            ['エビフライ','Ebi Furai','🍤','japanese'],['きなこ餅','Kinako Mochi','🟡','sweets'],
            ['あんみつ','Anmitsu','🍨','sweets'],['豚骨ラーメン','Tonkotsu Ramen','🍜','japanese'],
            ['つけ麺','Tsukemen','🍜','japanese'],['回転寿司','Kaiten Sushi','🍣','japanese'],
            ['たけのこ','Bamboo Shoots','🎋','japanese'],['赤飯','Sekihan','🍚','japanese'],
            ['おはぎ','Ohagi','🟤','sweets'],['サーターアンダギー','Sata Andagi','🍩','sweets'],
            ['桜餅','Sakura Mochi','🌸','sweets'],['たらこパスタ','Tarako Pasta','🍝','japanese'],
            ['抹茶ケーキ','Matcha Cake','🍰','sweets'],['鯛焼きアイス','Taiyaki Ice','🍦','sweets'],
            ['明太子おにぎり','Mentaiko Onigiri','🍙','japanese'],['豆大福','Mame Daifuku','🤍','sweets'],
            ['カツ丼','Katsudon','🍖','japanese'],['梅干し','Umeboshi','🔴','japanese'],
            ['わたあめ','Cotton Candy','☁️','sweets'],['焼きとうもろこし','Grilled Corn','🌽','japanese'],
            ['クリームソーダ','Cream Soda','🥤','drinks'],['りんご飴','Candy Apple','🍎','sweets'],
            ['納豆巻き','Natto Roll','🍣','japanese'],['柿','Persimmon','🟠','fruits'],
            ['栗きんとん','Kuri Kinton','🌰','sweets'],['あんぱん','Anpan','🍞','sweets'],
            ['海老天丼','Ebi Tendon','🍤','japanese'],['ミルクレープ','Mille Crepe','🍰','sweets'],
            ['鉄火巻き','Tekka Maki','🍣','japanese'],['いなり寿司','Inari Sushi','🍣','japanese'],
            ['ずんだ餅','Zunda Mochi','🟢','sweets'],['玉子豆腐','Tamago Tofu','🥚','japanese'],
        ];

        $index = 0;
        foreach (['aru_iru', 'dashi_shi'] as $mode) {
            for ($level = 1; $level <= 10; $level++) {
                for ($q = 0; $q < 5; $q++) {
                    if ($index < count($foods)) {
                        FoodItem::create([
                            'name' => $foods[$index][0],
                            'name_en' => $foods[$index][1],
                            'emoji' => $foods[$index][2],
                            'category' => $foods[$index][3],
                            'mode' => $mode,
                            'level' => $level,
                            'question_index' => $q,
                        ]);
                        $index++;
                    }
                }
            }
        }
    }
}
