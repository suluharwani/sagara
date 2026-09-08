<?php

use App\Libraries\DesignDocument;
use App\Models\CustomDesignModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

final class DesignManagementTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        helper(['form', 'url']);
        $db = db_connect();
        $this->assertSame('SQLite3', $db->DBDriver, 'These tests must use the isolated SQLite test database.');
        $forge = \Config\Database::forge();
        require_once APPPATH . 'Database/Migrations/2026-09-08-000001_CreateCustomDesigns.php';
        (new \App\Database\Migrations\CreateCustomDesigns())->up();
        $db->table('custom_designs')->emptyTable();
        $forge->addField(['id' => ['type' => 'INT'], 'level' => ['type' => 'INT'], 'status' => ['type' => 'INT'], 'deleted_at' => ['type' => 'DATETIME', 'null' => true]]);
        $forge->createTable('user', true);
        $db->table('user')->emptyTable();
        $db->table('user')->insert(['id' => 1, 'level' => 1, 'status' => 1]);
        $this->withSession([]);
        $throttler = $this->createMock(\CodeIgniter\Throttle\Throttler::class);
        $throttler->method('check')->willReturn(true);
        \Config\Services::injectMock('throttler', $throttler);
    }

    private function document(): array
    {
        return json_decode(file_get_contents(APPPATH . 'Database/Seeds/design-templates.json'), true)[0]['document'];
    }

    private function admin(): self
    {
        // Password login's auth payload has no status field: check the current DB row instead.
        return $this->withSession(['logged' => true, 'auth' => ['id' => 1, 'level' => 1]]);
    }

    private function send(string $path, array $payload)
    {
        return $this->withHeaders(['Content-Type' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest', csrf_header() => csrf_hash()])->withBody(json_encode($payload))->post($path);
    }

    private function payload(string $kind = 'template', string $status = 'draft'): array
    {
        return ['kind' => $kind, 'status' => $status, 'title' => 'Template uji', 'category' => 'Keeper', 'admin_note' => 'Internal only', 'document' => $this->document()];
    }

    private function insert(string $kind, string $status): int
    {
        return (int) (new CustomDesignModel())->insert(['kind' => $kind, 'status' => $status, 'code' => bin2hex(random_bytes(8)), 'title' => 'Uji ' . $status, 'category' => 'Keeper', 'document' => json_encode($this->document())]);
    }

    private function assertNotFound(string $path): void
    {
        try {
            $this->get($path);
            $this->fail('Private or archived content must not be public.');
        } catch (\CodeIgniter\Exceptions\PageNotFoundException $error) {
            $this->assertSame(404, $error->getCode());
        }
    }

    public function testAdminPagesRequireAdminSession(): void
    {
        $this->get('admin/custom-designs')->assertRedirectTo(base_url('admin/login'));
        $this->withSession(['customer' => ['id' => 1]])->get('admin/design-templates/new')->assertRedirectTo(base_url('admin/login'));
        $this->withSession(['logged' => true, 'auth' => ['id' => 1, 'level' => 2]])->get('admin/design-templates')->assertStatus(403);
    }

    public function testAdministratorCanOpenBothManagersAndTemplateEditor(): void
    {
        $this->admin()->get('admin/custom-designs')->assertOK();
        $this->admin()->get('admin/design-templates')->assertSee('Tambah Template');
        $this->admin()->get('admin/design-templates/new')->assertSeeElement('#design-admin-form');
    }

    public function testDisabledAdminLosesAccess(): void
    {
        db_connect()->table('user')->where('id', 1)->update(['status' => 0]);
        $this->admin()->get('admin/custom-designs')->assertStatus(403);
    }

    public function testOnlyPublishedTemplatesAndNoPrivateDesignsArePublic(): void
    {
        $published = $this->insert('template', 'published');
        $draft = $this->insert('template', 'draft');
        $private = $this->insert('design', 'approved');
        $this->insert('template', 'archived');
        $response = $this->get('design/templates'); $response->assertOK();
        $rows = json_decode($response->response()->getBody(), true)['templates'];
        $this->assertCount(1, $rows); $this->assertSame($published, (int) $rows[0]['id']);
        $this->assertArrayNotHasKey('document', $rows[0]); $this->assertArrayNotHasKey('admin_note', $rows[0]);
        $this->assertNotFound('design/templates/' . $draft);
        $this->assertNotFound('design/templates/' . $private);
        $this->get('design/templates/' . $published)->assertOK();
    }

    public function testSavePublishArchiveAndPreventStaleAdminUpdates(): void
    {
        $payload = $this->payload(); $payload['document']['notes'] = 'PRIVATE CUSTOMER NOTES';
        $response = $this->admin()->send('admin/design-records', $payload); $response->assertOK();
        $data = json_decode($response->response()->getBody(), true);
        $row = (new CustomDesignModel())->find($data['id']);
        $this->assertSame('', json_decode($row['document'], true)['notes']);
        $this->assertSame('Internal only', $row['admin_note']);
        $payload += ['id' => $data['id'], 'revision' => 1]; $payload['status'] = 'published';
        $this->admin()->send('admin/design-records', $payload)->assertOK();
        $this->withSession([])->get('design/templates/' . $data['id'])->assertOK();
        $this->admin()->send('admin/design-records', $payload)->assertStatus(409);
        $payload['revision'] = 2; $payload['status'] = 'archived';
        $this->admin()->send('admin/design-records', $payload)->assertOK();
        $this->withSession([])->assertNotFound('design/templates/' . $data['id']);
    }

    public function testCustomerSubmissionIsStoredPrivatelyAndCanBeReviewed(): void
    {
        $payload = ['customer_name' => 'Tim Pengujian', 'customer_phone' => '081234567890', 'document' => $this->document()];
        $result = $this->send('design/submit', $payload); $result->assertStatus(201);
        $data = json_decode($result->response()->getBody(), true);
        $row = (new CustomDesignModel())->where('code', $data['code'])->first();
        $this->assertSame('new', $row['status']); $this->assertSame('design', $row['kind']);
        $this->get('admin/design-records/' . $row['id'])->assertStatus(401);
        $this->admin()->get('admin/custom-designs/' . $row['id'])->assertSee('Tim Pengujian');
        $update = $this->payload('design', 'review') + ['id' => (int) $row['id'], 'revision' => 1, 'customer_name' => 'Tim Pengujian'];
        $this->admin()->send('admin/design-records', $update)->assertOK();
        $this->assertSame('review', (new CustomDesignModel())->find($row['id'])['status']);
    }

    public function testRejectsMalformedDocumentAndUnsafeImagesWithoutInsert(): void
    {
        $payload = $this->payload();
        $payload['document']['pants']['sides']['front'][0]['type'] = 'image';
        $payload['document']['pants']['sides']['front'][0]['src'] = 'https://example.com/track.svg';
        $this->admin()->send('admin/design-records', $payload)->assertStatus(422);
        $this->assertSame(0, (new CustomDesignModel())->countAllResults());
        $this->expectException(InvalidArgumentException::class);
        (new DesignDocument())->raster('data:image/png;base64,' . base64_encode('<svg onload="alert(1)"/>'));
    }

    public function testStateChangesRequireCsrf(): void
    {
        $this->expectException(\CodeIgniter\Security\Exceptions\SecurityException::class);
        try {
            $this->admin()->withHeaders(['Content-Type' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest', csrf_header() => 'invalid'])->withBody(json_encode($this->payload()))->post('admin/design-records');
        } finally { $this->assertSame(0, (new CustomDesignModel())->countAllResults()); }
    }
}
