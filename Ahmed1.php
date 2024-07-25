<?php

ob_start();


define('API_KEY', "7145492041:AAHWXUvm34o5nldXXf35OVDzKZpD7to0wm4");
echo file_get_contents("https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);
define('API_URL', 'https://api.telegram.org/bot' . API_KEY . '/');
//UPDATE

function bot($method, $params = [])
{
    $url = API_URL . $method;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

bot("setWebhook", ["url" => $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME'], "drop_pending_updates" => true]);

function Search($chat_id, $message_id, $text)
{

    $cookies = [
        '_ga' => 'GA1.2.1792644595.1709681609',
        '_gid' => 'GA1.2.204135762.1709681609',
        '_gat' => '1',
        '_ga_N166PECS9R' => 'GS1.2.1709681609.1.1.1709681676.0.0.0',
    ];

    $headers = [
        'authority: hdith.com',
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'accept-language: ar-AE,ar-EG;q=0.9,ar;q=0.8,en-GB;q=0.7,en;q=0.6,en-US;q=0.5',
        'referer: https://hdith.com/',
        'sec-ch-ua: "Not_A Brand";v="8", "Chromium";v="120"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "Android"',
        'sec-fetch-dest: document',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: same-origin',
        'sec-fetch-user: ?1',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    ];

    $url = "https://hdith.com/?s=" . $text;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $cookieString = '';
    foreach ($cookies as $key => $value) {
        $cookieString .= "$key=$value; ";
    }
    curl_setopt($ch, CURLOPT_COOKIE, $cookieString);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

// استخدام DOMDocument و XPath لتحليل المحتوى
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();
    $xpath = new DOMXPath($dom);

// استخراج النصوص
    $items = $xpath->query("//div[contains(@class, 'hbox faq-item active degree')]");

    foreach ($items as $item) {
        $hadith_text = trim($item->textContent);
        $lines = preg_split('/(الراوي:|المحدث:|المصدر:|الجزء أو الصفحة:|حكم المحدث:)/', "<blockquote>{" . $hadith_text . "}</blockquote>\n", -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($lines as $line) {

            $ha = $ha . trim($line) . "  ";

        }
        $he = $he . $ha . "\n\n";
        if ($ha) {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => $he,
                'parse_mode' => 'html',

            ]);

        }
    }
}

//PARAMETER
mkdir("img");
mkdir("SEARCH");
mkdir("KOTOB_ID/ATHKAR");
mkdir("KOTOB_ID/BUKHARI");
mkdir("KOTOB_ID/MUSLIM");
mkdir('KOTOB_ID/AHMED');
mkdir("KOTOB_ID/ABUDAWUD");
mkdir("KOTOB_ID/NASAI");
mkdir("KOTOB_ID/TIRMIDHI");
mkdir("KOTOB_ID/DARIMI");
mkdir("KOTOB_ID/MALIK");
mkdir("KOTOB_ID/IBNMAGAH");
mkdir("KOTOB_ID/ALADAB");
$update = json_decode(file_get_contents('php://input'));

$message = $update->message;
$chat_id = $message->chat->id ?? $update->callback_query->message->chat->id;
$chid = $update->channel_post->chat->id;
$from_id = $message->from->id ?? $update->callback_query->from->id;

$text = $message->text;
$chtext = $update->channel_post->text;

$message_id = $message->message_id ?? $update->callback_query->message->message_id;
$messageid = $update->channel_post->message_id;
$msg = $update->callback_query->message->message_id;
$name = $message->from->first_name ?? $update->callback_query->from->first_name;

$username = $message->from->username ?? $update->callback_query->from->username;

$data = $update->callback_query->data;

$type = $message->chat->type;
$photo = $message->photo;
$photoId = $message->photo[0]->file_id;

$video = $message->video;
$videoId = $message->video->file_id;
$audio = $message->audio;
$audioId = $message->audio->file_id;
$file = $message->document;
$fileId = $message->document->file_id;

$sticker = $message->sticker;
$stickerId = $message->sticker->file_id;

$voice = $message->voice;
$voiceId = $message->voice->file_id;

$caption = $update->message->caption;

$date = $message->date;
/////////FILES///////////

$admin = 5714135641;
function sendAction($chat_id, $action)
{
    bot('sendChataction', [
        'chat_id' => $chat_id,
        'action' => $action,
    ]);
}

$users = explode("\n", file_get_contents('users.txt'));

$SHARE = explode("\n", file_get_contents("Share/$from_id.txt"));
$inshare = in_array($from_id, $SHARE);

$count = count(explode("\n", file_get_contents("users.txt"))) - 1;

date_default_timezone_set("Africa/Cairo");
$time = date("h:i A");
echo "\n" . $time . "\n";




$json_d = json_decode(file_get_contents("KOTOB/DOAA.json"), 1);
$c = count($json_d);
echo $c;
$doaa = $json_d[rand(0, 23)]["A"];

$txt = "<blockquote>$doaa</blockquote>
               •┈┈• ❀ 🍃🌸 🍃 ❀ •┈┈•
        <blockquote></blockquote>
🕊️🌼القناة : @EhiaAlSahwa

     ━━━━━━━━━━━━━━━━━━━━━━
                 عدد أعضاء البوت : $count 🌱
     ━━━━━━━━━━━━━━━━━━━━━━

                           $time

";
$sending = "تم الإرسال سيتم مراجعة منشورك انتظر حتى يتم القبول او الرفض ";

$done = "تم قبول منشورك وتم نشره. ";
$no = "عفواً $name مشاركتك فيها بعض المخالفات فلا يمكنني أن أنشرها على القناة. ";
$newmem = "انضم [$name](tg://user?id=$from_id) إلى البوت.
المعرف : $username
الأي دي : $from_id
";
$Shr = "حسناً $name أرسل مشاركتك وسيتم نشرها في القناة بإذن الله.
يمكنك إرسال نص، صورة، فيديو، أو مقاطع صوتية. ";

$shared = "مشاركة من : ";

//~~~~~~~~TEXT~~~~~~~~~~~~~~~

function sendText($chatid, $messageid, $ttxt)
{

    bot('sendmessage', [
        'chat_id' => $chatid,
        'message_id' => $messageid,
        'text' => $ttxt,
        'parse_mode' => 'MarkDown',
    ]);
}

function sendHad($chat_id, $message_id, $text, $tx, $to, $sendmsg, $out)
{

    bot($sendmsg, [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $text,
        'parse_mode' => 'html',
        'reply_to_message_id' => $message_id,
        'disable_web_page_preview' => true,
        'reply_markup' => json_encode(['inline_keyboard' => [
            [['text' => "$tx", 'callback_data' => "$to"], ['text' => "رجوع",
                'callback_data' => "$out",
            ]]]]),
        'alert' => true,
    ]);
}

//////////START///////

function sendTextFM($chat_id, $message_id, $text, $sendmg, $tafel, $act)
{
    bot($sendmg, [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $text,
        'parse_mode' => 'html',
        'reply_to_message_id' => $message_id,
        'disable_web_page_preview' => true,
        'reply_markup' => json_encode(['inline_keyboard' => [
            [['text' => "إذاعة القرآن الكريم 📻", 'web_app' => ['url' => "https://ehiaalsahwa.000webhostapp.com/wp-admin/js/EhiaAlSahwa/quran.html"]]],
            [['text' => "كُتُبُ الْحَدِيث 📖",
                'callback_data' => 'books']],
            [['text' => "بحث عن صحة حديث🔎", 'callback_data' => 'search']],
            [['text' =>$tafel, 'callback_data' => $act]],
            [['text' => "⌔ شارك البوت 🌹", 'switch_inline_query' => "
            في بوت إحياء الصحوة 🌱:
- يمكنك البحث عن صحة اي حديث.
- 10 كُتُب حديث « المُسنَد، المُوطأ، الصحيحين، وغيرهم..»
      ", ]],
        ],
        ]),
    ]);
}




///////ATHKAR////
$tafel = "تفعيل أذكار الصباح والمساء 🍃";

$taatel = "تعطيل أذكار الصباح والمساء 🔕";

$STTH =  explode("\n",file_get_contents("athkar.txt"));
if($data == "active" and !in_array($from_id, $STTH)){
   file_put_contents('athkar.txt', "\n" . $from_id, FILE_APPEND);

   
    sendTextFM($chat_id, $msg, $txt, "EditMessageText",$taatel, "inactive");

 }

if($data == "inactive"){
    $contentFile = file_get_contents("athkar.txt");
    $replace = str_replace($from_id,"", $contentFile);
    $openFile = fopen("athkar.txt", "w");
    fwrite($openFile, $replace);
    fclose($openFile);
    sendTextFM($chat_id, $msg, $txt, "EditMessageText",$tafel, "active");

}

///////ATHKAR////








function athkar($sendmsg,$chat_id, $message_id, $n){
    $json_ath = json_decode(file_get_contents("KOTOB/athkar.json"), 1);
    $athkar = $json_ath["أذكار المساء"][$n]["content"]. "\n\n".$json_ath["أذكار المساء"][$n]["description"];
    
    $count ="تُقال ".$json_ath["أذكار المساء"][$n]["count"]. " مرة 🍃";
   bot("$sendmsg",[

    'chat_id'=>$chat_id, 

    'message_id'=>$message_id, 
    'text'=>"<blockquote>أذكار المساء</blockquote>
    <blockquote>$athkar</blockquote>
    <blockquote>$count</blockquote>
    ", 
    "parse_mode"=>"html", 
    'reply_markup' => json_encode(['inline_keyboard' => [

            [['text' => "التالي", 'callback_data' => "goo"], ['text' => "رجوع ",

                'callback_data' => "back",
            ]]]]),
    ]);
}

////////*****ATHKAR******/

$Athk =  explode("\n",file_get_contents("athkar.txt"));
$countAthk = count($Athk);
if(in_array($from_id, $STTH)){
if($text || $data || $video || $photo || $audio || $file || $sticker)

file_put_contents("hhh.txt","\n".$text.$data);

else{
    for ($i = 0; $i < $countAthk ; $i++)
    athkar("sendmessage",$Athk[$i], $message_id, 0);
}
} 
$next = explode("\n", file_get_contents("KOTOB_ID/ATHKAR/$from_id.txt"));

$countThek = count($next);

if($data == "goo" and in_array($from_id, $STTH)){
    file_put_contents("KOTOB_ID/ATHKAR/$from_id.txt", "\n".$from_id, FILE_APPEND);
    for ($i = 0; $i < $countThek; $i++)
    $H = $i+1;
    if($countThek > 23){

        bot("EditMessageText",[
            "chat_id"=>$chat_id,
            "message_id"=>$message_id, 
            "text"=>"<blockquote>"."تقبل الله منك 🌿". "</blockquote>",
            "parse_mode"=>"html", 
                'reply_markup' => json_encode(['inline_keyboard' => [[['text' => "القائمة الرئيسية 🏡", 'callback_data' => "back"]]]]) ,
            ]);
            unlink("KOTOB_ID/ATHKAR/$from_id.txt");
    }
    else 
    athkar("EditMessageText",$chat_id, $message_id, $H);

    
}


//~~~~~~START~~~~~~~~~~~
//~~~~~~START~~~~~~~~~~~
//~~~~~~START~~~~~~~~~~~

if ($text == '/start' && !in_array($from_id, $users) && $from_id != $admin) {

    sendAction($chat_id, 'Typing');

    file_put_contents('users.txt', "\n" . $from_id, FILE_APPEND);

    if(in_array($from_id,$STTH))
    sendTextFM($chat_id, $message_id, $txt, "sendmessage",$tafel, "active");

    sendText($admin, $message_id, $newmem);
}



if ($text == '/start' && in_array($from_id, $users)) {

    sendAction($chat_id, 'Typing');
    
    if(in_array($from_id,$STTH))
    sendTextFM($chat_id, $message_id, $txt, "sendmessage",$taatel, "inactive");
    elseif(!in_array($from_id,$STTH))
    sendTextFM($chat_id, $message_id, $txt, "sendmessage", $tafel, "active");
    
    unlink("SEARCH/$from_id.txt");
    unlink("KOTOB_ID/ATHKAR/$from_id.txt");
    unlink("KOTOB_ID/AHMED/$from_id.txt");
    unlink("KOTOB_ID/BUKHARI/$from_id.txt");
    unlink("KOTOB_ID/MUSLIM/$from_id.txt");
    unlink("KOTOB_ID/ABUDAWUD/$from_id.txt");
    unlink("KOTOB_ID/NASAI/$from_id.txt");
    unlink("KOTOB_ID/TIRMIDHI/$from_id.txt");
    unlink("KOTOB_ID/DARIMI/$from_id.txt");
    unlink("KOTOB_ID/MALIK/$from_id.txt");
    unlink("KOTOB_ID/IBNMAGAH/$from_id.txt");
    unlink("KOTOB_ID/ALADAB/$from_id.txt");
}

//Admin START - - - - -
//Admin START - - - - -
//Admin START - - - - -

if ($text == '/start' && $from_id == $admin) {

    sendAction($chat_id, 'Typing');

    if(in_array($from_id,$STTH))

    sendTextFM($chat_id, $message_id, $txt, "sendmessage",$taatel, "inactive");

    elseif(!in_array($from_id,$STTH))
    sendTextFM($chat_id, $message_id, $txt, "sendmessage", $tafel, "active");
}

if ($text == '/cast' && $from_id == $admin) {

    bot('sendPhoto', [

        'chat_id'=>'-1001823296160', 
        'message_id'=>$message_id, 
        'photo'=>"https://ehiaalsahwa.000webhostapp.com/wp-admin/js/Ahmed/Photo/Ayah.jpg",
        'caption'=>"<blockquote>{  كِتابٌ أُنزِلَ إِلَيكَ فَلا يَكُن في صَدرِكَ حَرَجٌ مِنهُ لِتُنذِرَ بِهِ وَذِكرى لِلمُؤمِنينَ }</blockquote>", 
        'parse_mode' => 'html',
        'reply_markup' => json_encode(['inline_keyboard' => [
            [['text' => "إذاعة القرآن الكريم 📻",'url' => "https://t.me/EhiaAlSahwa_bot/EhiaAlSahwa"
           ]],
            
            [['text' =>"بوت إحياء الصحوة ", 'url' => "https://t.me/EhiaAlSahwa_bot"]]]]) 
        ]);
} 

/*
if($data =="save"){
    if(file_exists("SAVER/$from_id.txt")){
        $save = file_get_contents("SAVER/$from_id.txt");
        $archive = json_decode($save, true );
        $archive[$key] = 
    }
}


/*
if ($text and $from_id == $admin ){
    
    if (file_exists('messages.json')) {

        $data = file_get_contents('messages.json');
        $messages = json_decode($data, true);


        $messages[] = $text;


        $jsonData = json_encode($messages);
        file_put_contents('messages.json', $jsonData);
    } else {

        $messages = array($text);
        $jsonData = json_encode($messages);
        file_put_contents('messages.json', $jsonData);
    }
sendText($admin, $message_id, $text."\n".$newmem);

}

$ddd = json_decode(file_get_contents("messages.json"), true);
sprintf ($ddd[1]) ;
if ($text == "Message"){
for($i =0; $i <= $conn ;$i++)
sendText($admin, $message_id, $ddd[$i]);

}

/*
if ($text){
sendText($admin, $message_id, $text."\n".$newmem);
}
*/
/*
$ex_members = explode("\n", file_get_contents("users.txt"));

if ($video && $from_id == $admin) {
    for ($i = 0; $i < count($ex_members); $i++) {
        bot('sendvideo', [
            'chat_id' => $ex_members[$i],
            'video' => $videoId,
            'caption' => "<blockquote>". $caption. "</blockquote>", 
            'parse_mode'=>'html'
        ]);
    }
}

if ($text && $from_id == $admin) {

    for ($i = 0; $i < count($ex_members); $i++) {

        bot('sendmessage', [
            'chat_id' => $ex_members[$i],
            'message_id' => $message_id,
            'text' => "<blockquote>". $text. "</blockquote>", 
            'parse_mode'=>'html'
        ]);
    }
}


if($text == "/channel"){
    file_put_contents('sent.txt',"\n".$admin);
    sendText($admin, $message_id, "TAMAM Send your message");
}
$sentid = explode("\n", file_get_contents('sent.txt'));
if ($text && $sentid[1]==$admin && $from_id == $admin) {
    bot('sendmessage', [
       'chat_id' =>-1001823296160,
       'message_id' => $messageid,
       'text' => $text,
       'parse_mode' => 'html',
    ]);
    unlink("sent.txt");
}

*/

//- - - SEARCH - - - -
//- - - SEARCH - - - -
//- - - SEARCH - - - -

if ($data == "search") {
    file_put_contents("SEARCH/$from_id.txt", "\n$from_id");
    sendHad($from_id, $message_id,
        "أهلاً $name يمكنك الآن البحث عن صحة أي حديث بإذن الله.
   اكتب الحديث أو أي كلمة داخل الحديث أو جزء منه (اكتب بدون تشكيل للحروف) .

  (مصدر المعلومات موقع : https://hdith.com)
       ",
        "كُتب الحديث",
        "books",
        "EditMessageText", "back");
}
$search = explode("\n", file_get_contents("SEARCH/$from_id.txt"));

if ($text && in_array($from_id, $search)) {
    Search($chat_id, $message_id, $text);
}

//- - - HADITH - - - -
//- - - HADITH - - - -
//- - - HADITH - - - -

if ($data == "books") {
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "حسناً $name، اختر الكتاب الذي تريده. 🌿
        <blockquote><a href ='https://t.me/EhiaAlSahwa' >إحياءُ الصَحوة </a></blockquote>
        ",
        'parse_mode' => 'html',
        'reply_to_message_id' => $message_id,
        'disable_web_page_preview' => true,
        'reply_markup' => json_encode(['inline_keyboard' => [
            [['text' => "مُوطأ الإمام مالك", 'callback_data' => 'MALIK'],
                ['text' => "مُسند الإمام أحمد", 'callback_data' => 'AHMED']],

            [['text' => "صحيح البخاري", 'callback_data' => 'BUKHARI'],

                ['text' => "صحيح مسلم", 'callback_data' => 'MUSLIM']],
            [['text' => "سُنن أبي داوود ", 'callback_data' => 'ABUDAWUD'], ['text' => "سُنن النسائي", 'callback_data' => 'NASAI']],
            [['text' => "سُنن الترمذي", 'callback_data' => 'TIRMIDHI'], ['text' => "سُنن الدارِمي", 'callback_data' => 'DARIMI']],
            [['text' => "سُنن ابن ماجه", 'callback_data' => 'IBNMAGAH'], ['text' => "الأدب المُفرَدْ للبخاري", 'callback_data' => 'ALADAB']],

            [['text' => "رجوع", 'callback_data' => 'back']],
        ]])]);
}
//- - - HADITH - - - -
//- - - HADITH - - - -
//- - - HADITH - - - -

function sendHadith($chat_id, $message_id, $bookName, $bookId, $name)
{

    $go = explode("\n", file_get_contents("KOTOB_ID/$bookId/$chat_id.txt"));
    $count = count($go);

    $bookName = json_decode(file_get_contents("KOTOB/$bookName.json"), true);
    file_put_contents("KOTOB_ID/$bookId/$chat_id.txt", "\n$chat_id", FILE_APPEND);

    for ($i = 0; $i < $count; $i++) {
        $H = $i;
    }
    $cHad = $H + 1;
    $quoted_hadith ="<blockquote>اسم الكتاب : $name </blockquote>\n"."<blockquote>" . $bookName["chapters"][$bookName["hadiths"][$H]["chapterId"] - 1]["arabic"] . "\n</blockquote>" . "<blockquote>حديث:-$cHad</blockquote>\n" . "<blockquote>" . $bookName["hadiths"][$H]["arabic"] . "</blockquote>";

    sendHad($chat_id, $message_id, "$quoted_hadith\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t•┈┈• ❀ 🍃🌸 🍃 ❀ •┈┈•
    ", "التالي", "$bookId", "EditMessageText", "books");

}



//BACK-------

if ($data == 'back') {
    if(in_array($from_id,$STTH))
    sendTextFM($chat_id, $message_id, $txt, "EditMessageText",$taatel, "inactive");

    
    elseif(!in_array($from_id,$STTH))
    sendTextFM($chat_id, $message_id, $txt, "EditMessageText", $tafel, "active");
}

$ALI = ["🕊️", "👍"];
$T = $ALI[array_rand($ALI)];
bot('setmessagereaction', [
    'chat_id' => $from_id,
    'message_id' => $message_id,
    'reaction' => json_encode(array(['type' => "emoji", "emoji" => $T])),
]);
