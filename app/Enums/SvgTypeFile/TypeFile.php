<?php

namespace App\Enums\SvgTypeFile;

enum TypeFile: string
{
    case AI = 'ai';
    case BLANK_IMAGE = 'blank_image';
    case CSS = 'css';
    case DOC = 'doc';
    case FOLDER = 'folder';
    case PDF = 'pdf';
    case SQL = 'sql';
    case TIF = 'tif';
    case XML = 'xml';

    public static function svg($fileName = null)
    {
        if (!$fileName) {
            $fileName = '.blank_image';
        };
        $extention = pathinfo($fileName, PATHINFO_EXTENSION);
        $extention = strtolower($extention);
        return self::tryFrom($extention) ?? self::BLANK_IMAGE;
    }

    public function pathSvgLight()
    {
        return match ($this) {
            self::AI => asset('assets/media/svg/files/ai.svg'),
            self::BLANK_IMAGE => asset('assets/media/svg/files/blank-image.svg'),
            self::CSS => asset('assets/media/svg/files/css.svg'),
            self::DOC => asset('assets/media/svg/files/doc.svg'),
            self::FOLDER => asset('assets/media/svg/files/folder.svg'),
            self::PDF => asset('assets/media/svg/files/pdf.svg'),
            self::SQL => asset('assets/media/svg/files/sql.svg'),
            self::TIF => asset('assets/media/svg/files/tif.svg'),
            self::XML => asset('assets/media/svg/files/xml.svg'),
        };
    }

    public function pathSvgDark()
    {
        return match ($this) {
            self::AI => asset('assets/media/svg/files/ai-dark.svg'),
            self::BLANK_IMAGE => asset('assets/media/svg/files/blank-image-dark.svg'),
            self::CSS => asset('assets/media/svg/files/css-dark.svg'),
            self::DOC => asset('assets/media/svg/files/doc-dark.svg'),
            self::FOLDER => asset('assets/media/svg/files/folder-dark.svg'),
            self::PDF => asset('assets/media/svg/files/pdf-dark.svg'),
            self::SQL => asset('assets/media/svg/files/sql-dark.svg'),
            self::TIF => asset('assets/media/svg/files/tif-dark.svg'),
            self::XML => asset('assets/media/svg/files/xml-dark.svg'),
        };
    }
}
