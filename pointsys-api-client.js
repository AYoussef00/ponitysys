/**
 * PointSys API Client
 * مكتبة للتواصل مع نظام PointSys لإدارة النقاط والولاء
 *
 * الاستخدام:
 * const pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');
 */

class PointSysAPI {
    constructor(apiKey, baseURL = 'https://pointsys.clarastars.com/api/v1') {
        this.apiKey = apiKey;
        this.baseURL = baseURL;
        this.headers = {
            'Authorization': `Bearer ${apiKey}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
    }

    /**
     * تسجيل عميل جديد
     * @param {Object} customerData - بيانات العميل
     * @param {string} customerData.name - اسم العميل
     * @param {string} customerData.email - البريد الإلكتروني
     * @param {string} customerData.phone - رقم الهاتف
     * @returns {Promise<Object>} نتيجة التسجيل
     */
    async registerCustomer(customerData) {
        try {
            const response = await fetch(`${this.baseURL}/customers/register`, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify(customerData)
            });

            const result = await response.json();

            if (response.ok) {
                console.log('✅ تم تسجيل العميل بنجاح:', result);
                return result;
            } else {
                console.error('❌ خطأ في تسجيل العميل:', result);
                throw new Error(result.message || 'خطأ في تسجيل العميل');
            }
        } catch (error) {
            console.error('❌ خطأ في الاتصال:', error);
            throw error;
        }
    }

    /**
     * إضافة نقاط للعميل
     * @param {number} customerId - معرف العميل
     * @param {number} points - عدد النقاط
     * @param {string} description - وصف العملية
     * @param {string} referenceId - معرف مرجعي (اختياري)
     * @returns {Promise<Object>} نتيجة إضافة النقاط
     */
    async addPoints(customerId, points, description, referenceId = null) {
        try {
            const data = {
                customer_id: customerId,
                points: points,
                description: description
            };

            if (referenceId) {
                data.reference_id = referenceId;
            }

            const response = await fetch(`${this.baseURL}/customers/points/add`, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                console.log('✅ تم إضافة النقاط بنجاح:', result);
                return result;
            } else {
                console.error('❌ خطأ في إضافة النقاط:', result);
                throw new Error(result.message || 'خطأ في إضافة النقاط');
            }
        } catch (error) {
            console.error('❌ خطأ في الاتصال:', error);
            throw error;
        }
    }

    /**
     * استعلام رصيد العميل
     * @param {number} customerId - معرف العميل
     * @returns {Promise<Object>} رصيد العميل
     */
    async getCustomerBalance(customerId) {
        try {
            const response = await fetch(`${this.baseURL}/customers/${customerId}/balance`, {
                method: 'GET',
                headers: this.headers
            });

            const result = await response.json();

            if (response.ok) {
                console.log('✅ تم جلب رصيد العميل:', result);
                return result;
            } else {
                console.error('❌ خطأ في استعلام الرصيد:', result);
                throw new Error(result.message || 'خطأ في استعلام الرصيد');
            }
        } catch (error) {
            console.error('❌ خطأ في الاتصال:', error);
            throw error;
        }
    }

    /**
     * عرض المكافآت المتاحة
     * @returns {Promise<Object>} قائمة المكافآت
     */
    async getRewards() {
        try {
            const response = await fetch(`${this.baseURL}/rewards`, {
                method: 'GET',
                headers: this.headers
            });

            const result = await response.json();

            if (response.ok) {
                console.log('✅ تم جلب المكافآت:', result);
                return result;
            } else {
                console.error('❌ خطأ في جلب المكافآت:', result);
                throw new Error(result.message || 'خطأ في جلب المكافآت');
            }
        } catch (error) {
            console.error('❌ خطأ في الاتصال:', error);
            throw error;
        }
    }

    /**
     * استبدال مكافأة
     * @param {number} customerId - معرف العميل
     * @param {number} rewardId - معرف المكافأة
     * @returns {Promise<Object>} نتيجة الاستبدال
     */
    async redeemReward(customerId, rewardId) {
        try {
            const response = await fetch(`${this.baseURL}/rewards/redeem`, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({
                    customer_id: customerId,
                    reward_id: rewardId
                })
            });

            const result = await response.json();

            if (response.ok) {
                console.log('✅ تم استبدال المكافأة بنجاح:', result);
                return result;
            } else {
                console.error('❌ خطأ في استبدال المكافأة:', result);
                throw new Error(result.message || 'خطأ في استبدال المكافأة');
            }
        } catch (error) {
            console.error('❌ خطأ في الاتصال:', error);
            throw error;
        }
    }

    /**
     * استبدال نقاط
     * @param {number} customerId - معرف العميل
     * @param {number} points - عدد النقاط المراد استبدالها
     * @param {string} description - وصف العملية
     * @returns {Promise<Object>} نتيجة الاستبدال
     */
    async redeemPoints(customerId, points, description) {
        try {
            const response = await fetch(`${this.baseURL}/customers/points/redeem`, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({
                    customer_id: customerId,
                    points: points,
                    description: description
                })
            });

            const result = await response.json();

            if (response.ok) {
                console.log('✅ تم استبدال النقاط بنجاح:', result);
                return result;
            } else {
                console.error('❌ خطأ في استبدال النقاط:', result);
                throw new Error(result.message || 'خطأ في استبدال النقاط');
            }
        } catch (error) {
            console.error('❌ خطأ في الاتصال:', error);
            throw error;
        }
    }

    /**
     * اختبار الاتصال
     * @returns {Promise<boolean>} نجح الاتصال أم لا
     */
    async testConnection() {
        try {
            const response = await fetch(`${this.baseURL}/rewards`, {
                method: 'GET',
                headers: this.headers
            });

            if (response.ok) {
                console.log('✅ الاتصال بنظام PointSys يعمل بشكل صحيح');
                return true;
            } else {
                console.error('❌ فشل في الاتصال بنظام PointSys');
                return false;
            }
        } catch (error) {
            console.error('❌ خطأ في الاتصال:', error);
            return false;
        }
    }
}

// أمثلة على الاستخدام
if (typeof window !== 'undefined') {
    // في المتصفح
    window.PointSysAPI = PointSysAPI;

    // مثال على الاستخدام
    const pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');

    // اختبار الاتصال
    pointsys.testConnection();

    // تسجيل عميل جديد
    /*
    pointsys.registerCustomer({
        name: 'أحمد محمد',
        email: 'ahmed@example.com',
        phone: '966500000001'
    }).then(result => {
        console.log('تم تسجيل العميل:', result);
    }).catch(error => {
        console.error('خطأ:', error);
    });
    */

    // إضافة نقاط
    /*
    pointsys.addPoints(1, 100, 'إيجار سيارة فاخرة', 'RENT_12345')
        .then(result => {
            console.log('تم إضافة النقاط:', result);
        })
        .catch(error => {
            console.error('خطأ:', error);
        });
    */

    // جلب رصيد العميل
    /*
    pointsys.getCustomerBalance(1)
        .then(result => {
            console.log('رصيد العميل:', result);
        })
        .catch(error => {
            console.error('خطأ:', error);
        });
    */
}

// في Node.js
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PointSysAPI;
}

// أمثلة على الاستخدام في Node.js
/*
const PointSysAPI = require('./pointsys-api-client.js');

const pointsys = new PointSysAPI('lux_M01oRXyMzqM3tPDtN4ELFNQ50lRLY25a');

// تسجيل عميل جديد
async function registerNewCustomer() {
    try {
        const result = await pointsys.registerCustomer({
            name: 'أحمد محمد',
            email: 'ahmed@example.com',
            phone: '966500000001'
        });
        console.log('تم تسجيل العميل:', result);
        return result;
    } catch (error) {
        console.error('خطأ:', error);
    }
}

// إضافة نقاط عند إتمام عملية إيجار
async function addRentalPoints(customerId, amount, days, carType) {
    try {
        const points = Math.floor(amount); // 1 ريال = 1 نقطة
        const result = await pointsys.addPoints(
            customerId,
            points,
            `إيجار سيارة ${carType} لمدة ${days} أيام`,
            `RENT_${Date.now()}`
        );
        console.log(`تم إضافة ${points} نقطة للعميل`);
        return result;
    } catch (error) {
        console.error('خطأ:', error);
    }
}

// عرض رصيد العميل
async function showCustomerBalance(customerId) {
    try {
        const result = await pointsys.getCustomerBalance(customerId);
        console.log(`رصيد العميل: ${result.data.points_balance} نقطة`);
        console.log(`مستوى العميل: ${result.data.tier}`);
        return result;
    } catch (error) {
        console.error('خطأ:', error);
    }
}
*/
