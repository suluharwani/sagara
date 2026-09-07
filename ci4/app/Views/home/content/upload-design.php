<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-upload me-2"></i> Upload Desain Custom</h2>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('design/upload') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                        <?= csrf_field() ?>
                        
                        <div class="upload-area" id="dropZone">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <h5>Drag & Drop file desain di sini</h5>
                            <p class="text-muted">atau klik untuk memilih file</p>
                            <input type="file" name="design" id="designFile" accept=".png,.jpg,.jpeg,.pdf,.svg" style="display: none;">
                            <p class="text-muted small mt-2">Format: PNG, JPG, PDF, SVG (Maks. 5MB)</p>
                        </div>
                        
                        <div id="previewArea" class="mt-3" style="display: none;">
                            <h6>Preview:</h6>
                            <img id="previewImage" src="" alt="Preview" class="img-fluid" style="max-height: 300px;">
                            <p id="fileName" class="mt-2"></p>
                        </div>
                        
                        <div class="progress mt-3" style="display: none;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-upload me-2"></i> Upload Desain
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Tips Desain</h6>
                </div>
                <div class="card-body">
                    <ul class="small">
                        <li>Gunakan resolusi minimal 300 DPI</li>
                        <li>Format PNG transparan untuk sablon</li>
                        <li>Ukuran desain sesuai ukuran jersey</li>
                        <li>Hindari gambar blur/pixelated</li>
                        <li>Gunakan warna CMYK untuk cetak</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('designFile');
    const previewArea = document.getElementById('previewArea');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    
    dropZone.addEventListener('click', () => fileInput.click());
    
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-primary');
    });
    
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-primary');
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary');
        fileInput.files = e.dataTransfer.files;
        handleFile(fileInput.files[0]);
    });
    
    fileInput.addEventListener('change', () => {
        handleFile(fileInput.files[0]);
    });
    
    function handleFile(file) {
        if (!file) return;
        
        fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
        
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewArea.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '<?= base_url('assets/img/file-icon.png') ?>';
            previewArea.style.display = 'block';
        }
    }
});
</script>