<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Competition;
use App\Models\CompetitionImage;

class CompetitionImageController extends Controller
{
    public function index(string $id): void
    {
        $this->requireRole('admin');
        $competitionModel = new Competition($this->config);
        $competition = $competitionModel->findById((int)$id);
        if (!$competition) {
            $this->setFlash('error', 'المسابقة غير موجودة');
            $this->redirect('/admin/competitions');
        }
        $imageModel = new CompetitionImage($this->config);
        $images = $imageModel->findByCompetition((int)$id);
        $this->render('admin/competitions/images', [
            'competition' => $competition,
            'images' => $images,
            'csrf_token' => $this->generateCsrfToken(),
        ]);
    }
    public function upload(string $id): void
    {
        $this->requireRole('admin');
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/admin/competitions/' . $id . '/images');
        }
        $competitionModel = new Competition($this->config);
        $competition = $competitionModel->findById((int)$id);
        if (!$competition) {
            $this->setFlash('error', 'المسابقة غير موجودة');
            $this->redirect('/admin/competitions');
        }
        // support multiple files input name="images[]" or single file 'image'
        $files = [];
        if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
            // normalize files array
            foreach ($_FILES['images']['name'] as $i => $name) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $files[] = [
                        'tmp_name' => $_FILES['images']['tmp_name'][$i],
                        'name' => $_FILES['images']['name'][$i],
                        'type' => $_FILES['images']['type'][$i],
                    ];
                }
            }
        } elseif (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $files[] = [
                'tmp_name' => $_FILES['image']['tmp_name'],
                'name' => $_FILES['image']['name'],
                'type' => $_FILES['image']['type'],
            ];
        }

        if (empty($files)) {
            $this->setFlash('error', 'يجب اختيار صورة واحدة على الأقل صالحة');
            $this->redirect('/admin/competitions/' . $id . '/images');
        }
        $uploadsDir = $this->config['paths']['root'] . '/public/assets/uploads/competition_gallery';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }
        $imageModel = new CompetitionImage($this->config);
        $uploaded = 0;
        foreach ($files as $f) {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $filename = uniqid('img_') . '.' . $ext;
            $dest = $uploadsDir . '/' . $filename;
            if (!move_uploaded_file($f['tmp_name'], $dest)) {
                continue;
            }
            $imagePath = 'uploads/competition_gallery/' . $filename;
            $imageModel->create([
                'competition_id' => (int)$id,
                'image_path' => $imagePath,
                'caption_ar' => $_POST['caption_ar'] ?? null,
                'caption_en' => $_POST['caption_en'] ?? null,
                'sort_order' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $uploaded++;
        }
        if ($uploaded === 0) {
            $this->setFlash('error', 'فشل رفع أي من الصور');
        } else {
            $this->setFlash('success', "تم رفع {$uploaded} صورة بنجاح");
        }
        $this->redirect('/admin/competitions/' . $id . '/images');
    }

    public function delete(string $competitionId, string $imageId): void
    {
        $this->requireRole('admin');
        $imageModel = new CompetitionImage($this->config);
        $image = $imageModel->findById((int)$imageId);
        if (!$image || $image['competition_id'] != $competitionId) {
            $this->setFlash('error', 'الصورة غير موجودة');
            $this->redirect('/admin/competitions/' . $competitionId . '/images');
        }
        // حذف الملف من السيرفر
        $file = $this->config['paths']['root'] . '/public/assets/' . $image['image_path'];
        if (file_exists($file)) {
            @unlink($file);
        }
        $imageModel->delete((int)$imageId);
        $this->setFlash('success', 'تم حذف الصورة');
        $this->redirect('/admin/competitions/' . $competitionId . '/images');
    }

    /**
     * Toggle/set featured flag for an image
     */
    public function feature(string $competitionId, string $imageId): void
    {
        $this->requireRole('admin');
        if (!$this->validateCsrfToken()) {
            $this->setFlash('error', 'رمز الحماية غير صحيح');
            $this->redirect('/admin/competitions/' . $competitionId . '/images');
        }
        $imageModel = new CompetitionImage($this->config);
        $image = $imageModel->findById((int)$imageId);
        if (!$image || $image['competition_id'] != $competitionId) {
            $this->setFlash('error', 'الصورة غير موجودة');
            $this->redirect('/admin/competitions/' . $competitionId . '/images');
        }
        $isFeatured = isset($_POST['is_featured']) && ($_POST['is_featured'] === '1' || $_POST['is_featured'] === 'on');
        $imageModel->setFeatured((int)$imageId, $isFeatured);
        $this->setFlash('success', $isFeatured ? 'تم تمييز الصورة كمعروضة في الصفحة الرئيسية' : 'تم إزالة الصورة من المعروضة');
        $this->redirect('/admin/competitions/' . $competitionId . '/images');
    }
}
