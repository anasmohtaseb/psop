<?php
/**
 * Admin Settings Page
 */

$groupNames = [
    'general' => '⚙️ General Settings',
    'contact' => '📞 Contact Information',
    'social' => '🌐 Social Media',
    'features' => '🔧 Features'
];
?>

<div class="admin-container">
    <div class="admin-header">
        <div>
            <h1 class="admin-title">⚙️ Site Settings</h1>
            <p class="admin-subtitle">Manage general settings and basic site information</p>
        </div>
    </div>

    <form method="POST" action="<?= $this->url('/admin/settings/update') ?>" enctype="multipart/form-data" class="settings-form">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

        <?php foreach ($settings_grouped as $group => $settings): ?>
            <div class="settings-section">
                <h2 class="settings-section-title"><?= $groupNames[$group] ?? $group ?></h2>
                
                <div class="settings-grid">
                    <?php foreach ($settings as $setting): ?>
                        <div class="setting-item <?= $setting['setting_type'] === 'boolean' ? 'setting-checkbox' : '' ?>">
                            <label for="<?= $setting['setting_key'] ?>" class="setting-label">
                                <?= $this->e($setting['display_name'] ?? $setting['display_name_ar'] ?? $setting['setting_key']) ?>
                            </label>
                            
                            <?php if ($setting['setting_type'] === 'text'): ?>
                                <input type="text" 
                                       id="<?= $setting['setting_key'] ?>" 
                                       name="<?= $setting['setting_key'] ?>" 
                                       class="form-control"
                                       value="<?= $this->e($setting['setting_value']) ?>">
                            
                            <?php elseif ($setting['setting_type'] === 'textarea'): ?>
                                <textarea id="<?= $setting['setting_key'] ?>" 
                                          name="<?= $setting['setting_key'] ?>" 
                                          class="form-control"
                                          rows="3"><?= $this->e($setting['setting_value']) ?></textarea>
                            
                            <?php elseif ($setting['setting_type'] === 'number'): ?>
                                <input type="number" 
                                       id="<?= $setting['setting_key'] ?>" 
                                       name="<?= $setting['setting_key'] ?>" 
                                       class="form-control"
                                       value="<?= $this->e($setting['setting_value']) ?>">
                            
                            <?php elseif ($setting['setting_type'] === 'image'): ?>
                                <div class="image-upload-wrapper">
                                    <?php if (!empty($setting['setting_value'])): ?>
                                        <div class="current-image" style="margin-bottom: 15px; position: relative; display: inline-block;">
                                            <img id="logo-preview" 
                                                 src="/psop/public/<?= $this->e($setting['setting_value']) ?>" 
                                                 alt="Current logo"
                                                 style="max-height: 100px; max-width: 200px; border-radius: 8px; border: 2px solid #e5e7eb; padding: 10px; background: white; display: block;"
                                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'80\'%3E%3Crect fill=\'%23e5e7eb\' width=\'100\' height=\'80\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'12\' fill=\'%23666\' text-anchor=\'middle\' dy=\'.3em\'%3E🖼️ No Logo%3C/text%3E%3C/svg%3E'">
                                            <div style="margin-top: 5px; font-size: 12px; color: #666;">
                                                📁 Current: <?= basename($setting['setting_value']) ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="current-image" style="margin-bottom: 15px;">
                                            <img id="logo-preview" 
                                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='80'%3E%3Crect fill='%23e5e7eb' width='100' height='80'/%3E%3Ctext x='50%25' y='50%25' font-size='12' fill='%23666' text-anchor='middle' dy='.3em'%3E🖼️ No Logo%3C/text%3E%3C/svg%3E"
                                                 alt="No logo"
                                                 style="max-height: 100px; border-radius: 8px; border: 2px solid #e5e7eb; display: block;">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <input type="file" 
                                           id="<?= $setting['setting_key'] ?>" 
                                           name="<?= $setting['setting_key'] ?>" 
                                           class="form-control"
                                           accept="image/*"
                                           onchange="previewLogo(this)">
                                    <input type="hidden" 
                                           name="<?= $setting['setting_key'] ?>_current" 
                                           value="<?= $this->e($setting['setting_value']) ?>">
                                    <small class="form-help" style="display: block; margin-top: 8px; color: #666;">
                                        📎 Preferred: PNG or SVG with transparent background (Max 5MB)
                                    </small>
                                </div>
                                
                                <script>
                                function previewLogo(input) {
                                    const preview = document.getElementById('logo-preview');
                                    if (input.files && input.files[0]) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            preview.src = e.target.result;
                                            preview.style.maxHeight = '100px';
                                            preview.style.maxWidth = '200px';
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                                </script>
                            
                            <?php elseif ($setting['setting_type'] === 'boolean'): ?>
                                <label class="toggle-switch">
                                    <input type="checkbox" 
                                           id="<?= $setting['setting_key'] ?>" 
                                           name="<?= $setting['setting_key'] ?>" 
                                           value="1"
                                           <?= $setting['setting_value'] == '1' ? 'checked' : '' ?>>
                                    <span class="toggle-slider"></span>
                                </label>
                            
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="form-actions" style="position: sticky; bottom: 0; background: white; padding: 20px; border-top: 2px solid #e5e7eb; margin: 0 -32px -32px; border-radius: 0 0 16px 16px;">
            <button type="submit" class="btn-primary" style="font-size: 16px; padding: 14px 32px;">
                💾 Save All Settings
            </button>
        </div>
    </form>
</div>

<style>
.settings-form {
    background: white;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.settings-section {
    margin-bottom: 40px;
}

.settings-section:last-of-type {
    margin-bottom: 0;
}

.settings-section-title {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 10px;
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 24px;
}

.setting-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.setting-item.setting-checkbox {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.setting-label {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
}

.image-upload-wrapper {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.current-image {
    padding: 12px;
    background: #f9fafb;
    border-radius: 8px;
    display: inline-block;
}

/* Toggle Switch */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 52px;
    height: 28px;
    margin: 0;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e1;
    transition: 0.3s;
    border-radius: 28px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.toggle-switch input:checked + .toggle-slider {
    background-color: #10b981;
}

.toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

.toggle-switch input:focus + .toggle-slider {
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

@media (max-width: 768px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }
}
</style>
