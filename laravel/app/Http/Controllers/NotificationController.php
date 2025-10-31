<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Services\WhatsAppService;

class NotificationController extends Controller
{
    protected $whatsApp;

    public function __construct(WhatsAppService $whatsApp)
    {
        $this->whatsApp = $whatsApp;
    }
    public function index()
    {
        return view('backend.notification.index');
    }
    public function show(Request $request)
    {
        $notification = Auth()->user()->notifications()->where('id', $request->id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['actionURL']);
        }
    }
    public function delete($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $status = $notification->delete();
            if ($status) {
                session()->flash('success', 'Notification successfully deleted');
                return back();
            } else {
                session()->flash('error', 'Error please try again');
                return back();
            }
        } else {
            session()->flash('error', 'Notification not found');
            return back();
        }
    }
    /**
     * Whatsapp resent
     */
    public function whatsappResent($id)
    {
        // Fetch the existing notification
        $notification = Notification::find($id);

        if (! $notification) {
            return response()->json([
                'status' => false,
                'message' => 'Notification data not found'
            ], 404);
        }

        // Mark us resent
        $notification->resend = 'yes';
        $notification->save();

        // Resend the whatsapp message
        $data = ['id' => $id];
        $whatsappSentRes = $this->whatsApp->send($data, true);

        // determine if it was success
        $isSuccess = $whatsappSentRes['status'] ??  false;

        return response()->json([
            'message' => $isSuccess ? 'Whatsapp message resend Successfully' : 'Whatsapp message resent failed',
            'result' => $whatsappSentRes,
        ]);
    }
}
