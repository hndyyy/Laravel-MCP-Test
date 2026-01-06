<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Illuminate\Support\Facades\File;

class ListFilesTool extends Tool
{
    protected string $description = 'List file dalam folder.';

    public function handle(Request $request): Response
    {
        // GANTI argument() JADI get()
        $path = $request->get('path') ?? '.';
        $fullPath = base_path($path);

        if (!File::isDirectory($fullPath)) {
            return Response::text("Folder tidak ditemukan: $path");
        }

        $files = File::files($fullPath);
        $dirs = File::directories($fullPath);
        
        $out = "Isi folder '$path':\n";
        foreach ($dirs as $d) $out .= "[DIR] " . basename($d) . "\n";
        foreach ($files as $f) $out .= "[FILE] " . $f->getFilename() . "\n";

        return Response::text($out);
    }

    public function schema(JsonSchema $schema): array
    {
        return ['path' => $schema->string('Path folder')];
    }
}