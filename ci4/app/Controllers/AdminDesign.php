<?php

namespace App\Controllers;

use App\Libraries\DesignDocument;
use App\Models\CustomDesignModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminDesign extends BaseController
{
    public function index() { return $this->listing('design'); }
    public function templates() { return $this->listing('template'); }
    public function createDesign() { return $this->editor('design'); }
    public function createTemplate() { return $this->editor('template'); }
    public function editDesign(int $id) { return $this->editor('design', $id); }
    public function editTemplate(int $id) { return $this->editor('template', $id); }

    private function listing(string $kind)
    {
        $model = new CustomDesignModel();
        $statuses = $kind === 'template' ? CustomDesignModel::TEMPLATE_STATUSES : CustomDesignModel::DESIGN_STATUSES;
        $search = mb_substr(trim((string) $this->request->getGet('search')), 0, 100);
        $status = (string) $this->request->getGet('status');
        $ready = $model->ready();
        $records = [];
        $counts = [];
        if ($ready) {
            foreach ($statuses as $key => $label) { $counts[$key] = (new CustomDesignModel())->where('kind', $kind)->where('status', $key)->countAllResults(); }
            $model->select('id,code,title,category,status,customer_name,customer_phone,updated_at,revision')->where('kind', $kind);
            if (array_key_exists($status, $statuses)) { $model->where('status', $status); }
            if ($search !== '') { $model->groupStart()->like('title', $search)->orLike('code', $search)->orLike('customer_name', $search)->orLike('category', $search)->groupEnd(); }
            $records = $model->orderBy('updated_at', 'DESC')->orderBy('id', 'DESC')->paginate(20);
        }
        $data = compact('kind', 'statuses', 'search', 'status', 'ready', 'records', 'counts');
        $data['pager'] = $ready ? $model->pager : null;
        return view('admin/layout', ['content' => view('admin/content/designs/index', $data)]);
    }

    private function editor(string $kind, ?int $id = null)
    {
        helper('form');
        $model = new CustomDesignModel();
        if (!$model->ready()) { return redirect()->to('admin/' . ($kind === 'template' ? 'design-templates' : 'custom-designs')); }
        $record = $id ? $model->find($id) : null;
        if ($id && (!$record || $record['kind'] !== $kind)) { throw PageNotFoundException::forPageNotFound(); }
        $data = ['kind' => $kind, 'record' => $record, 'statuses' => $kind === 'template' ? CustomDesignModel::TEMPLATE_STATUSES : CustomDesignModel::DESIGN_STATUSES];
        $data['studio'] = view('home/content/design-studio', ['studioConfig' => [
            'admin' => true, 'kind' => $kind, 'recordId' => $id, 'revision' => (int) ($record['revision'] ?? 0),
            'loadUrl' => $id ? base_url('admin/design-records/' . $id) : null,
            'saveUrl' => base_url('admin/design-records'), 'csrf' => csrf_hash(), 'csrfHeader' => csrf_header(),
        ]]);
        return view('admin/layout', ['content' => view('admin/content/designs/editor', $data)]);
    }

    public function record(int $id)
    {
        $record = (new CustomDesignModel())->find($id);
        if (!$record) { throw PageNotFoundException::forPageNotFound(); }
        return $this->response->setJSON(['document' => json_decode($record['document'], true), 'revision' => (int) $record['revision']]);
    }

    public function download(int $id)
    {
        $record = (new CustomDesignModel())->find($id);
        if (!$record) { throw PageNotFoundException::forPageNotFound(); }
        return $this->response->download($record['code'] . '.json', $record['document'])->setContentType('application/json');
    }

    public function save()
    {
        try {
            $body = $this->request->getBody();
            if (strlen($body) > DesignDocument::MAX_BYTES) { throw new \InvalidArgumentException('Kiriman maksimal 8 MB. Kurangi gambar pada desain.'); }
            $input = json_decode($body, true, 32, JSON_THROW_ON_ERROR);
            if (!is_array($input)) { throw new \InvalidArgumentException('Kiriman tidak valid.'); }
            $kind = $input['kind'] ?? null;
            $statuses = $kind === 'template' ? CustomDesignModel::TEMPLATE_STATUSES : CustomDesignModel::DESIGN_STATUSES;
            if (!in_array($kind, ['design', 'template'], true) || !is_string($input['status'] ?? null) || !array_key_exists($input['status'], $statuses)) { throw new \InvalidArgumentException('Jenis atau status tidak valid.'); }
            $data = [];
            foreach (['title' => 60, 'category' => 80, 'customer_name' => 100, 'customer_phone' => 30, 'admin_note' => 3000] as $key => $max) {
                $value = $input[$key] ?? '';
                if (!is_string($value) || mb_strlen($value) > $max) { throw new \InvalidArgumentException('Kolom ' . $key . ' tidak valid atau terlalu panjang.'); }
                $data[$key] = trim($value);
            }
            if (mb_strlen($data['title']) < 2) { throw new \InvalidArgumentException('Nama desain minimal 2 karakter.'); }
            $validator = new DesignDocument();
            $document = $validator->validate($input['document'] ?? null);
            $document['name'] = $data['title'];
            if ($kind === 'template') {
                $data['customer_name'] = $data['customer_phone'] = '';
                $document['notes'] = '';
                $document['quantities'] = ['S' => 0, 'M' => 1, 'L' => 0, 'XL' => 0, '2XL' => 0, '3XL' => 0];
            }
            $document = $validator->validate($document);
            $data += ['kind' => $kind, 'status' => $input['status'], 'document' => json_encode($document, JSON_THROW_ON_ERROR), 'thumbnail' => empty($input['thumbnail']) ? null : $validator->raster($input['thumbnail'], 600000, true)];
            $model = new CustomDesignModel();
            $id = $input['id'] ?? null;
            if ($id !== null) {
                if (!is_int($id) || $id < 1 || !is_int($input['revision'] ?? null)) { throw new \InvalidArgumentException('Identitas desain tidak valid.'); }
                $record = $model->find($id);
                if (!$record || $record['kind'] !== $kind) { return $this->reply(['error' => 'Desain tidak ditemukan.'], 404); }
                $revision = $input['revision'];
                $db = \Config\Database::connect();
                $ok = $db->table('custom_designs')->where('id', $id)->where('revision', $revision)->update($data + ['revision' => $revision + 1, 'updated_at' => date('Y-m-d H:i:s')]);
                if (!$ok) { throw new \RuntimeException('Update failed'); }
                if ($db->affectedRows() !== 1) { return $this->reply(['error' => 'Desain sudah diubah pada sesi lain. Unduh perubahan Anda lalu muat ulang halaman.'], 409); }
                $revision++;
            } else {
                $data['code'] = ($kind === 'template' ? 'TPL-' : 'SGR-') . strtoupper(bin2hex(random_bytes(8)));
                $id = $model->insert($data);
                if (!$id) { throw new \RuntimeException('Insert failed'); }
                $revision = 1;
            }
            return $this->reply(['id' => (int) $id, 'revision' => $revision, 'url' => base_url('admin/' . ($kind === 'template' ? 'design-templates/' : 'custom-designs/') . $id), 'message' => $kind === 'template' && $data['status'] === 'published' ? 'Template dipublikasikan dan tersedia di Design Studio.' : 'Desain berhasil disimpan.']);
        } catch (\InvalidArgumentException | \JsonException $error) {
            return $this->reply(['error' => $error->getMessage()], 422);
        } catch (\Throwable $error) {
            log_message('error', 'Admin design save failed: {type}', ['type' => get_class($error)]);
            return $this->reply(['error' => 'Penyimpanan gagal. Perubahan masih ada di editor; silakan coba lagi.'], 500);
        }
    }

    private function reply(array $body, int $status = 200)
    {
        return $this->response->setStatusCode($status)->setJSON($body + ['csrf' => csrf_hash()]);
    }
}
