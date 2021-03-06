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

class ArticlesController extends Controller
{
    public function list()
    {
        // Only loggined
        if (!Auth::check()) return redirect(app()->getLocale() . '/admin/login');

        // list of companies
        //$companies = DB::select('SELECT * FROM companies ');
        $articles = DB::table('articles')->paginate(20);

        /*if (isset($companies) && !empty($companies)) {
            foreach($companies as &$company) {
                $employees = DB::selectOne('SELECT count(id) as count FROM employees WHERE company_id=?', [$company->id]);
                $company->count_employees = $employees->count;
            }
        }*/

        return view('adminka.articles.list', [
            'articles' => $articles,
        ]);
    }

    public function add(Request $request)
    {
        // Only loggined
        if (!Auth::check()) return redirect(app()->getLocale() . '/admin/login');

        // add a new company
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                //Obtenemos los mensajes de error de la validation
                $messages = $validator->messages();
                return redirect(app()->getLocale() . '/admin/adm-article-add')
                    ->withErrors($validator)
                    ->withInput();
            }

            //dd($request->all());

            // if exist article - ?????????????????? ???????????????????? ???? ???????????? ?? ?????????? ??????????????????
            $slug = $this->transcription($request->title);

            $select = DB::selectOne('SELECT * FROM articles WHERE slag=?', [$slug]);
            //dd($select);

            if (!empty($select) && !empty($select->id)) {
                return redirect(app()->getLocale() . '/admin/adm-article-add')->with([
                        'flash_message' => '????????????! <br/>???????????? ?? ?????????? ???????????????? ?????? ????????????????????!',
                        'flash_type' => 'danger'
                    ])->withInput();
            }

