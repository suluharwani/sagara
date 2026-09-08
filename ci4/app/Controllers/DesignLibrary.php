<?php

namespace App\Controllers;

use App\Libraries\DesignDocument;
use App\Models\CustomDesignModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DesignLibrary extends BaseController
{
    public function templates()
    {
        $model = new CustomDesignModel();
        if (!$model->ready()) { return $this->response->setStatusCode(503)->setJSON(['error' => 'Pustaka template belum tersedia.']); }
        $page = max(1, (int) $this->request->getGet('page'));
        $model->select('id,title,category,updated_at')->where('kind', 'template')->where('status', 'published');
        $search = mb_substr(trim((string) $this->request->getGet('search')), 0, 100);
        if ($search !== '') { $model->groupStart()->like('title', $search)->orLike('category', $search)->groupEnd(); }
        $rows = $model->orderBy('id', 'DESC')->findAll(25, ($page - 1) * 24);
        $hasMore = count($rows) > 24;
        $rows = array_slice($rows, 0, 24);
        foreach ($rows as &$row) {
            $row['url'] = base_url('design/templates/' . $row['id']);
            $row['thumbnail'] = base_url('design/templates/' . $row['id'] . '/thumbnail');
        }
        return $this->response->setHeader('Cache-Control', 'no-store')->setJSON(['templates' => $rows, 'hasMore' => $hasMore]);
    }

    private function published(int $id): array
    {
        $row = (new CustomDesignModel())->where('kind', 'template')->where('status', 'published')->find($id);
        if (!$row) { throw PageNotFoundException::forPageNotFound(); }
        return $row;
    }

    public function template(int $id)
    {
        $row = $this->published($id);
        return $this->response->setHeader('Cache-Control', 'no-store')->setJSON(['document' => json_decode($row['document'], true), 'title' => $row['title']]);
    }

    public function thumbnail(int $id)
    {
        $row = $this->published($id);
        if (!$row['thumbnail']) { return $this->response->setStatusCode(204); }
        return $this->response->setContentType('image/png')->setHeader('Cache-Control', 'no-store')->setHeader('X-Content-Type-Options', 'nosniff')->setBody(base64_decode(explode(',', $row['thumbnail'], 2)[1]));
    }

    public function submit()
    {
        $model = new CustomDesignModel();
        if (!$model->ready()) { return $this->reply(['error' => 'Penerimaan desain belum tersedia. Simpan file desain dahulu.'], 503); }
        if (!service('throttler')->check('design-submit-' . hash('sha256', $this->request->getIPAddress()), 5, 60)) {
            return $this->reply(['error' => 'Terlalu banyak kiriman. Coba lagi satu menit kemudian.'], 429);
        }
        try {
            $body = $this->request->getBody();
            if (strlen($body) > DesignDocument::MAX_BYTES) { throw new \InvalidArgumentException('Desain terlalu besar. Maksimal 8 MB per kiriman.'); }
            $input = json_decode($body, true, 32, JSON_THROW_ON_ERROR);
            if (!is_array($input)) { throw new \InvalidArgumentException('Kiriman tidak valid.'); }
            $name = $input['customer_name'] ?? null;
            $phone = $input['customer_phone'] ?? null;
            if (!is_string($name) || mb_strlen(trim($name)) < 2 || mb_strlen($name) > 100 || !is_string($phone) || !preg_match('/^\+?[0-9 ()-]{8,25}$/D', $phone) || !preg_match('/^[0-9]{8,15}$/D', preg_replace('/\D/', '', $phone))) {
                throw new \InvalidArgumentException('Isi nama dan nomor WhatsApp yang valid.');
            }
            $validator = new DesignDocument();
            $document = $validator->validate($input['document'] ?? null);
            if (array_sum($document['quantities']) < 1) { throw new \InvalidArgumentException('Isi jumlah kebutuhan minimal 1.'); }
            $code = 'SGR-' . strtoupper(bin2hex(random_bytes(8)));
            $id = $model->insert([
                'kind' => 'design', 'code' => $code, 'title' => trim($document['name']) ?: 'Desain custom', 'status' => 'new',
                'customer_name' => trim($name), 'customer_phone' => trim($phone),
                'document' => json_encode($document, JSON_THROW_ON_ERROR),
                'thumbnail' => empty($input['thumbnail']) ? null : $validator->raster($input['thumbnail'], 600000, true),
            ]);
            if (!$id) { throw new \RuntimeException('Desain belum tersimpan.'); }
            return $this->reply(['code' => $code, 'message' => 'Desain diterima admin Sagara. Simpan nomor referensi ini.'], 201);
        } catch (\InvalidArgumentException | \JsonException $error) {
            return $this->reply(['error' => $error->getMessage()], 422);
        } catch (\Throwable $error) {
            log_message('error', 'Custom design submission failed: {type}', ['type' => get_class($error)]);
            return $this->reply(['error' => 'Desain gagal disimpan. Silakan coba lagi.'], 500);
        }
    }

    private function reply(array $body, int $code = 200)
    {
        return $this->response->setStatusCode($code)->setHeader('Cache-Control', 'no-store')->setJSON($body + ['csrf' => csrf_hash()]);
    }
}
