<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\FoodItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (Question::count() > 0) {
            echo "Data already seeded. Skipping.\n";
            return;
        }
        $this->seedAruIruQuestions();
        $this->seedDashiShiQuestions();
        $this->seedFoodItems();
        echo "Seeded successfully!\n";
    }

    private function seedAruIruQuestions(): void
    {
        $qs = [
            [1,'つくえの上にほんが＿＿。','ある','いる','本は物です。物には「ある」/ Books are things. Use aru.'],
            [1,'友だちが部屋に＿＿。','いる','ある','友だちは人です。/ Friends are people. Use iru.'],
            [1,'テーブルの上にりんごが＿＿。','ある','いる','りんごは物です。/ Apples are things.'],
            [1,'先生が教室に＿＿。','いる','ある','先生は人です。/ Teachers are people.'],
            [1,'かばんの中にペンが＿＿。','ある','いる','ペンは物です。/ Pens are things.'],
            [2,'庭にねこが＿＿。','いる','ある','ねこは動物です。動物にも「いる」/ Cats are animals. Use iru.'],
            [2,'冷蔵庫に牛乳が＿＿。','ある','いる','牛乳は物です。/ Milk is a thing.'],
            [2,'公園に子供が＿＿。','いる','ある','子供は人です。/ Children are people.'],
            [2,'水の中に魚が＿＿。','いる','ある','魚は動物です。/ Fish are animals.'],
            [2,'駅の前にコンビニが＿＿。','ある','いる','コンビニは建物です。/ Buildings use aru.'],
            [3,'明日テストが＿＿。','ある','いる','テスト(イベント)には「ある」/ Events use aru.'],
            [3,'あの人には才能が＿＿。','ある','いる','才能は抽象的。/ Talent is abstract. Use aru.'],
            [3,'隣の家に赤ちゃんが＿＿。','いる','ある','赤ちゃんは人。/ Babies are people.'],
            [3,'来週パーティーが＿＿。','ある','いる','パーティー(イベント)/ Parties use aru.'],
            [3,'木の上に鳥が＿＿。','いる','ある','鳥は動物。/ Birds are animals.'],
            [4,'この町には古いお寺が＿＿。','ある','いる','お寺は建物。/ Temples are buildings.'],
            [4,'私には兄弟が三人＿＿。','いる','ある','兄弟は人。/ Siblings are people.'],
            [4,'彼には経験が＿＿。','ある','いる','経験は抽象的。/ Experience is abstract.'],
            [4,'あそこにタクシーが＿＿。','ある','いる','タクシーは乗り物。/ Vehicles use aru.'],
            [4,'池にカメが＿＿。','いる','ある','カメは動物。/ Turtles are animals.'],
            [5,'道の横に自動販売機が＿＿。','ある','いる','自動販売機は機械。/ Machines use aru.'],
            [5,'棚の上に人形が＿＿。','ある','いる','人形は物。/ Dolls use aru.'],
            [5,'会議に参加者が大勢＿＿。','いる','ある','参加者は人。/ Participants are people.'],
            [5,'彼女には問題を解決する力が＿＿。','ある','いる','力(能力)は抽象的。/ Ability is abstract.'],
            [5,'森の中にクマが＿＿。','いる','ある','クマは動物。/ Bears are animals.'],
            [6,'この計画にはリスクが＿＿。','ある','いる','リスクは抽象的。/ Risk is abstract.'],
            [6,'受付に案内係が＿＿。','いる','ある','案内係は人。/ Receptionists are people.'],
            [6,'日本には四季が＿＿。','ある','いる','四季は抽象的。/ Seasons are abstract.'],
            [6,'近所に親切なおばあさんが＿＿。','いる','ある','おばあさんは人。/ People use iru.'],
            [6,'地下に駐車場が＿＿。','ある','いる','駐車場は施設。/ Facilities use aru.'],
            [7,'この提案には説得力が＿＿。','ある','いる','説得力は抽象的。/ Persuasiveness is abstract.'],
            [7,'被災地にはまだ避難者が大勢＿＿。','いる','ある','避難者は人。/ Evacuees are people.'],
            [7,'両者の間には大きな差が＿＿。','ある','いる','差は抽象的。/ Difference is abstract.'],
            [7,'映画館の前に長い行列が＿＿。','ある','いる','行列は集合体。/ A queue uses aru.'],
            [7,'研究室に教授が＿＿。','いる','ある','教授は人。/ Professors are people.'],
            [8,'この法律には矛盾が＿＿。','ある','いる','矛盾は抽象的。/ Contradiction is abstract.'],
            [8,'委員会に反対派の議員が＿＿。','いる','ある','議員は人。/ Lawmakers are people.'],
            [8,'契約書に不備が＿＿。','ある','いる','不備は抽象的。/ Deficiency is abstract.'],
            [8,'海外にも支持者が＿＿。','いる','ある','支持者は人。/ Supporters are people.'],
            [8,'この地域には独自の文化が＿＿。','ある','いる','文化は抽象的。/ Culture is abstract.'],
            [9,'彼の発言には含蓄が＿＿。','ある','いる','含蓄は抽象的。/ Implication is abstract.'],
            [9,'当該施設には常駐の警備員が＿＿。','いる','ある','警備員は人。/ Guards are people.'],
            [9,'その主張には一理が＿＿。','ある','いる','一理は抽象的。/ A point is abstract.'],
            [9,'被告人の証言には信憑性が＿＿。','ある','いる','信憑性は抽象的。/ Credibility is abstract.'],
            [9,'過疎地にも献身的な医師が＿＿。','いる','ある','医師は人。/ Doctors are people.'],
            [10,'この論文には看過できない誤謬が＿＿。','ある','いる','誤謬は抽象的。/ Fallacy is abstract.'],
            [10,'国境付近に難民が＿＿。','いる','ある','難民は人。/ Refugees are people.'],
            [10,'彼の作品には崇高な美が＿＿。','ある','いる','美は抽象的。/ Beauty is abstract.'],
            [10,'辺境の地にも誇り高い民が＿＿。','いる','ある','民は人。/ People use iru.'],
            [10,'この制度には構造的な欠陥が＿＿。','ある','いる','欠陥は抽象的。/ Defect is abstract.'],
        ];
        foreach ($qs as $q) {
            Question::create(['mode'=>'aru_iru','level'=>$q[0],'sentence'=>$q[1],'correct_answer'=>$q[2],'wrong_answer'=>$q[3],'explanation'=>$q[4]]);
        }
    }

    private function seedDashiShiQuestions(): void
    {
        $qs = [
            [1,'この花はきれい＿＿、いいにおいもする。','だし','し','「きれい」はな形容詞。な形容詞+だし / Na-adj + dashi.'],
            [1,'このケーキはおいしい＿＿、安い。','し','だし','「おいしい」はい形容詞。い形容詞+し / I-adj + shi.'],
            [1,'彼は親切＿＿、面白い。','だし','し','「親切」はな形容詞。/ Na-adj + dashi.'],
            [1,'この部屋は広い＿＿、明るい。','し','だし','「広い」はい形容詞。/ I-adj + shi.'],
            [1,'あの先生は有名＿＿、すごい。','だし','し','「有名」はな形容詞。/ Na-adj + dashi.'],
            [2,'この本はつまらない＿＿、長い。','し','だし','「つまらない」はい形容詞。/ I-adj + shi.'],
            [2,'この町は静か＿＿、きれい。','だし','し','「静か」はな形容詞。/ Na-adj + dashi.'],
            [2,'今日は暑い＿＿、湿度も高い。','し','だし','「暑い」はい形容詞。/ I-adj + shi.'],
            [2,'あの人は元気＿＿、優しい。','だし','し','「元気」はな形容詞。/ Na-adj + dashi.'],
            [2,'このかばんは軽い＿＿、丈夫だ。','し','だし','「軽い」はい形容詞。/ I-adj + shi.'],
            [3,'この仕事は大変＿＿、給料も安い。','だし','し','「大変」はな形容詞。/ Na-adj + dashi.'],
            [3,'日本語は難しい＿＿、漢字も多い。','し','だし','「難しい」はい形容詞。/ I-adj + shi.'],
            [3,'あのレストランは便利＿＿、おいしい。','だし','し','「便利」はな形容詞。/ Na-adj + dashi.'],
            [3,'冬は寒い＿＿、日も短い。','し','だし','「寒い」はい形容詞。/ I-adj + shi.'],
            [3,'彼女は真面目＿＿、頭もいい。','だし','し','「真面目」はな形容詞。/ Na-adj + dashi.'],
            [4,'この映画は怖い＿＿、長すぎる。','し','だし','「怖い」はい形容詞。/ I-adj + shi.'],
            [4,'あの歌手は上手＿＿、かっこいい。','だし','し','「上手」はな形容詞。/ Na-adj + dashi.'],
            [4,'電車は速い＿＿、時間に正確だ。','し','だし','「速い」はい形容詞。/ I-adj + shi.'],
            [4,'この公園は安全＿＿、広い。','だし','し','「安全」はな形容詞。/ Na-adj + dashi.'],
            [4,'あの店は近い＿＿、品物もいい。','し','だし','「近い」はい形容詞。/ I-adj + shi.'],
            [5,'彼は医者＿＿、経験も豊富だ。','だし','し','「医者」は名詞。名詞+だし / Noun + dashi.'],
            [5,'この料理は珍しい＿＿、美味しい。','し','だし','「珍しい」はい形容詞。/ I-adj + shi.'],
            [5,'今日は日曜日＿＿、天気もいい。','だし','し','「日曜日」は名詞。/ Noun + dashi.'],
            [5,'あの子はまだ若い＿＿、経験も少ない。','し','だし','「若い」はい形容詞。/ I-adj + shi.'],
            [5,'このホテルは豪華＿＿、サービスもいい。','だし','し','「豪華」はな形容詞。/ Na-adj + dashi.'],
            [6,'値段も手頃＿＿、品質もいい。','だし','し','「手頃」はな形容詞。/ Na-adj + dashi.'],
            [6,'通勤時間も短い＿＿、家賃も安い。','し','だし','「短い」はい形容詞。/ I-adj + shi.'],
            [6,'この地域は不便＿＿、物価も高い。','だし','し','「不便」はな形容詞。/ Na-adj + dashi.'],
            [6,'彼の意見は正しい＿＿、分かりやすい。','し','だし','「正しい」はい形容詞。/ I-adj + shi.'],
            [6,'この製品は高品質＿＿、デザインもいい。','だし','し','「高品質」はな形容詞。/ Na-adj + dashi.'],
            [7,'この提案は合理的＿＿、実現可能だ。','だし','し','「合理的」はな形容詞。/ Na-adj + dashi.'],
            [7,'景気は悪い＿＿、先行きも不透明だ。','し','だし','「悪い」はい形容詞。/ I-adj + shi.'],
            [7,'この研究は画期的＿＿、応用範囲も広い。','だし','し','「画期的」はな形容詞。/ Na-adj + dashi.'],
            [7,'人手が足りない＿＿、予算もない。','し','だし','「足りない」はい形容詞的。/ I-adj + shi.'],
            [7,'彼女は誠実＿＿、責任感もある。','だし','し','「誠実」はな形容詞。/ Na-adj + dashi.'],
            [8,'この問題は深刻＿＿、早急な対策が必要だ。','だし','し','「深刻」はな形容詞。/ Na-adj + dashi.'],
            [8,'証拠が少ない＿＿、証人もいない。','し','だし','「少ない」はい形容詞。/ I-adj + shi.'],
            [8,'彼の態度は横柄＿＿、非協力的だ。','だし','し','「横柄」はな形容詞。/ Na-adj + dashi.'],
            [8,'交通の便も悪い＿＿、治安も良くない。','し','だし','「悪い」はい形容詞。/ I-adj + shi.'],
            [8,'この政策は公平＿＿、透明性もある。','だし','し','「公平」はな形容詞。/ Na-adj + dashi.'],
            [9,'この理論は斬新＿＿、実証的でもある。','だし','し','「斬新」はな形容詞。/ Na-adj + dashi.'],
            [9,'彼の主張は鋭い＿＿、論理的でもある。','し','だし','「鋭い」はい形容詞。/ I-adj + shi.'],
            [9,'この事態は異常＿＿、前例がない。','だし','し','「異常」はな形容詞。/ Na-adj + dashi.'],
            [9,'手続きが煩わしい＿＿、時間もかかる。','し','だし','「煩わしい」はい形容詞。/ I-adj + shi.'],
            [9,'彼の行動は軽率＿＿、無責任だ。','だし','し','「軽率」はな形容詞。/ Na-adj + dashi.'],
            [10,'この戦略は緻密＿＿、柔軟性もある。','だし','し','「緻密」はな形容詞。/ Na-adj + dashi.'],
            [10,'状況は厳しい＿＿、楽観できない。','し','だし','「厳しい」はい形容詞。/ I-adj + shi.'],
            [10,'その解釈は妥当＿＿、説得力もある。','だし','し','「妥当」はな形容詞。/ Na-adj + dashi.'],
            [10,'期限も近い＿＿、準備も不十分だ。','し','だし','「近い」はい形容詞。/ I-adj + shi.'],
            [10,'この思想は革新的＿＿、時代を先取りしている。','だし','し','「革新的」はな形容詞。/ Na-adj + dashi.'],
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
