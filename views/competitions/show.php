<?php
// جلب صور المسابقة إذا لم تكن موجودة مسبقاً
if (!isset($competition_images)) {
    $imgModel = new \App\Models\CompetitionImage($this->config);
    $competition_images = $imgModel->findByCompetition($competition['id']);
}
?>
<div class="hero" style="padding: 50px 0; background: linear-gradient(135deg, rgba(225, 29, 72, 0.05), rgba(249, 115, 22, 0.05));">



    <!-- نهاية الصفحة: معرض صور المسابقة -->
    <div class="container">
        <div style="max-width: 1100px; margin: 0 auto; text-align: center;">
            <?php if (!empty($competition['logo_path'])): ?>
                <img src="<?= $this->asset($competition['logo_path']) ?>" 
                     alt="<?= $this->e($competition['name_ar']) ?>"
                     class="comp-logo-large">
            <?php elseif (!empty($competition_images) && !empty($competition_images[0]['image_path'])): ?>
                <div class="comp-banner">
                    <img src="<?= $this->asset($competition_images[0]['image_path']) ?>" alt="<?= $this->e($competition['name_ar']) ?>">
                </div>
            <?php else: ?>
                <div class="comp-logo-placeholder"></div>
            <?php endif; ?>
                    <br\>

            <h1 style="width:100%;" class="section-title"><?= $this->e($competition['name_ar']) ?></h1>
            <div style="font-size: 18px; color: var(--primary); font-weight: 600; margin-bottom: 15px;">
                <?= $this->e($competition['code']) ?>
            </div>
            <p style="color: var(--text-muted); font-size: 16px; line-height: 1.8;">
                <?= $this->e($competition['description_ar'] ?? 'مسابقة علمية دولية') ?>
            </p>
            <?php if (!empty($competition['long_description_ar'])): ?>
            <div class="long-description">
                <?= $competition['long_description_ar'] ?>
            </div>
            <?php endif; ?>






    <?php if (!empty($competition_images)): ?>
    <!-- معرض صور المسابقة الاحترافي -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 22px;
        margin: 0 auto 40px auto;
        max-width: 1100px;
    }
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        box-shadow: 0 2px 12px #0002;
        cursor: pointer;
        background: #fff;
        transition: transform 0.18s, box-shadow 0.18s;
    }
    .gallery-item:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 8px 32px #0003;
    }
    .gallery-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 16px;
        transition: filter 0.2s;
    }
    .gallery-item .gallery-caption {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: linear-gradient(0deg, #222b 80%, #2220 100%);
        color: #fff;
        padding: 12px 10px 8px 10px;
        font-size: 15px;
        opacity: 0;
        transition: opacity 0.2s;
        pointer-events: none;
        border-radius: 0 0 16px 16px;
    }
    .gallery-item:hover .gallery-caption {
        opacity: 1;
    }
    /* Lightbox Styles */
    #gallery-lightbox-bg {
        position: fixed; z-index: 9999; left: 0; top: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.92); display: none; align-items: center; justify-content: center;
        flex-direction: column;
    }
    #gallery-lightbox-img {
        max-width: 92vw; max-height: 78vh; border-radius: 18px; box-shadow: 0 8px 32px #0008;
        background: #fff;
        transition: box-shadow 0.2s;
    }
    #gallery-lightbox-caption {
        color: #fff; text-align: center; margin-top: 18px; font-size: 20px; font-weight: 500;
        text-shadow: 0 2px 8px #000a;
    }
    #gallery-lightbox-bg .close-btn {
        position: absolute; top: 30px; right: 40px; color: #fff; font-size: 44px; cursor: pointer; font-weight: bold;
        z-index: 10001;
    }
    #gallery-lightbox-bg .arrow-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        color: #fff; font-size: 48px; cursor: pointer; font-weight: bold;
        background: rgba(0,0,0,0.18); border: none; border-radius: 50%; width: 56px; height: 56px;
        display: flex; align-items: center; justify-content: center;
        z-index: 10001;
        transition: background 0.18s;
    }
    #gallery-lightbox-bg .arrow-btn:hover {
        background: rgba(0,0,0,0.38);
    }
    #gallery-lightbox-bg .arrow-left { left: 32px; }
    #gallery-lightbox-bg .arrow-right { right: 32px; }
    @media (max-width: 600px) {
        .gallery-item img { height: 120px; }
        #gallery-lightbox-img { max-width: 98vw; max-height: 60vh; }
        #gallery-lightbox-bg .arrow-btn { width: 40px; height: 40px; font-size: 30px; }
    }
    </style>
    <div class="container" style="margin: 48px auto 32px auto;">
            <h2 style="color: var(--primary); font-size: 22px; margin-bottom: 18px; text-align: center;">معرض صور المسابقة</h2>
            <div class="gallery-grid">
                    <?php foreach ($competition_images as $idx => $img): ?>
                            <div class="gallery-item" data-idx="<?= $idx ?>" onclick="openGalleryLightbox(<?= $idx ?>)">
                                    <img src="<?= $this->asset($img['image_path']) ?>" alt="صورة للمسابقة">
                                    <?php if (!empty($img['caption_ar']) || !empty($img['caption_en'])): ?>
                                    <div class="gallery-caption">
                                        <?= $this->e($img['caption_ar'] ?? '') ?>
                                        <?php if (!empty($img['caption_en'])): ?><br><span style="font-size:13px; color:#eee;"> <?= $this->e($img['caption_en']) ?> </span><?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                            </div>
                    <?php endforeach; ?>
            </div>
    </div>
    <div id="gallery-lightbox-bg" tabindex="-1">
        <span class="close-btn" onclick="closeGalleryLightbox()">&times;</span>
        <button class="arrow-btn arrow-left" onclick="galleryPrev(event)"><i class="fa fa-chevron-left"></i></button>
        <button class="arrow-btn arrow-right" onclick="galleryNext(event)"><i class="fa fa-chevron-right"></i></button>
        <div style="display:flex;flex-direction:column;align-items:center;">
            <img id="gallery-lightbox-img" src="" alt="صورة مكبرة">
            <div id="gallery-lightbox-caption"></div>
        </div>
    </div>
    <script>
    const galleryImages = <?php echo json_encode(array_map(function($img) {
        return [
            $this->asset($img['image_path']),
            ($img['caption_ar'] ?? '') . (empty($img['caption_en']) ? '' : "<br><span style='font-size:13px;color:#eee'>".htmlspecialchars($img['caption_en'])."</span>")
        ];
    }, $competition_images)); ?>;
    let galleryIdx = 0;
    function openGalleryLightbox(idx) {
        galleryIdx = idx;
        showGalleryImg();
        document.getElementById('gallery-lightbox-bg').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeGalleryLightbox() {
        document.getElementById('gallery-lightbox-bg').style.display = 'none';
        document.body.style.overflow = '';
    }
    function showGalleryImg() {
        const [src, caption] = galleryImages[galleryIdx];
        document.getElementById('gallery-lightbox-img').src = src;
        document.getElementById('gallery-lightbox-caption').innerHTML = caption || '';
    }
    function galleryPrev(e) {
        e.stopPropagation();
        galleryIdx = (galleryIdx - 1 + galleryImages.length) % galleryImages.length;
        showGalleryImg();
    }
    function galleryNext(e) {
        e.stopPropagation();
        galleryIdx = (galleryIdx + 1) % galleryImages.length;
        showGalleryImg();
    }
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const lb = document.getElementById('gallery-lightbox-bg');
        if (lb.style.display === 'flex') {
            if (e.key === 'ArrowLeft') galleryPrev(e);
            if (e.key === 'ArrowRight') galleryNext(e);
            if (e.key === 'Escape') closeGalleryLightbox();
        }
    });
    // Close on background click
    document.getElementById('gallery-lightbox-bg').addEventListener('click', function(e) {
        if (e.target === this) closeGalleryLightbox();
    });
    </script>
    <?php endif; ?>






        </div>
    </div>
