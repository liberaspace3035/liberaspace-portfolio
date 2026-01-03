<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\ContactConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            // 管理者宛てのお問い合わせメールを送信
            $adminEmail = env('MAIL_FROM_ADDRESS', 'info@liberaspace.com');
            Mail::to($adminEmail)->send(new ContactMail($validated));

            // 送信者宛ての確認メールを送信
            Mail::to($validated['email'])->send(new ContactConfirmationMail($validated));

            Log::info('Contact form submitted', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'お問い合わせありがとうございます。メールを送信しました。',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Contact form error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'メールの送信に失敗しました。しばらく時間をおいて再度お試しください。',
            ], 500);
        }
    }
}

