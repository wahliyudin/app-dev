<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\FileService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    public function __construct(
        private FileService $fileService,
    ) {
    }

    public function index($id)
    {
        return view('applications.file', [
            'navItemActive' => NavItem::FILE,
            'application' => $this->fileService->findOrFail($id),
        ]);
    }
}