</div>

<section>
    <div class="container">
        <div class="card" style="background: var(--card-bg); border: none; box-shadow: 0 14px 36px rgba(248, 113, 113, 0.15); border-radius: 22px; padding: 30px;">
            <h2 style="color: var(--text-main); margin-bottom: 20px;">معلومات عن المسابقة</h2>
            
            <div style="display: grid; gap: 20px;">
                <div>
                    <strong style="color: var(--text-main);">الفئة:</strong>
                    <span style="color: var(--text-muted); margin-right: 10px;">
                        <?php
                        $categories = [
                            'mathematics' => 'رياضيات',
                            'informatics' => 'معلوماتية',
                            'physics' => 'فيزياء',
                            'chemistry' => 'كيمياء',
                            'biology' => 'أحياء',
                            'ai' => 'ذكاء اصطناعي',
                            'cybersecurity' => 'أمن سيبراني',
                            'other' => 'أخرى'
                        ];
                        echo $categories[$competition['category']] ?? $competition['category'];
                        ?>
                    </span>
                </div>
                
                <?php if (!empty($competition['description_en'])): ?>
                <div>
                    <strong style="color: var(--text-main);">الوصف بالإنجليزية:</strong>
                    <p style="color: var(--text-muted); margin-top: 8px; line-height: 1.8;">
                        <?= $this->e($competition['description_en']) ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if (!isset($_SESSION['user_id'])): ?>
<section>
    <div class="container">
        <div class="card" style="background: linear-gradient(135deg, var(--primary), #f97316); border: none; border-radius: 22px; padding: 50px; text-align: center; color: white;">
            <h2 style="color: white; font-size: 28px; margin-bottom: 15px;">هل أنت مستعد للتحدي؟</h2>
            <p style="color: rgba(255, 255, 255, 0.9); font-size: 16px; margin-bottom: 25px;">
                سجل الآن وابدأ رحلتك في المسابقات العلمية الدولية
            </p>
            <a href="<?= $this->url('/register/student') ?>" 
               class="btn" 
               style="display: inline-block; padding: 12px 30px; background: white; color: var(--primary); font-weight: 700; text-decoration: none; border-radius: 999px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                سجل كطالب الآن
            </a>
        </div>
    </div>
</section>
<?php endif; ?>
