<?php

namespace App\Commands;

use App\Libraries\DesignDocument;
use App\Models\CustomDesignModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DesignSetup extends BaseCommand
{
    protected $group = 'Sagara';
    protected $name = 'design:setup';
    protected $description = 'Create only the custom-design storage and seed the six initial templates without altering existing records.';

    public function run(array $params)
    {
        require_once APPPATH . 'Database/Migrations/2026-09-08-000001_CreateCustomDesigns.php';
        (new \App\Database\Migrations\CreateCustomDesigns())->up();
        $templates = json_decode(file_get_contents(APPPATH . 'Database/Seeds/design-templates.json'), true, 32, JSON_THROW_ON_ERROR);
        $model = new CustomDesignModel();
        $validator = new DesignDocument();
        $count = 0;
        foreach ($templates as $template) {
            $code = 'BUILTIN-' . strtoupper($template['id']);
            if ($model->where('code', $code)->first()) { continue; }
            $document = $validator->validate($template['document']);
            if (!$model->insert([
                'kind' => 'template', 'code' => $code, 'title' => $template['name'], 'category' => $template['tag'], 'status' => 'published',
                'document' => json_encode($document, JSON_THROW_ON_ERROR), 'thumbnail' => $validator->raster($template['thumbnail'], 600000, true),
            ])) { throw new \RuntimeException('Template awal gagal disimpan.'); }
            $count++;
        }
        CLI::write('Penyimpanan custom_designs siap. ' . $count . ' template awal ditambahkan. Data yang sudah ada tidak diubah.', 'green');
    }
}
