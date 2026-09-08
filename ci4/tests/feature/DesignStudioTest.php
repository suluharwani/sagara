<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

final class DesignStudioTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testStudioIsPublicAndContainsEditorAndExports(): void
    {
        $result = $this->get('design');
        $result->assertOK();
        $result->assertSee('Desain Custom | Sagara Jersey', 'title');
        $result->assertSeeElement('#ds-canvas');
        $result->assertSeeElement('#ds-download-png');
        $result->assertSeeElement('#ds-import');
        $result->assertSeeElement('#ds-whatsapp');
        $result->assertSeeElement('#ds-collar');
        $result->assertSeeElement('#ds-sleeves');
        $result->assertSeeElement('#ds-pants-style');
        $result->assertSeeElement('#ds-material');
        $result->assertSeeElement('#ds-edit-pants');
        $result->assertSee('Keeper / kiper');
        $result->assertSee('Kerah polo resleting');
    }

    public function testCustomAliasUsesSameStudio(): void
    {
        $result = $this->get('design/custom');
        $result->assertOK();
        $result->assertSeeElement('#design-studio');
    }

    public function testExistingUploadPageLinksToStudio(): void
    {
        $result = $this->get('design/upload');
        $result->assertOK();
        $result->assertSee('Buat langsung di Sagara Design Studio');
        $result->assertSeeElement('#uploadForm');
    }
}
