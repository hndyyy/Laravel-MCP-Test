<?php

use App\Mcp\Servers\FileSystemServer;
use Laravel\Mcp\Facades\Mcp;

/*
|--------------------------------------------------------------------------
| MCP Server Registration
|--------------------------------------------------------------------------
|
| Di sini Anda mendaftarkan server MCP yang akan diekspos ke Claude AI.
| Method Mcp::local() mendaftarkan server yang berjalan di mesin yang sama.
|
*/

Mcp::local('filesystem', FileSystemServer::class);