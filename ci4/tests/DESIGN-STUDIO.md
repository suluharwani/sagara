# Sagara Design Studio

Open `/design` (alias `/design/custom`). The navigation and homepage link to the editor. It uses the existing CodeIgniter layout and native SVG/Canvas; no additional frontend runtime dependencies are required.

## Admin management and setup

Run `php spark design:setup` from `ci4` on each environment before using management. This scoped, repeatable command creates only `custom_designs` and seeds the six original templates if missing. It never overwrites existing templates, status changes, or customer designs. The equivalent schema migration is `2026-09-08-000001_CreateCustomDesigns.php`; the command avoids running unrelated legacy migrations. Back up `custom_designs` with the application's other database tables. Documents and optional normalized PNG thumbnails are stored in the database, not a public upload folder.

- `/admin/custom-designs`: searchable, paginated customer designs; create a design, review its full editor/preview, edit artwork, update status (`new`, `review`, `revision`, `approved`, `archived`), add internal notes, and download the saved JSON.
- `/admin/design-templates`: searchable, paginated templates with draft/published/archived counts.
- `/admin/design-templates/new`: create a template in the studio or import an existing JSON file. Save Draft first, or explicitly choose Publik to make it available to customers. Editing and archiving are on the same editor page. Archiving is reversible.

The public studio reads only published templates from `/design/templates`, with server-side search and pagination. Selecting a published template loads its full shirt/pants configuration while retaining the customer's quantity and order notes. A missing/failed API does not bring archived built-ins back into the public gallery; users can retry loading the list. The admin's new-template editor can use the six bundled starting designs independently of publication status.

Customers can use **Kirim desain ke admin** in the review dialog, providing name and WhatsApp number. This stores a private version of the artwork and requirements with a reference code, and does not create a checkout order or send a message. Local drafts/files remain local unless that button is used. WhatsApp is still an independent customer-initiated inquiry.

All admin endpoints require the existing administrator login plus a current active `user` row with level 1. Customer sessions and operator accounts cannot access them. Writes use CSRF validation. Documents are validated again on the server, including decoded raster MIME type, dimensions, field allowlists, layer/size limits and the inactive pants layers. Public endpoints do not expose customer documents, contact information or internal notes. Template publication clears order notes, customer details and quantity presets. Concurrent saves use a revision check; a stale save returns 409 instead of overwriting another edit. Customer submissions are limited to five per IP per minute.

Features: player and keeper models; two variants each of V-neck, round neck and polo collars; independently selectable short/long sleeves; optional short/long pants; six original shirt templates; custom base/accent colors and patterns; independent front/back layers for both shirt and pants; text/fonts, normalized raster logo uploads, shapes, drag and numeric positioning, scale/rotation, layer ordering, duplicate/delete, undo/redo, browser draft recovery, JSON import/export, SVG mockup and combined 2400 × 1600 PNG export.

Select the clothing package in the Product tab, then use Atasan/Celana above the preview to choose which item to edit. Colors, patterns, material and all layer tools apply to the active item. Pants have separate print areas on each leg, with left/right positioning shortcuts. The clipping warning includes the crotch gap and the current pants length. Disabling pants preserves their artwork for later but excludes them from the exported mockup and quotation. Applying a shirt template preserves the chosen model, collar, sleeves, materials and pants artwork.

Material options are Milano, Serena, Emboss and Jarum (references present in Sagara's product archive), plus an undecided option and a custom material name. Shirt and pants materials can differ. These choices are requests, not live stock or price claims. Empty custom material names must be completed before opening the quotation link.

Drafts are local to this browser, not saved in the customer's account. JSON files are portable editable projects. Browser storage failures are shown to the customer with a file-download fallback. An existing draft is preserved until the customer chooses whether to restore it or start fresh. Logo uploads stay on the device. JSON imports use a strict allowlist and accept only embedded PNG/JPEG/WebP images, with document, layer and image limits.

New files use document version 2. Version 1 imports/drafts migrate to the equivalent collar/sleeve combination with no pants selected and preserve existing shirt layers. The storage key remains `sagara.design-studio.v1` so old drafts can still be discovered. All four layer collections are validated, including pants that are currently disabled.

The order dialog composes a WhatsApp inquiry to the existing Sagara business number. It includes model, collar, sleeve length, pants length, both material choices, colors/patterns, sizes, quantities and notes. Totals use pcs for shirts only and sets for shirt/pants packages. A set uses the same selected size for both items; customers can request different sizing in the notes. PNG exports show the entire selected package from the front and back; SVG exports contain the active piece/side. It does not set a price, create a cart/order record or attach files automatically; the customer downloads and attaches the PNG themselves. Mockups are illustrations, not manufacturing patterns or color proofs.

## Automated checks

From the `ci4` directory:

```sh
node --test tests/js/design-studio.test.cjs
php vendor/bin/phpunit tests/feature/DesignStudioTest.php --no-coverage
php -d extension=sqlite3 vendor/bin/phpunit tests/feature/DesignManagementTest.php --no-coverage
```

For the complete PHP suite, the existing `ExampleDatabaseTest` needs SQLite3. On a Windows PHP installation where the extension is present but disabled, enable it only for the test process:

```sh
php -d extension=sqlite3 vendor/bin/phpunit --no-coverage
```

## Browser acceptance checks

1. Open `/design` on desktop and mobile. Try keyboard tab navigation in the tool tabs, layers and dialog.
2. Apply each template and garment model. Change colors; edit front team text and back name/number independently.
3. Add PNG/JPEG/WebP logos, including transparent logos and invalid/oversized files. Try dropping a file into the logo area.
4. Drag text/logo; adjust size, angle and numeric positions. Select the canvas and use arrows (Shift for 10-unit steps). Check clipping warnings, duplicate/delete, ordering and undo/redo.
5. Reload after editing and restore the draft. Start fresh only on explicit choice. Download JSON and import it again; both sides, logos, quantities and notes should survive.
6. Export PNG and SVG. Verify front/back contents, transparent logos, no guides, correct dimensions and no clipping beyond the indicated area.
7. Enter zero, negative, fractional and valid size quantities. The WhatsApp link must require a positive total with integers from 0 to 999 per size. Inspect its composed message without sending it.
8. Simulate unavailable/full localStorage; edits must continue, with a visible warning and JSON download still available.
9. Combine each collar with both sleeve lengths and player/keeper. Select short and long pants, edit their front/back sides, and verify independent colors/materials and left/right placement.
10. Disable pants and export: no pants or pants materials should appear. Re-enable pants and confirm their artwork is restored. Apply a template and undo: model, materials and pants artwork must survive.
11. Import a version 1 file and check equivalent collar/sleeves. Save as version 2, reopen, and check all four sides plus material selections.
12. Submit a customer design and retain its reference. Log in as administrator, find it under Desain Custom, edit its status/note/artwork and save. Reload and download the stored JSON.
13. Create a template as Draft: it must not appear publicly. Publish it, search and apply it in the public studio, then archive it and verify both the gallery and direct public endpoints stop exposing it.
14. Open the same record in two admin tabs; save one and then try saving the other. The second must report a conflict and retain local changes for download.
