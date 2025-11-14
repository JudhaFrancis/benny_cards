<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\SmsTemplate;
use App\Models\Notification;

class WhatsAppService
{

    public function __construct() {}

    /**
     * Send a WhatsApp message or push it into a queue.
     */
    public function send(array $data, bool $isSend = true, $templateId = null, bool $skipQueue = false): array
    {
        // case 1: Fresh send (no ID)
        if (empty($data['id'])) {
            $template = SmsTemplate::find($templateId);
            if (! $template) {
                return ['status' => false, 'message' => 'Template not found'];
            }

            $message = $this->replaceParameters($data, $template->template_content ?? '');
            if (! $isSend) {
                return ['status' => false, 'message' => 'WhatsApp sending skipped'];
            }

            // Normalize mobile number
            $mobileNo = preg_replace('/\D/', '', $data['mobile_no']);
            if (!str_starts_with($mobileNo, '91')) {
                $mobileNo = '91' . $mobileNo;
            }

            // Create notification record
            $notification = new Notification();
            $notification->fill([
                'message'             => $message,
                'message_type'        => 'whatsapp',
                'status'              => 'not_sent',
                'created_by'          => auth()->check() ? auth()->user()->id : null,
                'recipient_mobile_no' => $mobileNo,
            ]);
            $notification->save();
        }
        // case 2: Resend (existing ID) 
        else {
            $notification = Notification::find($data['id']);
            if (! $notification) {
                return ['status' => false, 'message' => 'Notification Data not found'];
            }
            
            $mobileNo = $notification->recipient_mobile_no;
            $message  = $notification->message;
        }

        // Send whatsapp message
        $result = $this->sendWhatsAppMessage($mobileNo, $message);
        $decoded = json_decode($result['response'] ?? '', true);

        $senderNumber = $decoded['data']['from'] ?? '';

        if (isset($decoded['data']['status_code']) && (int)$decoded['data']['status_code'] === 200) {
            $notification->status = 'sent';
        } else {
            $notification->status = 'failed';
        }

        // update with sender number && API response
        $notification->sender_mobile_no = $senderNumber;
        $notification->response = $result['response'] ?? null;
        $notification->save();

        return [
            'status' => $notification->status === 'sent',
            'message' => $notification->status === 'sent' ? 'Whatsapp message sent successfully' : 'Whatsapp Message failed to sent',
            'response' => $result,
        ];
    }

    /**
     * Send message directly to WhatsApp API
     */
    public function sendWhatsAppMessage($mobileNo, $message, $type = 'TEXT', $file = '', $templateId = ''): array
    {
        if (config('app.env') !== 'production') {
            $mobileNo = config('services.whatsapp.test_number', '919790124351');
        }

        $payload = [
            'appkey'  => config('services.whatsapp.appkey'),
            'authkey' => config('services.whatsapp.authkey'),
            'to'      => $mobileNo,
            'message' => $message,
        ];

        $url = config('services.whatsapp.api_url');

        try {
            $response = Http::withHeaders([
                'Accept' => '/',
                'Content-Type' => 'application/json',
                'appkey' => config('services.whatsapp.appkey'),
            ])->post($url, $payload);

            $body = trim($response->body());
            $success = str_contains(strtolower($body), 'true');

            return [
                'status' => $success,
                'response' => $body,
            ];
        } catch (\Throwable $e) {
            Log::error('WhatsApp send error: ' . $e->getMessage());

            return [
                'status' => false,
                'response' => $e->getMessage(),
            ];
        }
    }

    /**
     * Replace placeholders like {name}, {month}, etc.
     */
    private function replaceParameters(array $data, string $template): string
    {
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }

        return $template;
    }
}
