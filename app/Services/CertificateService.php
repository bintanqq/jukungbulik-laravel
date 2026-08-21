<?php

namespace App\Services;

use App\Models\Order;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CertificateService
{
    /**
     * Generate a certificate image (PNG) for the given order.
     *
     * Uses template image from storage (or generates placeholder)
     * and overlays participant name + certificate code.
     *
     * @return string The path to the generated certificate file
     */
    public function generate(Order $order, string $certificateName): string
    {
        $manager = new ImageManager(new Driver());

        // 1. DYNAMIC BACKGROUND IMAGE SELECTION
        // Users can place any image (PNG/JPG) at storage/app/certificate-template.png or .jpg
        $templatePath = $this->resolveTemplatePath();

        if (!file_exists($templatePath)) {
            // Generate a placeholder template if none exists
            $this->createPlaceholderTemplate($templatePath);
        }

        $image = $manager->decodePath($templatePath);

        // Get image dimensions for centering text
        $width = $image->width();
        $height = $image->height();

        // 2. DYNAMIC FONT SELECTION
        // Users can put any TTF font at public/fonts/CertificateFont.ttf to change font
        $fontPath = $this->resolveFontPath();

        // Write participant name — centered, large font
        $image->text($certificateName, intval($width / 2), intval($height * 0.48), function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(60);
            $font->color('#1a1a2e');
            $font->align('center');
        });

        // Write certificate code — centered, smaller font below body text
        $image->text('No. Sertifikat: ' . $order->certificate_code, intval($width / 2), intval($height * 0.79), function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(20);
            $font->color('#6b7280');
            $font->align('center');
        });

        // Ensure the certificates output directory exists
        $certificateDir = storage_path('app/certificates');
        if (!is_dir($certificateDir)) {
            mkdir($certificateDir, 0755, true);
        }

        $outputPath = $certificateDir . '/' . $order->ticket_code . '.png';

        $image->save($outputPath);

        return $outputPath;
    }

    /**
     * Resolve custom template image path or default path.
     */
    private function resolveTemplatePath(): string
    {
        $customPng = storage_path('app/certificate-template.png');
        if (file_exists($customPng)) {
            return $customPng;
        }

        $customJpg = storage_path('app/certificate-template.jpg');
        if (file_exists($customJpg)) {
            return $customJpg;
        }

        return storage_path('app/certificate-template.png');
    }

    /**
     * Create a simple placeholder certificate template image.
     */
    private function createPlaceholderTemplate(string $path): void
    {
        $manager = new ImageManager(new Driver());

        // Create a 1920x1358 (A4 landscape ratio) white canvas
        $image = $manager->createImage(1920, 1358);

        // Fill with elegant gradient-style background
        $image->fill('#fefce8');

        // Draw decorative border
        $image->drawRectangle(function ($rectangle) {
            $rectangle->at(40, 40);
            $rectangle->size(1840, 1278);
            $rectangle->border('#c9a84c', 4);
        });

        $image->drawRectangle(function ($rectangle) {
            $rectangle->at(55, 55);
            $rectangle->size(1810, 1248);
            $rectangle->border('#c9a84c', 1);
        });

        // Title text
        $fontPath = $this->resolveFontPath();

        $image->text('SERTIFIKAT', 960, 200, function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(72);
            $font->color('#c9a84c');
            $font->align('center');
        });

        $image->text('PENGHARGAAN', 960, 280, function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(36);
            $font->color('#6b7280');
            $font->align('center');
        });

        $image->text('Diberikan kepada:', 960, 560, function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(24);
            $font->color('#9ca3af');
            $font->align('center');
        });

        // Decorative line for name area
        $image->drawLine(function ($line) {
            $line->from(560, 750);
            $line->to(1360, 750);
            $line->color('#c9a84c');
            $line->width(2);
        });

        $image->text('Atas partisipasinya dalam pertunjukan', 960, 830, function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(24);
            $font->color('#6b7280');
            $font->align('center');
        });

        $image->text('JUKUNG BULIK 2026', 960, 900, function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(40);
            $font->color('#1a1a2e');
            $font->align('center');
        });

        $image->text('Pertunjukan Teater Tradisional Banjar', 960, 960, function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(22);
            $font->color('#6b7280');
            $font->align('center');
        });

        $image->text('Banjarmasin, 01 Oktober 2026', 960, 1150, function ($font) use ($fontPath) {
            if ($fontPath) {
                $font->filename($fontPath);
            }
            $font->size(20);
            $font->color('#6b7280');
            $font->align('center');
        });

        // Make sure directory exists
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $image->save($path);
    }

    /**
     * Resolve dynamic font path (custom font -> default font -> system font).
     */
    private function resolveFontPath(): ?string
    {
        $fontsDir = public_path('fonts');
        if (!is_dir($fontsDir)) {
            mkdir($fontsDir, 0755, true);
        }

        // 1. Allow custom font placed at public/fonts/CertificateFont.ttf
        $customFont = $fontsDir . '/CertificateFont.ttf';
        if (file_exists($customFont)) {
            return $customFont;
        }

        // 2. Default Inter font
        $defaultFont = $fontsDir . '/Inter-Bold.ttf';
        if (file_exists($defaultFont)) {
            return $defaultFont;
        }

        // 3. Fallback to Windows system font
        $winFontBold = 'C:/Windows/Fonts/arialbd.ttf';
        if (file_exists($winFontBold)) {
            copy($winFontBold, $defaultFont);
            return $defaultFont;
        }

        $winFontRegular = 'C:/Windows/Fonts/arial.ttf';
        if (file_exists($winFontRegular)) {
            copy($winFontRegular, $defaultFont);
            return $defaultFont;
        }

        return null;
    }
}
