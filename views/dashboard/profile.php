<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1 style="color: var(--text-main); font-size: 28px; margin-bottom: 8px;">الملف الشخصي</h1>
    <p style="color: var(--text-muted);">تعديل البيانات الشخصية وكلمة المرور</p>
</div>

<div class="row" style="display: flex; flex-wrap: wrap; gap: 24px;">
    <div class="col-8" style="flex: 2; min-width: 300px;">
        <div class="card" style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <form action="<?= $this->url('/dashboard/profile/update') ?>" method="POST">
                <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
                
                <h3 style="color: var(--text-main); font-size: 18px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                    البيانات الأساسية
                </h3>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" value="<?= $this->e($user['name']) ?>" required
                           style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px;">
                </div>

                <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">البريد الإلكتروني</label>
                        <input type="email" value="<?= $this->e($user['email']) ?>" disabled
                               style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px; background: #f8fafc; cursor: not-allowed;">
                        <small style="color: var(--text-muted);">لا يمكن تغيير البريد الإلكتروني</small>
                    </div>
                    
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">رقم الهاتف</label>
                        <input type="tel" name="phone" id="phone" value="<?= $this->e($user['phone'] ?? '') ?>"
                               style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px; text-align: left;" dir="ltr">
                    </div>
                </div>

                <?php if ($user['type'] === 'student'): ?>
                    <h3 style="color: var(--text-main); font-size: 18px; margin: 30px 0 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                        بيانات الطالب
                    </h3>

                    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">المدرسة <span style="color: red;">*</span></label>
                            <select name="school_id" class="form-control" required
                                    style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px;">
                                <option value=""> اختر المدرسة </option>
                                <?php if (!empty($schools)): ?>
                                    <?php foreach ($schools as $school): ?>
                                        <option value="<?= $school['id'] ?>" <?= ($profile['school_id'] ?? '') == $school['id'] ? 'selected' : '' ?>>
                                            <?= $this->e($school['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">الصف الدراسي</label>
                            <select name="grade" class="form-control" 
                                    style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px;">
                                <?php for ($i = 5; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($profile['grade'] ?? '') == $i ? 'selected' : '' ?>>الصف <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">تاريخ الميلاد</label>
                            <input type="date" name="date_of_birth" value="<?= $profile['date_of_birth'] ?? '' ?>"
                                   style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px;">
                        </div>
                        
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">الجنس</label>
                            <select name="gender" class="form-control" 
                                    style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px;">
                                <option value="male" <?= ($profile['gender'] ?? '') === 'male' ? 'selected' : '' ?>>ذكر</option>
                                <option value="female" <?= ($profile['gender'] ?? '') === 'female' ? 'selected' : '' ?>>أنثى</option>
                            </select>
                        </div>
                    </div>

                    <h3 style="color: var(--text-main); font-size: 18px; margin: 30px 0 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                        بيانات ولي الأمر
                    </h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">اسم ولي الأمر</label>
                        <input type="text" name="guardian_name" value="<?= $this->e($profile['guardian_name'] ?? '') ?>"
                               style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px;">
                    </div>

                     <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">هاتف ولي الأمر</label>
                            <input type="tel" name="guardian_phone" value="<?= $this->e($profile['guardian_phone'] ?? '') ?>"
                                   style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px; text-align: left;" dir="ltr">
                        </div>
                        
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">بريد ولي الأمر</label>
                            <input type="email" name="guardian_email" value="<?= $this->e($profile['guardian_email'] ?? '') ?>"
                                   style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px;">
                        </div>
                    </div>

                <?php endif; ?>

                <h3 style="color: var(--text-main); font-size: 18px; margin: 30px 0 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                    الأمان (اختياري)
                </h3>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-main);">كلمة المرور الجديدة</label>
                    <input type="password" name="password" class="form-control" placeholder="اترك الحقل فارغاً إذا كنت لا تريد التغيير"
                           style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 12px;">
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 32px; font-weight: 700;">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-4" style="flex: 1; min-width: 300px;">
        <div class="card" style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); text-align: center;">
            <div style="width: 100px; height: 100px; margin: 0 auto 20px; background: #e11d48; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 40px; font-weight: 700;">
                <?= mb_substr($user['name'], 0, 1) ?>
            </div>
            
            <h3 style="color: var(--text-main); font-size: 20px; margin-bottom: 4px;"><?= $this->e($user['name']) ?></h3>
            
            <?php
            $typeLabels = [
                'student' => 'طالب',
                'teacher' => 'معلم',
                'school_coordinator' => 'منسق مدرسة',
                'admin' => 'مسؤول النظام'
            ];
            ?>
            <span style="display: inline-block; padding: 4px 12px; background: #fdf2f8; color: #be185d; border-radius: 999px; font-size: 13px; font-weight: 600;">
                <?= $typeLabels[$user['type']] ?? $user['type'] ?>
            </span>
            
            <div style="margin-top: 24px; text-align: right;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; padding: 12px; background: #f8fafc; border-radius: 12px;">
                    <span style="font-size: 20px;">📧</span>
                    <div style="font-size: 14px; word-break: break-all;"><?= $this->e($user['email']) ?></div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8fafc; border-radius: 12px;">
                    <span style="font-size: 20px;">📅</span>
                    <div style="font-size: 14px;">عضو منذ: <?= date('Y/m/d', strtotime($user['created_at'])) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
