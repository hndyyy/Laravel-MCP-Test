<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Illuminate\Support\Facades\File;

class WriteFileTool extends Tool
{
    protected string $description = 'Menulis file (Root Access).';

    public function handle(Request $request): Response
    {
        try {
            // GANTI argument() JADI get()
            $path = $request->get('path');
            $content = $request->get('content');

            if (empty($path)) {
                return Response::text("Error: Parameter 'path' wajib diisi.");
            }

            $fullPath = base_path($path);

            if (str_contains($path, '.env')) {
                return Response::text("Security: Akses ke .env ditolak.");
            }

            $dir = dirname($fullPath);
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            File::put($fullPath, $content);
            return Response::text("Berhasil menulis file ke: $path");

        } catch (\Throwable $e) {
            return Response::text("System Error: " . $e->getMessage());
        }
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'path' => $schema->string('Path file'),
            'content' => $schema->string('Isi file')
        ];
    }
}