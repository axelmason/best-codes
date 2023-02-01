<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function get() {
        $notifications = Notification::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return response()->json($notifications);
    }

    public function put(Request $r, $id) {
        $result = Notification::find($id)->update($r->all());

        return response()->json($result);
    }

    public function create(Request $request) {
        $code = $request->input('code');
        $user_id = $request->input('user_id');
        $curCode = Code::where(['user_id' => $user_id, 'code' => $code['code']])->first();

        switch ($request->input('reason')) {
            case 'reject':
                $text = "Код ".$code['code']." был отклонён модератором. \nПричина: ".$request->input('text');
                break;
            case 'accept':
                $codeHref = "<a class='text-url' href='/code/".$curCode->id."'>Ссылка на код</a>";
                $text = "Код ".$code['code']." был отредактирован модератором и теперь в публичном доступе.\n".$codeHref;
                break;
            case 'status':
                $text = "Код ".$code['code']." взят в работу модератором.";
                break;
            case 'code_sent':

                $text = "Код ".$code['code']." отправлен модераторам на проверку.\n Информацию ожидайте в уведомлениях.";
        }
        if(isset($text)) {
            $result = Notification::create([
                'user_id' => $request->input('user_id') ?? auth()->user()->id,
                'text' => nl2br($text)
            ]);
        }

        return response()->json($result);
    }
}
