<?php

namespace App\Http\Controllers;

use App\Call;
use App\Mail\CallMail;
use App\Mail\FeedbackMail;
use App\Mail\BriefOnlineMail;
use App\User;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Transport\MailgunTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;

class BotController extends Controller
{
    public function index(Request $request)
    {
        $data = file_get_contents('php://input');
        //$data = $request->all();
        $data = json_decode($data, true);

        /*$insert = DB::insert('INSERT INTO message_bot SET message=?, created_at=?', [
            strip_tags(trim($request->message)), time()
        ]);*/

        ob_start();
        print_r($data);
        $out = ob_get_clean();
        file_put_contents(__DIR__ . '/../../../public/bot/message.txt', $out);

        if (empty($data['message']['chat']['id'])) {
            exit();
        }

        // url and tocken for registration file on site
        // https://api.telegram.org/bot1341219753:AAEZmkRU-J8CEnVVNaz77Kole0R2dqFySJA/setWebhook?url=https://makklays.com/bota
        define('TOKEN', '1341219753:AAEZmkRU-J8CEnVVNaz77Kole0R2dqFySJA');

        // Функция вызова методов API.
        function sendTelegram($method, $response)
        {
            $ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);

            return $res;
        }

        // Прислали фото.
        if (!empty($data['message']['photo'])) {
            $photo = array_pop($data['message']['photo']);
            $res = sendTelegram(
                'getFile',
                array(
                    'file_id' => $photo['file_id']
                )
            );

            $res = json_decode($res, true);
            if ($res['ok']) {
                $src = 'https://api.telegram.org/file/bot' . TOKEN . '/' . $res['result']['file_path'];
                $dest = __DIR__ . '/' . time() . '-' . basename($src);

                if (copy($src, $dest)) {
                    sendTelegram(
                        'sendMessage',
                        array(
                            'chat_id' => $data['message']['chat']['id'],
                            'text' => 'Фото сохранено'
                        )
                    );

                }
            }
            exit();
        }

        // Прислали файл.
        if (!empty($data['message']['document'])) {
            $res = sendTelegram(
                'getFile',
                array(
                    'file_id' => $data['message']['document']['file_id']
                )
            );

            $res = json_decode($res, true);
            if ($res['ok']) {
                $src = 'https://api.telegram.org/file/bot' . TOKEN . '/' . $res['result']['file_path'];
                $dest = __DIR__ . '/' . time() . '-' . $data['message']['document']['file_name'];

                if (copy($src, $dest)) {
                    sendTelegram(
                        'sendMessage',
                        array(
                            'chat_id' => $data['message']['chat']['id'],
                            'text' => 'Файл сохранён'
                        )
                    );
                }
            }
            exit();
        }

