<?php

/**
 * PointSys API Client - PHP
 * مكتبة للتواصل مع نظام PointSys لإدارة النقاط والولاء
 *
 * الاستخدام:
 * $pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');
 */

class PointSysAPI {
    private $apiKey;
    private $baseURL;
    private $headers;

    public function __construct($apiKey, $baseURL = 'http://127.0.0.1:8001/api/v1') {
        $this->apiKey = $apiKey;
        $this->baseURL = $baseURL;
        $this->headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ];
    }

    /**
     * إرسال طلب HTTP
     * @param string $url
     * @param string $method
     * @param array $data
     * @return array
     */
    private function makeRequest($url, $method = 'GET', $data = null) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception('خطأ في الاتصال: ' . $error);
        }

        $result = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300) {
            return [
                'success' => true,
                'data' => $result,
                'http_code' => $httpCode
            ];
        } else {
            return [
                'success' => false,
                'error' => $result['message'] ?? 'خطأ غير معروف',
                'data' => $result,
                'http_code' => $httpCode
            ];
        }
    }

    /**
     * تسجيل عميل جديد
     * @param array $customerData
     * @return array
     */
    public function registerCustomer($customerData) {
        try {
            $url = $this->baseURL . '/customers/register';
            $result = $this->makeRequest($url, 'POST', $customerData);

            if ($result['success']) {
                echo "✅ تم تسجيل العميل بنجاح\n";
                return $result['data'];
            } else {
                echo "❌ خطأ في تسجيل العميل: " . $result['error'] . "\n";
                throw new Exception($result['error']);
            }
        } catch (Exception $e) {
            echo "❌ خطأ في الاتصال: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * إضافة نقاط للعميل
     * @param int $customerId
     * @param int $points
     * @param string $description
     * @param string $referenceId
     * @return array
     */
    public function addPoints($customerId, $points, $description, $referenceId = null) {
        try {
            $data = [
                'customer_id' => $customerId,
                'points' => $points,
                'description' => $description
            ];

            if ($referenceId) {
                $data['reference_id'] = $referenceId;
            }

            $url = $this->baseURL . '/customers/points/add';
            $result = $this->makeRequest($url, 'POST', $data);

            if ($result['success']) {
                echo "✅ تم إضافة النقاط بنجاح\n";
                return $result['data'];
            } else {
                echo "❌ خطأ في إضافة النقاط: " . $result['error'] . "\n";
                throw new Exception($result['error']);
            }
        } catch (Exception $e) {
            echo "❌ خطأ في الاتصال: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * استعلام رصيد العميل
     * @param int $customerId
     * @return array
     */
    public function getCustomerBalance($customerId) {
        try {
            $url = $this->baseURL . '/customers/' . $customerId . '/balance';
            $result = $this->makeRequest($url, 'GET');

            if ($result['success']) {
                echo "✅ تم جلب رصيد العميل\n";
                return $result['data'];
            } else {
                echo "❌ خطأ في استعلام الرصيد: " . $result['error'] . "\n";
                throw new Exception($result['error']);
            }
        } catch (Exception $e) {
            echo "❌ خطأ في الاتصال: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * عرض المكافآت المتاحة
     * @return array
     */
    public function getRewards() {
        try {
            $url = $this->baseURL . '/rewards';
            $result = $this->makeRequest($url, 'GET');

            if ($result['success']) {
                echo "✅ تم جلب المكافآت\n";
                return $result['data'];
            } else {
                echo "❌ خطأ في جلب المكافآت: " . $result['error'] . "\n";
                throw new Exception($result['error']);
            }
        } catch (Exception $e) {
            echo "❌ خطأ في الاتصال: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * استبدال مكافأة
     * @param int $customerId
     * @param int $rewardId
     * @return array
     */
    public function redeemReward($customerId, $rewardId) {
        try {
            $data = [
                'customer_id' => $customerId,
                'reward_id' => $rewardId
            ];

            $url = $this->baseURL . '/rewards/redeem';
            $result = $this->makeRequest($url, 'POST', $data);

            if ($result['success']) {
                echo "✅ تم استبدال المكافأة بنجاح\n";
                return $result['data'];
            } else {
                echo "❌ خطأ في استبدال المكافأة: " . $result['error'] . "\n";
                throw new Exception($result['error']);
            }
        } catch (Exception $e) {
            echo "❌ خطأ في الاتصال: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * استبدال نقاط
     * @param int $customerId
     * @param int $points
     * @param string $description
     * @return array
     */
    public function redeemPoints($customerId, $points, $description) {
        try {
            $data = [
                'customer_id' => $customerId,
                'points' => $points,
                'description' => $description
            ];

            $url = $this->baseURL . '/customers/points/redeem';
            $result = $this->makeRequest($url, 'POST', $data);

            if ($result['success']) {
                echo "✅ تم استبدال النقاط بنجاح\n";
                return $result['data'];
            } else {
                echo "❌ خطأ في استبدال النقاط: " . $result['error'] . "\n";
                throw new Exception($result['error']);
            }
        } catch (Exception $e) {
            echo "❌ خطأ في الاتصال: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    /**
     * اختبار الاتصال
     * @return bool
     */
    public function testConnection() {
        try {
            $url = $this->baseURL . '/rewards';
            $result = $this->makeRequest($url, 'GET');

            if ($result['success']) {
                echo "✅ الاتصال بنظام PointSys يعمل بشكل صحيح\n";
                return true;
            } else {
                echo "❌ فشل في الاتصال بنظام PointSys\n";
                return false;
            }
        } catch (Exception $e) {
            echo "❌ خطأ في الاتصال: " . $e->getMessage() . "\n";
            return false;
        }
    }
}

// أمثلة على الاستخدام
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    // تشغيل الأمثلة إذا تم تشغيل الملف مباشرة

    $pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');

    echo "=== اختبار الاتصال ===\n";
    $pointsys->testConnection();

    echo "\n=== تسجيل عميل جديد ===\n";
    try {
        $customer = $pointsys->registerCustomer([
            'name' => 'أحمد محمد',
            'email' => 'ahmed_new_test_' . time() . '@example.com',
            'phone' => '966500000' . time()
        ]);
        echo "تم تسجيل العميل: " . $customer['data']['customer_id'] . "\n";

        $customerId = $customer['data']['customer_id'];

        echo "\n=== إضافة نقاط ===\n";
        $result = $pointsys->addPoints($customerId, 100, 'إيجار سيارة فاخرة', 'RENT_' . time());
        echo "تم إضافة النقاط: " . $result['data']['points_added'] . "\n";

        echo "\n=== استعلام الرصيد ===\n";
        $balance = $pointsys->getCustomerBalance($customerId);
        echo "رصيد العميل: " . $balance['data']['points_balance'] . " نقطة\n";
        echo "مستوى العميل: " . $balance['data']['tier'] . "\n";

        echo "\n=== عرض المكافآت ===\n";
        $rewards = $pointsys->getRewards();
        echo "عدد المكافآت المتاحة: " . count($rewards['data']) . "\n";

    } catch (Exception $e) {
        echo "خطأ: " . $e->getMessage() . "\n";
    }
}

// أمثلة على الاستخدام في التطبيق
/*
// 1. تسجيل مستخدم جديد عند التسجيل في التطبيق
function registerNewUser($userData) {
    $pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');

    try {
        // تسجيل المستخدم في قاعدة البيانات المحلية
        $localUserId = saveUserToLocalDB($userData);

        // تسجيل المستخدم في نظام النقاط
        $pointsUser = $pointsys->registerCustomer([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone' => $userData['phone']
        ]);

        // حفظ customer_id في قاعدة البيانات المحلية
        updateUserWithPointsId($localUserId, $pointsUser['data']['customer_id']);

        echo "تم تسجيل المستخدم في نظام النقاط بنجاح\n";
        return $pointsUser['data']['customer_id'];

    } catch (Exception $e) {
        echo "فشل في تسجيل المستخدم في نظام النقاط: " . $e->getMessage() . "\n";
        // يمكن الاستمرار بدون نظام النقاط
        return null;
    }
}

// 2. إضافة نقاط عند إتمام عملية إيجار
function addRentalPoints($customerId, $amount, $days, $carType) {
    $pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');

    try {
        $points = floor($amount); // 1 ريال = 1 نقطة
        $result = $pointsys->addPoints(
            $customerId,
            $points,
            "إيجار سيارة {$carType} لمدة {$days} أيام",
            'RENT_' . time()
        );

        echo "تم إضافة {$points} نقطة للعميل\n";
        return $result;

    } catch (Exception $e) {
        echo "فشل في إضافة النقاط: " . $e->getMessage() . "\n";
        return null;
    }
}

// 3. عرض رصيد العميل في الملف الشخصي
function showCustomerProfile($customerId) {
    $pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');

    try {
        $balance = $pointsys->getCustomerBalance($customerId);

        echo "رصيد النقاط: " . $balance['data']['points_balance'] . " نقطة\n";
        echo "مستوى العميل: " . $balance['data']['tier'] . "\n";
        echo "إجمالي النقاط المكتسبة: " . $balance['data']['total_earned'] . "\n";
        echo "إجمالي النقاط المستبدلة: " . $balance['data']['total_redeemed'] . "\n";

        return $balance['data'];

    } catch (Exception $e) {
        echo "فشل في جلب رصيد النقاط: " . $e->getMessage() . "\n";
        return null;
    }
}

// 4. عرض المكافآت المتاحة
function showAvailableRewards() {
    $pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');

    try {
        $rewards = $pointsys->getRewards();

        echo "المكافآت المتاحة:\n";
        foreach ($rewards['data'] as $reward) {
            echo "- " . $reward['title'] . " (" . $reward['points_required'] . " نقطة)\n";
            echo "  " . $reward['description'] . "\n";
        }

        return $rewards['data'];

    } catch (Exception $e) {
        echo "فشل في جلب المكافآت: " . $e->getMessage() . "\n";
        return null;
    }
}

// 5. استبدال مكافأة
function redeemCustomerReward($customerId, $rewardId) {
    $pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');

    try {
        $result = $pointsys->redeemReward($customerId, $rewardId);

        echo "تم استبدال المكافأة بنجاح\n";
        echo "النقاط المخصومة: " . $result['data']['points_deducted'] . "\n";
        echo "الرصيد الجديد: " . $result['data']['new_balance'] . "\n";

        return $result['data'];

    } catch (Exception $e) {
        echo "فشل في استبدال المكافأة: " . $e->getMessage() . "\n";
        return null;
    }
}
*/
?>
