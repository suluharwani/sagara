<?php

namespace App\Libraries;

use InvalidArgumentException;

/** Server-side allowlist for the version 2 editor document. Never accept client SVG/HTML. */
class DesignDocument
{
    public const MAX_BYTES = 8388608;

    private function reject(): never
    {
        throw new InvalidArgumentException('Dokumen desain tidak valid. Buka dan simpan ulang melalui Design Studio.');
    }

    private function text($value, int $max): bool
    {
        return is_string($value) && mb_check_encoding($value, 'UTF-8')
            && strlen(mb_convert_encoding($value, 'UTF-16LE', 'UTF-8')) / 2 <= $max
            && !preg_match('/[\x00-\x08\x0b\x0c\x0e-\x1f\x{fffe}\x{ffff}]/u', $value);
    }

    private function number($value, float $min, float $max): bool
    {
        return (is_int($value) || is_float($value)) && is_finite((float) $value) && $value >= $min && $value <= $max;
    }

    public function raster($value, int $limit = 1800000, bool $pngOnly = false): string
    {
        if (!is_string($value) || strlen($value) > $limit || !preg_match('~^data:image/(png|jpeg|webp);base64,([A-Za-z0-9+/]+={0,2})$~D', $value, $matches)) {
            $this->reject();
        }
        $binary = base64_decode($matches[2], true);
        $info = $binary === false ? false : @getimagesizefromstring($binary);
        if (!$info || $info[0] * $info[1] > 24000000 || $info['mime'] !== 'image/' . $matches[1] || ($pngOnly && $matches[1] !== 'png')) {
            $this->reject();
        }
        return $value;
    }

    public function validate($raw): array
    {
        if (!is_array($raw) || ($raw['version'] ?? null) !== 2 || strlen(json_encode($raw, JSON_THROW_ON_ERROR)) > self::MAX_BYTES) {
            $this->reject();
        }
        $clean = ['version' => 2];
        foreach (['name' => 60, 'notes' => 500] as $key => $max) {
            if (!$this->text($raw[$key] ?? null, $max)) { $this->reject(); }
            $clean[$key] = $raw[$key];
        }
        foreach (['product' => ['player', 'keeper'], 'collar' => ['v-classic', 'v-cross', 'round-classic', 'round-rib', 'polo-button', 'polo-zip'], 'sleeves' => ['short', 'long']] as $key => $values) {
            if (!in_array($raw[$key] ?? null, $values, true)) { $this->reject(); }
            $clean[$key] = $raw[$key];
        }
        if (!in_array($raw['pants']['style'] ?? null, ['none', 'short', 'long'], true)) { $this->reject(); }
        $clean['pants'] = ['style' => $raw['pants']['style']];
        $ids = [];
        foreach (['shirt', 'pants'] as $piece) {
            $source = $piece === 'shirt' ? $raw : $raw['pants'];
            $target = [];
            foreach (['base', 'accent'] as $key) {
                if (!is_string($source[$key] ?? null) || !preg_match('/^#[0-9a-f]{6}$/iD', $source[$key])) { $this->reject(); }
                $target[$key] = $source[$key];
            }
            foreach (['pattern' => ['plain', 'diagonal', 'stripe', 'chevron', 'split', 'hoops'], 'material' => ['undecided', 'milano', 'serena', 'emboss', 'jarum', 'custom']] as $key => $values) {
                if (!in_array($source[$key] ?? null, $values, true)) { $this->reject(); }
                $target[$key] = $source[$key];
            }
            if (!$this->text($source['materialNote'] ?? null, 80)) { $this->reject(); }
            $target['materialNote'] = $source['materialNote'];
            foreach (['front', 'back'] as $side) {
                $layers = $source['sides'][$side] ?? null;
                if (!is_array($layers) || !array_is_list($layers) || count($layers) > 20) { $this->reject(); }
                $target['sides'][$side] = [];
                foreach ($layers as $layer) {
                    if (!is_array($layer) || !$this->text($layer['id'] ?? null, 80) || !preg_match('/^[a-zA-Z0-9_-]+$/D', $layer['id']) || isset($ids[$layer['id']]) || !in_array($layer['type'] ?? null, ['text', 'image', 'shape'], true)) { $this->reject(); }
                    $ids[$layer['id']] = true;
                    $item = ['id' => $layer['id'], 'type' => $layer['type']];
                    foreach (['x' => [180, 420], 'y' => [190, 610], 'scale' => [.25, 2], 'rotation' => [-180, 180]] as $key => [$min, $max]) {
                        if (!$this->number($layer[$key] ?? null, $min, $max)) { $this->reject(); }
                        $item[$key] = $layer[$key];
                    }
                    if ($layer['type'] === 'image') {
                        $item['src'] = $this->raster($layer['src'] ?? null);
                        foreach (['width' => 240, 'height' => 300] as $key => $max) {
                            if (!$this->number($layer[$key] ?? null, 1, $max)) { $this->reject(); }
                            $item[$key] = $layer[$key];
                        }
                    } else {
                        if (!is_string($layer['color'] ?? null) || !preg_match('/^#[0-9a-f]{6}$/iD', $layer['color'])) { $this->reject(); }
                        $item['color'] = $layer['color'];
                        if ($layer['type'] === 'text') {
                            if (!$this->text($layer['text'] ?? null, 40) || !in_array($layer['font'] ?? null, ['Arial', 'Impact', 'Georgia', 'Courier New'], true) || !is_bool($layer['bold'] ?? null) || !$this->number($layer['size'] ?? null, 8, 150)) { $this->reject(); }
                            foreach (['text', 'font', 'bold', 'size'] as $key) { $item[$key] = $layer[$key]; }
                        } else {
                            if (!in_array($layer['shape'] ?? null, ['circle', 'rect', 'star'], true)) { $this->reject(); }
                            $item['shape'] = $layer['shape'];
                        }
                    }
                    $target['sides'][$side][] = $item;
                }
            }
            if ($piece === 'shirt') { $clean = array_merge($clean, $target); }
            else { $clean['pants'] = array_merge($clean['pants'], $target); }
        }
        foreach (['S', 'M', 'L', 'XL', '2XL', '3XL'] as $size) {
            $quantity = $raw['quantities'][$size] ?? null;
            if (!is_int($quantity) || $quantity < 0 || $quantity > 999) { $this->reject(); }
            $clean['quantities'][$size] = $quantity;
        }
        return $clean;
    }
}
