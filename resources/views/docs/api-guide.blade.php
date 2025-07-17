<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loyalty System API Integration Guide</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        h2 {
            color: #2980b9;
            margin-top: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        h3 {
            color: #34495e;
            margin-top: 25px;
        }
        .section {
            margin-bottom: 40px;
        }
        code {
            background: #f8f9fa;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: monospace;
        }
        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .note {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #f8f9fa;
        }
        .endpoint {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .method {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }
        .get { background: #17a2b8; }
        .post { background: #28a745; }
        .put { background: #ffc107; }
        .delete { background: #dc3545; }
        .parameter-table {
            width: 100%;
            margin: 10px 0;
        }
        .parameter-table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .required {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Loyalty System API Integration Guide</h1>
        <p>Version 1.0</p>
    </div>

    <div class="section">
        <h2>1. Introduction</h2>
        <p>
            Welcome to the Loyalty System API documentation. This guide provides comprehensive information about integrating
            our loyalty program into your existing systems. Our API follows RESTful principles and uses standard HTTP
            methods for all operations.
        </p>

        <h3>Base URL</h3>
        <pre><code>Production: https://api.loyaltysystem.com/v1
Test: https://api-test.loyaltysystem.com/v1</code></pre>
    </div>

    <div class="section">
        <h2>2. Authentication</h2>
        <p>
            All API requests require authentication using API keys. Include your API key in the Authorization header
            of each request.
        </p>
        <pre><code>Authorization: Bearer YOUR_API_KEY</code></pre>

        <div class="note">
            <strong>Security Note:</strong>
            <ul>
                <li>Keep your API keys secure and never share them</li>
                <li>Use test API keys for development and testing</li>
                <li>Rotate your API keys periodically for security</li>
                <li>Each API key should have a specific purpose and environment</li>
            </ul>
        </div>
    </div>

    <div class="section">
        <h2>3. Customer Management</h2>

        <h3>Register a New Customer</h3>
        <div class="endpoint">
            <span class="method post">POST</span>
            <code>/customers</code>
        </div>
        <p>Create a new customer in the loyalty program.</p>

        <h4>Request Parameters</h4>
        <table class="parameter-table">
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Required</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>name</td>
                <td>string</td>
                <td><span class="required">Yes</span></td>
                <td>Customer's full name</td>
            </tr>
            <tr>
                <td>email</td>
                <td>string</td>
                <td><span class="required">Yes</span></td>
                <td>Customer's email address</td>
            </tr>
            <tr>
                <td>phone</td>
                <td>string</td>
                <td><span class="required">Yes</span></td>
                <td>Customer's phone number</td>
            </tr>
        </table>

        <h4>Example Request</h4>
        <pre><code>{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+966501234567"
}</code></pre>

        <h4>Example Response</h4>
        <pre><code>{
    "status": "success",
    "data": {
        "customer_id": "cust_123456",
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+966501234567",
        "points_balance": 0,
        "created_at": "2024-03-20T10:00:00Z"
    }
}</code></pre>
    </div>

    <div class="section">
        <h2>4. Points Management</h2>

        <h3>Add Points</h3>
        <div class="endpoint">
            <span class="method post">POST</span>
            <code>/points/add</code>
        </div>
        <p>Add points to a customer's account.</p>

        <h4>Request Parameters</h4>
        <table class="parameter-table">
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Required</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>customer_id</td>
                <td>string</td>
                <td><span class="required">Yes</span></td>
                <td>Customer's unique identifier</td>
            </tr>
            <tr>
                <td>points</td>
                <td>integer</td>
                <td><span class="required">Yes</span></td>
                <td>Number of points to add</td>
            </tr>
            <tr>
                <td>reference_id</td>
                <td>string</td>
                <td><span class="required">Yes</span></td>
                <td>Your unique transaction reference</td>
            </tr>
            <tr>
                <td>description</td>
                <td>string</td>
                <td>No</td>
                <td>Description of the transaction</td>
            </tr>
        </table>

        <h4>Example Request</h4>
        <pre><code>{
    "customer_id": "cust_123456",
    "points": 100,
    "reference_id": "order_789",
    "description": "Purchase at Store #123"
}</code></pre>

        <h3>Get Points Balance</h3>
        <div class="endpoint">
            <span class="method get">GET</span>
            <code>/points/balance/{customer_id}</code>
        </div>
        <p>Retrieve a customer's current points balance and history.</p>

        <h4>Example Response</h4>
        <pre><code>{
    "status": "success",
    "data": {
        "customer_id": "cust_123456",
        "points_balance": 1500,
        "lifetime_points": 2000,
        "redeemed_points": 500,
        "transactions": [
            {
                "id": "txn_123",
                "type": "earn",
                "points": 100,
                "description": "Purchase at Store #123",
                "created_at": "2024-03-20T10:00:00Z"
            }
        ]
    }
}</code></pre>
    </div>

    <div class="section">
        <h2>5. Rewards Management</h2>

        <h3>List Available Rewards</h3>
        <div class="endpoint">
            <span class="method get">GET</span>
            <code>/rewards</code>
        </div>
        <p>Get a list of all available rewards.</p>

        <h3>Redeem Reward</h3>
        <div class="endpoint">
            <span class="method post">POST</span>
            <code>/rewards/redeem</code>
        </div>
        <p>Redeem points for a specific reward.</p>

        <h4>Request Parameters</h4>
        <table class="parameter-table">
            <tr>
                <th>Parameter</th>
                <th>Type</th>
                <th>Required</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>customer_id</td>
                <td>string</td>
                <td><span class="required">Yes</span></td>
                <td>Customer's unique identifier</td>
            </tr>
            <tr>
                <td>reward_id</td>
                <td>string</td>
                <td><span class="required">Yes</span></td>
                <td>Reward's unique identifier</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>6. Webhooks</h2>
        <p>
            Webhooks allow you to receive real-time notifications when specific events occur in the loyalty system.
        </p>

        <h3>Available Events</h3>
        <table class="parameter-table">
            <tr>
                <th>Event</th>
                <th>Description</th>
                <th>Payload Example</th>
            </tr>
            <tr>
                <td>customer.created</td>
                <td>Triggered when a new customer is registered</td>
                <td><pre><code>{
    "event": "customer.created",
    "customer_id": "cust_123456",
    "created_at": "2024-03-20T10:00:00Z"
}</code></pre></td>
            </tr>
            <tr>
                <td>points.added</td>
                <td>Triggered when points are added to a customer</td>
                <td><pre><code>{
    "event": "points.added",
    "customer_id": "cust_123456",
    "points": 100,
    "balance": 1500,
    "reference_id": "order_789"
}</code></pre></td>
            </tr>
            <tr>
                <td>reward.redeemed</td>
                <td>Triggered when a reward is redeemed</td>
                <td><pre><code>{
    "event": "reward.redeemed",
    "customer_id": "cust_123456",
    "reward_id": "reward_789",
    "points_used": 500
}</code></pre></td>
            </tr>
        </table>

        <h3>Webhook Security</h3>
        <p>
            All webhook requests include a signature header for verification. Verify this signature to ensure the
            webhook came from our system.
        </p>
        <pre><code>X-Webhook-Signature: sha256=...</code></pre>
    </div>

    <div class="section">
        <h2>7. Error Handling</h2>
        <p>
            The API uses standard HTTP response codes and returns detailed error messages in JSON format.
        </p>

        <h3>Common Error Codes</h3>
        <table class="parameter-table">
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Example</th>
            </tr>
            <tr>
                <td>400</td>
                <td>Bad Request - Invalid parameters</td>
                <td><pre><code>{
    "error": "validation_error",
    "message": "Invalid parameters",
    "details": {
        "points": "Must be a positive number"
    }
}</code></pre></td>
            </tr>
            <tr>
                <td>401</td>
                <td>Unauthorized - Invalid API key</td>
                <td><pre><code>{
    "error": "unauthorized",
    "message": "Invalid API key"
}</code></pre></td>
            </tr>
            <tr>
                <td>404</td>
                <td>Not Found - Resource doesn't exist</td>
                <td><pre><code>{
    "error": "not_found",
    "message": "Customer not found"
}</code></pre></td>
            </tr>
            <tr>
                <td>429</td>
                <td>Too Many Requests - Rate limit exceeded</td>
                <td><pre><code>{
    "error": "rate_limit_exceeded",
    "message": "Too many requests"
}</code></pre></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>8. Code Examples</h2>

        <h3>PHP Example</h3>
        <pre><code>// Using Guzzle HTTP client
$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://api.loyaltysystem.com/v1',
    'headers' => [
        'Authorization' => 'Bearer ' . YOUR_API_KEY,
        'Accept' => 'application/json',
    ]
]);

// Add points to customer
try {
    $response = $client->post('/points/add', [
        'json' => [
            'customer_id' => 'cust_123456',
            'points' => 100,
            'reference_id' => 'order_789',
            'description' => 'Purchase at Store #123'
        ]
    ]);

    $data = json_decode($response->getBody(), true);
    // Handle success
} catch (\GuzzleHttp\Exception\RequestException $e) {
    // Handle error
}</code></pre>

        <h3>Node.js Example</h3>
        <pre><code>const axios = require('axios');

const client = axios.create({
    baseURL: 'https://api.loyaltysystem.com/v1',
    headers: {
        'Authorization': `Bearer ${YOUR_API_KEY}`,
        'Accept': 'application/json'
    }
});

// Add points to customer
async function addPoints() {
    try {
        const response = await client.post('/points/add', {
            customer_id: 'cust_123456',
            points: 100,
            reference_id: 'order_789',
            description: 'Purchase at Store #123'
        });

        console.log(response.data);
    } catch (error) {
        console.error(error.response.data);
    }
}</code></pre>

        <h3>Python Example</h3>
        <pre><code>import requests

API_KEY = 'your_api_key'
BASE_URL = 'https://api.loyaltysystem.com/v1'

headers = {
    'Authorization': f'Bearer {API_KEY}',
    'Accept': 'application/json'
}

# Add points to customer
def add_points():
    data = {
        'customer_id': 'cust_123456',
        'points': 100,
        'reference_id': 'order_789',
        'description': 'Purchase at Store #123'
    }

    response = requests.post(
        f'{BASE_URL}/points/add',
        json=data,
        headers=headers
    )

    return response.json()</code></pre>
    </div>

    <div class="section">
        <h2>9. Rate Limits</h2>
        <p>
            To ensure system stability, the API has rate limits:
        </p>
        <table class="parameter-table">
            <tr>
                <th>Plan</th>
                <th>Rate Limit</th>
                <th>Burst Limit</th>
            </tr>
            <tr>
                <td>Standard</td>
                <td>100 requests/minute</td>
                <td>150 requests/minute</td>
            </tr>
            <tr>
                <td>Premium</td>
                <td>500 requests/minute</td>
                <td>750 requests/minute</td>
            </tr>
        </table>
        <p>Rate limit headers are included in all responses:</p>
        <pre><code>X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1616239022</code></pre>
    </div>

    <div class="section">
        <h2>10. Support</h2>
        <p>
            If you need assistance or have questions:
        </p>
        <ul>
            <li>Technical Support: support@loyaltysystem.com</li>
            <li>API Status: <a href="https://status.loyaltysystem.com">status.loyaltysystem.com</a></li>
            <li>Support Hours: 24/7</li>
        </ul>
    </div>
</body>
</html>
