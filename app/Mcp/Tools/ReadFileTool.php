<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Illuminate\Support\Facades\File;

class ReadFileTool extends Tool
{
    protected string $description = 'Membaca isi file teks.';

    public function handle(Request $request): Response
    {
        try {
            // GANTI argument() JADI get()
            $path = $request->get('path');

            if (empty($path)) {
                return Response::text("Error: Parameter 'path' wajib diisi.");
            }

            $fullPath = base_path($path);

            if (!File::exists($fullPath)) {
                return Response::text("Error: File tidak ditemukan di: $path");
            }

            if (File::isDirectory($fullPath)) {
                return Response::text("Error: '$path' adalah folder. Gunakan list-files-tool.");
            }

            return Response::text(File::get($fullPath));

        } catch (\Throwable $e) {
            return Response::text("System Error: " . $e->getMessage());
        }
    }

    public function schema(JsonSchema $schema): array
    {
        return ['path' => $schema->string('Path file relative terhadap root')];
    }
}