        // Ответ на текстовые сообщения.
        if (!empty($data['message']['text'])) {
            $text = $data['message']['text'];

            if (mb_stripos($text, 'привет') !== false || mb_stripos($text, 'Привет') !== false) {
                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => 'Хай!'
                    )
                );
                exit();

            } else if (strpos($text, '/stat') !== false) {

                // число просмотров за день
                $count_views = DB::table('visits')
                    //->where('url_referer', '=', 'http://m.facebook.com/')
                    //->where('url_referer', 'like', '%facebook.com/')
                    ->where(DB::raw("CAST(visits.created_at AS DATE)"), date('Y-m-d'))
                    ->count();

                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => $count_views
                    )
                );
                exit();

            } else if (strpos($text, '/newcall') !== false) {

                // число просмотров за день
                $count_views = DB::table('call')
                    //->where('url_referer', '=', 'http://m.facebook.com/')
                    //->where('url_referer', 'like', '%facebook.com/')
                    ->where(DB::raw("from_unixtime(call.created_at, '%Y-%m-%d')"), date('Y-m-d'))
                    ->count();

                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => $count_views
                    )
                );
                exit();

            } else if (strpos($text, '/neworder') !== false) {

                // число просмотров за день
                $count_views = DB::table('orders')
                    //->where('url_referer', '=', 'http://m.facebook.com/')
                    //->where('url_referer', 'like', '%facebook.com/')
                    ->where(DB::raw("CAST(orders.created_at AS DATE)"), date('Y-m-d'))
                    ->count();

                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => $count_views
                    )
                );
                exit();

            } else if (strpos($text, '/newclient') !== false) {

                // число просмотров за день
                $count_views = DB::table('orders')
                    //->where('url_referer', '=', 'http://m.facebook.com/')
                    //->where('url_referer', 'like', '%facebook.com/')
                    ->where(DB::raw("CAST(orders.created_at AS DATE)"), date('Y-m-d'))
                    ->count();

                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => $count_views
                    )
                );
                exit();

            } else if (strpos($text, '/paid') !== false) {

                // число просмотров за день
                $count_views = DB::table('visits')
                    //->where('url_referer', '=', 'http://m.facebook.com/')
                    //->where('url_referer', 'like', '%facebook.com/')
                    ->where(DB::raw("CAST(visits.created_at AS DATE)"), date('Y-m-d'))
                    ->count();

                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => $count_views
                    )
                );
                exit();

            } else if (strpos($text, '/unpaid') !== false) {

                // число просмотров за день
                $count_views = DB::table('visits')
                    //->where('url_referer', '=', 'http://m.facebook.com/')
                    //->where('url_referer', 'like', '%facebook.com/')
                    ->where(DB::raw("CAST(visits.created_at AS DATE)"), date('Y-m-d'))
                    ->count();

                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => $count_views
                    )
                );
                exit();

            } else if (strpos($text, '/money') !== false) {

                // число просмотров за день
                $count_views = DB::table('visits')
                    //->where('url_referer', '=', 'http://m.facebook.com/')
                    //->where('url_referer', 'like', '%facebook.com/')
                    ->where(DB::raw("CAST(visits.created_at AS DATE)"), date('Y-m-d'))
                    ->count();

                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => $count_views
                    )
                );
                exit();

            } else if (strpos($text, '/aa') !== false) {

                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => "Саша, не грусти! \r\n\r\n Улыбнись :-)))"
                    )
                );
                exit();

            } else if (mb_stripos($text, 'фото') !== false) { // Отправка фото.

                sendTelegram(
                    'sendPhoto',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'photo' => curl_file_create(__DIR__ . '/../../../public/bot/photo.png')
                    )
                );
                exit();

            } else if (mb_stripos($text, 'файл') !== false) { // Отправка файла.

                sendTelegram(
                    'sendDocument',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'document' => curl_file_create(__DIR__ . '/../../../public/bot/example.xls')
                    )
                );
                exit();

            } else {
                sendTelegram(
                    'sendMessage',
                    array(
                        'chat_id' => $data['message']['chat']['id'],
                        'text' => "Меня зовут BotMakklays.\r\nУточните запрос, еще раз"
                    )
                );
            }

        }
    }

    /**
     * TODO - вынести в trait или class-service
     *
     * Делает новый url с указанием языка сайта
     * @param $lang
     * @return string
     */
    function new_url()
    {
        $parts = explode('/', $_SERVER['REQUEST_URI'],5);

        $new_url = (!empty($parts[2]) ? $parts[2].'/' : '').
            (!empty($parts[3]) ? $parts[3].'/' : '').(!empty($parts[4]) ? $parts[4].'/' : '').
            (!empty($parts[5]) ? $parts[5].'/' : '').(!empty($parts[6]) ? $parts[6].'/' : '').
            (!empty($parts[7]) ? $parts[7].'/' : '').(!empty($parts[8]) ? $parts[8].'/' : '');

        return $new_url;
    }

    public function bots(Request $request)
    {
        $new_url = $this->new_url();

        $lang = app()->getLocale();
        $seo = new \stdClass();
        $seo->server_name = $request->server('SERVER_NAME');
        $seo->request_scheme = $request->server('REQUEST_SCHEME');
        $seo->short_url = $new_url;
        $seo->show_urls = 1;
        if ($lang == 'ru') {
            $seo->title = 'Разработка сайта и ведение сайта';
            $seo->description = 'Makklays - Разработка лендинг, разработка корпоративный сайт, делаем интернет-магазин, веб-портал, e-commerce website, сайт-система, веб-сервис и API для мобильных приложений';
            $seo->keywords = 'разработка сайта, разработка, сайт, интернет-магазин, internet-shop, shop, корпоративный сайт, e-commerce website, лендинг, landing, веб-портал, дорого, разработка под ключ';
        } else if ($lang == 'es') {
            $seo->title = 'Desarrollo sitio web y mantenimiento de sitio web';
            $seo->description = 'Makklays - Desarrollo de página de aterrizaje, sitio web corporativo, tienda en línea, portal web, e-commerce website, sistema de sitio web, servicio web y API para aplicaciones móviles';
            $seo->keywords = 'desarrollo de sitios web, desarrollo, sitio web, tienda en línea, tienda de internet, tienda, sitio web corporativo, e-commerce website, página de inicio, aterrizaje, portal web, desarrollo costoso y llave en mano';
        } else if ($lang == 'ua') {
            $seo->title = 'Розробка сайту та ведення сайту';
            $seo->description = 'Makklays - Розробка стрічки, розробка корпоративного сайту, створення інтернет-магазину, веб-порталу, веб-сайту електронної комерції, веб-системи, веб-сервісу та API для мобільних додатків';
            $seo->keywords = 'розробка сайту, розробка, сайт, інтернет-магазин, інтернет-магазин, магазин, корпоративний сайт, веб-сайт електронної комерції, стрічка, посадка, веб-портал, дорого, розробка під ключ';
        } else {
            $seo->title = 'Website development and Website maintenance';
            $seo->description = 'Makklays - Landing page development, corporate website development, online store, web portal, website system, e-commerce website, web service and API for mobile applications';
            $seo->keywords = 'website development, development, website, online store, internet-shop, shop, corporate website, landing page, e-commerce website, landing, web portal, expensive, turnkey development';
        }

        return view('bots.bots-form', [
            'seo' => $seo,
        ]);
    }

    public function bots_post(Request $request)
    {
        $data = file_get_contents('php://input');
        //$data = $request->all();
        $data = json_decode($data, true);

        /*$insert = DB::insert('INSERT INTO message_bot SET message=?, created_at=?', [
            strip_tags(trim($request->message)), time()
        ]);*/

        ob_start();
        print_r($data);
        $out = ob_get_clean();
        file_put_contents(__DIR__ . '/../../../public/bot/message.txt', $out);

        if (empty($data['message']['chat']['id'])) {
            exit();
        }

        // url and tocken for registration file on site
        // https://api.telegram.org/bot1341219753:AAEZmkRU-J8CEnVVNaz77Kole0R2dqFySJA/setWebhook?url=https://makklays.com/bota
        define('TOKEN', '1341219753:AAEZmkRU-J8CEnVVNaz77Kole0R2dqFySJA');

        // Функция вызова методов API.
        function sendTelegram($method, $response)
        {
            $ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);

            return $res;
        }

        // dd($request);

        // send to telegram
        sendTelegram(
            'sendMessage',
            array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => $request->msg, //"Меня зовут BotMakklays.\r\nУточните запрос, еще раз"
            )
        );

        return redirect( route('bots', app()->getLocale()) )
            ->with('flash_message', trans('bots.Send_to_telegram_was_suceessfully!'))
            ->with('flash_type', 'success');
    }
}
