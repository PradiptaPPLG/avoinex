<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    /**
     * Send message to AI and get response via Groq LLaMA 3
     * 
     * @param string $message
     * @return string
     */
    public function sendMessage($message)
    {
        $message = strtolower(trim($message));

        // 1. Initial Greeting Guard
        if (in_array($message, ['hello', 'halo', 'hi', 'p', 'ping'])) {
            if (!session()->has('greeting_sent')) {
                session()->put('greeting_sent', true);
                return "Halo! Saya Vanessa, asisten virtual Avoinex Airlines. Ada yang bisa saya bantu untuk penerbangan atau perjalanan Anda hari ini?";
            }
        }

        // 2. Setup Groq REST API Endpoint
        $apiKey = env('GROQ_API_KEY');
        
        if (!$apiKey) {
            return "Maaf, sistem AI sedang offline karena Groq API Key belum dikonfigurasi.";
        }

        $endpoint = 'https://api.groq.com/openai/v1/chat/completions';

        // 3. System Prompt
        $systemInstruction = "Kamu adalah Vanessa. Kamu adalah asisten virtual resmi untuk maskapai penerbangan Avoinex Airlines. Tugas utamamu adalah melayani pertanyaan pelanggan seputar informasi penerbangan, pemesanan tiket, kebijakan bagasi, layanan maskapai, dan bantuan perjalanan. Berbicaralah dengan nada yang sangat ramah, suportif, profesional, sopan, dan *selalu* gunakan Bahasa Indonesia yang baik (santai tapi sopan). Jika user bertanya hal di luar konteks penerbangan (seperti ilmu pengetahuan abstrak, coding kompleks dll yang jauh dari konteks liburan/perjalanan), jawablah dengan sopan bahwa kamu adalah asisten maskapai. Jangan gunakan gaya formatting markdown seperti teks tebal (bintang dua) yang berlebihan, pakaikan paragraf biasa yang rapi agar mudah dibaca di layar chat kecil.";

        try {
            // 4. Hit Groq Servers
            $response = Http::withoutVerifying()
                ->withToken($apiKey)
                ->timeout(15)
                ->post($endpoint, [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemInstruction
                        ],
                        [
                            'role' => 'user',
                            'content' => $message
                        ]
                    ],
                    'temperature' => 0.6,
                    'max_tokens' => 600
                ]);

            // 5. Decode Response
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['choices'][0]['message']['content'])) {
                    $aiResponseText = $data['choices'][0]['message']['content'];
                    
                    // Bersihkan markdown styling yang tidak perlu
                    $aiResponseText = str_replace(['**', '##', '###'], '', $aiResponseText);
                    
                    return trim($aiResponseText);
                }
            } else {
                $statusCode = $response->status();
                Log::error('Groq API HTTP Error [' . $statusCode . ']: ' . $response->body());
                
                if ($statusCode == 429) {
                    return "Maaf, server otak buatan saya sedang sangat sibuk (Rate Limit). Mohon tunggu beberapa detik sebelum bertanya kembali ya.";
                }
                
                return "Maaf, sedang ada gangguan server pada sistem AI saya. Kode Error: " . $statusCode;
            }

        } catch (\Exception $e) {
            Log::error('Groq Request Exception: ' . $e->getMessage());
            return "Waduh, koneksi internet ke server AI terputus. Pastikan koneksi Anda stabil ya!";
        }
    }
}
