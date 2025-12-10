<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;

/**
 * Subscription Controller
 */
class SubscriptionController extends Controller
{
    private SubscriptionPlan $planModel;
    private UserSubscription $subscriptionModel;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->planModel = new SubscriptionPlan($config);
        $this->subscriptionModel = new UserSubscription($config);
    }

    /**
     * Show available plans
     */
    public function plans(): void
    {
        $this->requireAuth();
        
        $user = $this->auth->user();
        $userType = $user['type'];
        
        // Get active subscription
        $activeSubscription = $this->subscriptionModel->getActiveSubscription($user['id']);
        
        // Get available plans
        $plans = $this->planModel->findActiveByType($userType);
        
        // Decode features for each plan
        foreach ($plans as &$plan) {
            $plan['features_array'] = $this->planModel->getFeaturesArray($plan);
        }
        
        $this->render('subscriptions/plans', [
            'plans' => $plans,
            'activeSubscription' => $activeSubscription,
            'userType' => $userType
        ], 'dashboard');
    }

    /**
     * Subscribe to a plan
     */
    public function subscribe(): void
    {
        $this->requireAuth();
        $this->validateCsrfToken();
        
        $user = $this->auth->user();
        $planId = (int) ($_POST['plan_id'] ?? 0);
        
        // Get plan
        $plan = $this->planModel->findById($planId);
        
        if (!$plan || !$plan['is_active']) {
            $this->setFlash('error', 'الخطة المحددة غير متوفرة');
            $this->redirect('/subscriptions/plans');
            return;
        }
        
        // Verify plan matches user type
        if ($plan['user_type'] !== $user['type']) {
            $this->setFlash('error', 'هذه الخطة غير متاحة لنوع حسابك');
            $this->redirect('/subscriptions/plans');
            return;
        }
        
        // Check if user already has active subscription
        if ($this->subscriptionModel->hasActiveSubscription($user['id'])) {
            $this->setFlash('error', 'لديك اشتراك نشط بالفعل');
            $this->redirect('/subscriptions/my-subscription');
            return;
        }
        
        // Create subscription
        $subscriptionId = $this->subscriptionModel->createSubscription(
            $user['id'],
            $planId,
            (int) $plan['duration_months']
        );
        
        if (!$subscriptionId) {
            $this->setFlash('error', 'حدث خطأ أثناء إنشاء الاشتراك');
            $this->redirect('/subscriptions/plans');
            return;
        }
        
        // Redirect to payment page
        $this->redirect("/subscriptions/payment/{$subscriptionId}");
    }

    /**
     * Show payment page
     */
    public function payment(int $subscriptionId): void
    {
        $this->requireAuth();
        
        $user = $this->auth->user();
        
        // Get subscription
        $subscription = $this->subscriptionModel->findById($subscriptionId);
        
        if (!$subscription || $subscription['user_id'] !== $user['id']) {
            $this->setFlash('error', 'الاشتراك غير موجود');
            $this->redirect('/subscriptions/plans');
            return;
        }
        
        // Get plan details
        $plan = $this->planModel->findById($subscription['plan_id']);
        
        $this->render('subscriptions/payment', [
            'subscription' => $subscription,
            'plan' => $plan
        ], 'dashboard');
    }

    /**
     * Confirm payment
     */
    public function confirmPayment(): void
    {
        $this->requireAuth();
        $this->validateCsrfToken();
        
        $user = $this->auth->user();
        $subscriptionId = (int) ($_POST['subscription_id'] ?? 0);
        
        // Get subscription
        $subscription = $this->subscriptionModel->findById($subscriptionId);
        
        if (!$subscription || $subscription['user_id'] !== $user['id']) {
            $this->setFlash('error', 'الاشتراك غير موجود');
            $this->redirect('/subscriptions/plans');
            return;
        }
        
        // Get plan
        $plan = $this->planModel->findById($subscription['plan_id']);
        
        // Activate subscription (in real app, verify payment first)
        $paymentData = [
            'method' => $_POST['payment_method'] ?? 'manual',
            'reference' => $_POST['payment_reference'] ?? null,
            'amount' => $plan['price']
        ];
        
        $success = $this->subscriptionModel->activateSubscription($subscriptionId, $paymentData);
        
        if ($success) {
            $this->setFlash('success', 'تم تفعيل الاشتراك بنجاح');
            $this->redirect('/subscriptions/my-subscription');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء تفعيل الاشتراك');
            $this->redirect("/subscriptions/payment/{$subscriptionId}");
        }
    }

    /**
     * Show user's current subscription
     */
    public function mySubscription(): void
    {
        $this->requireAuth();
        
        $user = $this->auth->user();
        
        // Get active subscription
        $activeSubscription = $this->subscriptionModel->getActiveSubscription($user['id']);
        
        // Get subscription history
        $subscriptionHistory = $this->subscriptionModel->getUserSubscriptions($user['id']);
        
        $this->render('subscriptions/my-subscription', [
            'activeSubscription' => $activeSubscription,
            'subscriptionHistory' => $subscriptionHistory
        ], 'dashboard');
    }

    /**
     * Admin: List all subscriptions
     */
    public function adminList(): void
    {
        $this->requireRole('admin');
        
        $filters = [
            'status' => $_GET['status'] ?? '',
            'payment_status' => $_GET['payment_status'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];
        
        $subscriptions = $this->subscriptionModel->searchSubscriptions($filters);
        $statistics = $this->subscriptionModel->getStatistics();
        
        $this->render('admin/subscriptions/list', [
            'subscriptions' => $subscriptions,
            'statistics' => $statistics,
            'filters' => $filters
        ], 'dashboard');
    }

    /**
     * Admin: Activate subscription manually
     */
    public function adminActivate(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();
        
        $subscriptionId = (int) ($_POST['subscription_id'] ?? 0);
        
        $subscription = $this->subscriptionModel->findById($subscriptionId);
        
        if (!$subscription) {
            $this->setFlash('error', 'الاشتراك غير موجود');
            $this->redirect('/admin/subscriptions');
            return;
        }
        
        $plan = $this->planModel->findById($subscription['plan_id']);
        
        $paymentData = [
            'method' => 'admin_activation',
            'reference' => 'ADMIN-' . time(),
            'amount' => $plan['price']
        ];
        
        $success = $this->subscriptionModel->activateSubscription($subscriptionId, $paymentData);
        
        if ($success) {
            $this->setFlash('success', 'تم تفعيل الاشتراك بنجاح');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء تفعيل الاشتراك');
        }
        
        $this->redirect('/admin/subscriptions');
    }

    /**
     * Admin: Manage subscription plans
     */
    public function adminPlans(): void
    {
        $this->requireRole('admin');
        
        $plans = $this->planModel->findAll();
        
        $this->render('admin/subscriptions/plans', [
            'plans' => $plans
        ], 'dashboard');
    }

    /**
     * Admin: Create plan form
     */
    public function adminCreatePlan(): void
    {
        $this->requireRole('admin');
        
        $this->render('admin/subscriptions/create-plan', [], 'dashboard');
    }

    /**
     * Admin: Store new plan
     */
    public function adminStorePlan(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();
        
        $data = [
            'name_ar' => $_POST['name_ar'] ?? '',
            'name_en' => $_POST['name_en'] ?? '',
            'description_ar' => $_POST['description_ar'] ?? '',
            'description_en' => $_POST['description_en'] ?? '',
            'price' => (float) ($_POST['price'] ?? 0),
            'duration_months' => (int) ($_POST['duration_months'] ?? 12),
            'user_type' => $_POST['user_type'] ?? 'student',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'features' => json_encode(array_filter(explode("\n", $_POST['features'] ?? ''))),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $planId = $this->planModel->create($data);
        
        if ($planId) {
            $this->setFlash('success', 'تم إضافة الخطة بنجاح');
            $this->redirect('/admin/subscriptions/plans');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء إضافة الخطة');
            $this->redirect('/admin/subscriptions/plans/create');
        }
    }

    /**
     * Admin: Edit plan form
     */
    public function adminEditPlan(int $planId): void
    {
        $this->requireRole('admin');
        
        $plan = $this->planModel->findById($planId);
        
        if (!$plan) {
            $this->setFlash('error', 'الخطة غير موجودة');
            $this->redirect('/admin/subscriptions/plans');
            return;
        }
        
        // Decode features
        $plan['features_text'] = implode("\n", $this->planModel->getFeaturesArray($plan));
        
        $this->render('admin/subscriptions/edit-plan', [
            'plan' => $plan
        ], 'dashboard');
    }

    /**
     * Admin: Update plan
     */
    public function adminUpdatePlan(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();
        
        $planId = (int) ($_POST['plan_id'] ?? 0);
        
        $plan = $this->planModel->findById($planId);
        
        if (!$plan) {
            $this->setFlash('error', 'الخطة غير موجودة');
            $this->redirect('/admin/subscriptions/plans');
            return;
        }
        
        $data = [
            'name_ar' => $_POST['name_ar'] ?? '',
            'name_en' => $_POST['name_en'] ?? '',
            'description_ar' => $_POST['description_ar'] ?? '',
            'description_en' => $_POST['description_en'] ?? '',
            'price' => (float) ($_POST['price'] ?? 0),
            'duration_months' => (int) ($_POST['duration_months'] ?? 12),
            'user_type' => $_POST['user_type'] ?? 'student',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'features' => json_encode(array_filter(explode("\n", $_POST['features'] ?? ''))),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $success = $this->planModel->update($planId, $data);
        
        if ($success) {
            $this->setFlash('success', 'تم تحديث الخطة بنجاح');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء تحديث الخطة');
        }
        
        $this->redirect('/admin/subscriptions/plans');
    }

    /**
     * Admin: Delete plan
     */
    public function adminDeletePlan(): void
    {
        $this->requireRole('admin');
        $this->validateCsrfToken();
        
        $planId = (int) ($_POST['plan_id'] ?? 0);
        
        $success = $this->planModel->delete($planId);
        
        if ($success) {
            $this->setFlash('success', 'تم حذف الخطة بنجاح');
        } else {
            $this->setFlash('error', 'حدث خطأ أثناء حذف الخطة');
        }
        
        $this->redirect('/admin/subscriptions/plans');
    }
}