            $file = (isset($request->file()['photo']) && !empty($request->file()['photo']) ? $request->file()['photo'] : '');
            $filename = '';
            if (isset($file) && !empty($file)) {

                /*echo '<pre>';
                print_r($file);
                echo '</pre>';*/

                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('articles/imgs'), $filename);
            }

            $insert = DB::insert('INSERT INTO articles SET user_id=?, `title`=?, slag=?,
                            short_text=?, full_text=?,
                            photo=?, lang=?, created_at=?, updated_at=?', [
                auth()->user()->id,
                $request->title,
                $this->transcription($request->title),
                (isset($request->short_text) && !empty($request->short_text) ? $request->short_text : null),
                (isset($request->full_text) && !empty($request->full_text) ? $request->full_text : null),
                (isset($filename) && !empty($filename) ? $filename : null),
                (isset($request->lang) && !empty($request->lang) ? $request->lang : 'ru'),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s'),
            ]);

            //dd($insert);
            //if ($insert) {
                //$article = DB::selectOne('SELECT * FROM articles WHERE id=?', [$insert['id']]);

                // send email
                // ???????????? ???????????????????????????? ????????????????
                /*Mail::send('emails.newcompany', array('company' => $company, 'pathToFile' => asset('storage/'.$company['logo'].'')), function($message)
                {
                    $message->to('phpdevops@gmail.com', '???????? ????????')->subject('Add a new company on site!');
                });*/
            //}
            return redirect(app()->getLocale().'/admin/adm-articles')->with([
                'flash_message' => '???????? ????????????, "'.$request->title.'" ?????????????? ??????????????????!',
                'flash_type' => 'success'
            ]);
        }

        return view('adminka.articles.add', [
            //'articles' => $articles,
        ]);
    }

    public function transcription($text)
    {
        $converter = array(
            '??' => 'a',   '??' => 'b',   '??' => 'v',
            '??' => 'g',   '??' => 'd',   '??' => 'e',
            '??' => 'e',   '??' => 'zh',  '??' => 'z',
            '??' => 'i',   '??' => 'y',   '??' => 'k',
            '??' => 'l',   '??' => 'm',   '??' => 'n',
            '??' => 'o',   '??' => 'p',   '??' => 'r',
            '??' => 's',   '??' => 't',   '??' => 'u',
            '??' => 'f',   '??' => 'h',   '??' => 'c',
            '??' => 'ch',  '??' => 'sh',  '??' => 'sch',
            '??' => '\'',  '??' => 'y',   '??' => '\'',
            '??' => 'e',   '??' => 'yu',  '??' => 'ya',

            '??' => 'A',   '??' => 'B',   '??' => 'V',
            '??' => 'G',   '??' => 'D',   '??' => 'E',
            '??' => 'E',   '??' => 'Zh',  '??' => 'Z',
            '??' => 'I',   '??' => 'Y',   '??' => 'K',
            '??' => 'L',   '??' => 'M',   '??' => 'N',
            '??' => 'O',   '??' => 'P',   '??' => 'R',
            '??' => 'S',   '??' => 'T',   '??' => 'U',
            '??' => 'F',   '??' => 'H',   '??' => 'C',
            '??' => 'Ch',  '??' => 'Sh',  '??' => 'Sch',
            '??' => '\'',  '??' => 'Y',   '??' => '\'',
            '??' => 'E',   '??' => 'Yu',  '??' => 'Ya',
            '_' => '-',   ' ' => '-',   ':' => '', ';' => '',
            '"' => '',    "'" => '',  '?' => '', '!' => '',
        );
        return strtolower(strtr($text, $converter));
    }

    public function edit(Request $request, $lang, $id)
    {
        // Only loggined
        if (!Auth::check()) return redirect(app()->getLocale() . '/login');

        if (!isset($id) || !empty($id)) redirect('/admin/adm-articles');

        // simple upload image
        $file = (isset($request->file()['photo']) && !empty($request->file()['photo']) ? $request->file()['photo'] : '');
        $filename = '';
        if (isset($file) && !empty($file)) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('articles/imgs'), $filename);
        }

        //dd($request);

        // update data of company
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                //'slag' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                //Obtenemos los mensajes de error de la validation
                $messages = $validator->messages();
                return redirect(app()->getLocale() . '/admin/adm-article-edit/' . $id)
                    ->with([
                        'flash_message' => '????????????! <br/>???????? ????????????, "'.$request->title.'" ???? ???????? ??????????????????!',
                        'flash_type' => 'danger'
                    ])
                    ->withErrors($validator)
                    ->withInput();
            }

            if (isset($filename) && !empty($filename)) {
                DB::update('UPDATE `articles` SET user_id=?, `title`=?, `slag`=?, short_text=?, full_text=?, photo=?, lang=?, views=?, is_visible=?, updated_at=? WHERE id=?', [
                    auth()->user()->id,
                    $request->title,
                    (empty($request->slag) ? $this->transcription($request->title) : $request->slag),
                    (isset($request->short_text) && !empty($request->short_text) ? $request->short_text : null),
                    (isset($request->full_text) && !empty($request->full_text) ? $request->full_text : null),
                    (isset($filename) && !empty($filename) ? $filename : null),
                    (isset($request->lang) && !empty($request->lang) ? $request->lang : 'ru'),
                    (isset($request->views) && !empty($request->views) ? $request->views : 1),
                    (isset($request->is_visible) && !empty($request->is_visible) ? 1 : 0),
                    date('Y-m-d H:i:s'),
                    $id
                ]);
            } else {
                DB::update('UPDATE `articles` SET user_id=?, `title`=?, `slag`=?, short_text=?, full_text=?, lang=?, views=?, is_visible=?, updated_at=? WHERE id=?', [
                    auth()->user()->id,
                    $request->title,
                    (empty($request->slag) ? $this->transcription($request->title) : $request->slag),
                    (isset($request->short_text) && !empty($request->short_text) ? $request->short_text : null),
                    (isset($request->full_text) && !empty($request->full_text) ? $request->full_text : null),
                    (isset($request->lang) && !empty($request->lang) ? $request->lang : 'ru'),
                    (isset($request->views) && !empty($request->views) ? $request->views : 1),
                    (isset($request->is_visible) && !empty($request->is_visible) ? 1 : 0),
                    date('Y-m-d H:i:s'),
                    $id
                ]);
            }

            return redirect(app()->getLocale().'/admin/adm-articles')->with([
                'flash_message' => '???????? ????????????, "'.$request->title.'" ???????? ?????????????? ??????????????????????????????!',
                'flash_type' => 'success'
            ]);
        }

        // get article
        $article = DB::selectOne('SELECT * FROM articles WHERE id=?', [$id]);

        return view('adminka.articles.edit', [
            'article' => $article
        ]);
    }

    public function delete(Request $request, $lang, $id)
    {
        // Only loggined
        if (!Auth::check()) return redirect(app()->getLocale() . '/admin/login');

        if (!isset($id) || !empty($id)) redirect('/admin/adm-articles');

        // get article
        $article = DB::selectOne('SELECT * FROM articles WHERE id=?', [$id]);

        // delete article
        $delete = DB::delete('DELETE FROM articles WHERE id=?', [
            $request->article_id,
        ]);

        return redirect(app()->getLocale().'/admin/adm-articles')->with([
            'flash_message' => '???????? ????????????, "'.$article->title.'" ???????? ?????????????? ??????????????!',
            'flash_type' => 'success'
        ]);
    }
}
