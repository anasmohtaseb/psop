<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">
        مكتبة صور المسابقة: <?= $this->e($competition['name_ar']) ?>
    </h1>
    <p style="color: var(--text-muted);">
        يمكنك رفع صور متعددة لهذه المسابقة وترتيبها أو حذفها.
    </p>
</div>

<div class="card" style="background: white; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 30px; max-width: 900px;">
    <form method="POST" action="<?= $this->url('/admin/competitions/' . $competition['id'] . '/images/upload') ?>" enctype="multipart/form-data">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        <div class="form-group">
            <label style="font-weight:600; color:var(--text-main);">رفع صور جديدة (متعدد)</label>
            <input type="file" name="images[]" accept="image/*" multiple required id="multi-images-input" style="margin-bottom:10px;">
            <div id="multi-images-preview" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:8px;"></div>
            <input type="text" name="caption_ar" placeholder="تعليق بالعربية يُطبق على كل الصور (اختياري)" style="width:100%;margin-bottom:8px;">
            <input type="text" name="caption_en" placeholder="Caption in English (optional)" style="width:100%;">
        </div>
        <button type="submit" class="btn btn-primary">رفع الصور</button>
    </form>
    <script>
    document.getElementById('multi-images-input').addEventListener('change', function(e){
        const preview = document.getElementById('multi-images-preview');
        preview.innerHTML = '';
        Array.from(this.files).forEach(file => {
            const fr = new FileReader();
            fr.onload = function(ev){
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.style.width = '90px'; img.style.height = '90px'; img.style.objectFit = 'cover'; img.style.borderRadius = '8px'; img.style.boxShadow = '0 2px 8px rgba(0,0,0,0.06)';
                preview.appendChild(img);
            };
            fr.readAsDataURL(file);
        });
    });
    </script>
    <hr>
    <div style="display:grid;gap:18px;">
        <?php foreach ($images as $img): ?>
            <div style="display:flex;align-items:center;gap:18px;background:#f9fafb;padding:12px 18px;border-radius:12px;">
                <img src="<?= $this->asset($img['image_path']) ?>" style="width:90px;height:90px;object-fit:cover;border-radius:10px;box-shadow:0 2px 8px #0001;">
                <div style="flex:1;">
                    <div style="font-weight:600;"> <?= $this->e($img['caption_ar']) ?> </div>
                    <div style="color:#888;"> <?= $this->e($img['caption_en']) ?> </div>
                </div>
                <div style="display:flex;gap:8px;align-items:center;">
                    <form method="POST" action="<?= $this->url('/admin/competitions/' . $competition['id'] . '/images/' . $img['id'] . '/feature') ?>" style="margin:0;">
                        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="is_featured" value="0">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin:0;padding:4px 8px;background:#fff;border-radius:8px;border:1px solid #eee;">
                            <input type="checkbox" name="is_featured" value="1" <?= !empty($img['is_featured']) ? 'checked' : '' ?> onchange="this.form.submit()">
                            <span style="font-size:13px;color:#444;">مميزة</span>
                        </label>
                    </form>
                    <form method="POST" action="<?= $this->url('/admin/competitions/' . $competition['id'] . '/images/' . $img['id'] . '/delete') ?>" style="margin:0;">
                        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
                        <button type="submit" class="btn btn-danger" style="padding:6px 16px; font-size:14px;">حذف</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
