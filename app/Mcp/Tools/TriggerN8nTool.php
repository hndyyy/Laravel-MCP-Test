<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Illuminate\Support\Facades\Http;

class TriggerN8nTool extends Tool
{
    /**
     * Deskripsi ini penting agar Claude tahu KAPAN harus menggunakan tool ini.
     */
    protected string $description = 'Memicu webhook n8n untuk proses deployment otomatis. Gunakan tool ini HANYA SETELAH kamu selesai memodifikasi file dan ingin melakukan Git Add/Commit/Push.';

    /**
     * Logika utama tool.
     */
    public function handle(Request $request): Response
    {
        // 1. Konfigurasi URL n8n
        // Karena n8n jalan di Docker (port 5678) dan Laravel di WSL,
        // biasanya 'localhost' bisa tembus jika port 5678 terekspos di Windows.
        // Jika gagal, ganti dengan 'host.docker.internal' atau IP LAN PC Anda.
        $webhookPath = 'deploy-git'; // Sesuaikan dengan path di Node Webhook n8n Anda
        $n8nUrl = "http://localhost:5678/webhook/deploy-git";

        // 2. Ambil input dari Claude
        // Kita gunakan $request->get() sesuai perbaikan sebelumnya
        $commitMessage = $request->get('message') ?? 'Auto-update by Claude Desktop';

        try {
            // 3. Kirim HTTP POST ke n8n
            $response = Http::timeout(10)->post($n8nUrl, [
                'source'  => 'claude_desktop_via_laravel',
                'action'  => 'git_deploy',
                'message' => $commitMessage,
                'path'    => base_path(), // Memberi tahu n8n folder mana yang harus di-git
            ]);

            // 4. Cek respons
            if ($response->successful()) {
                return Response::text("Berhasil! Sinyal terkirim ke n8n.\nResponse n8n: " . $response->body());
            }

            return Response::text("Gagal menghubungi n8n.\nStatus Code: " . $response->status() . "\nError: " . $response->body());

        } catch (\Throwable $e) {
            return Response::text("System Error (Koneksi ke n8n gagal): " . $e->getMessage() . "\nPastikan n8n berjalan dan URL webhook benar.");
        }
    }

    /**
     * Definisi parameter yang harus diisi Claude.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'message' => $schema->string('Pesan commit untuk Git. Jelaskan perubahan apa yang baru saja dilakukan secara singkat.'),
        ];
    }
}