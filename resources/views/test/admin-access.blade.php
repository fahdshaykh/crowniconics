<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Subscription Plan Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .admin-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .route-list {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .route-item {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }
        .method {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 10px;
        }
        .get { background-color: #28a745; color: white; }
        .post { background-color: #007bff; color: white; }
        .put { background-color: #ffc107; color: black; }
        .patch { background-color: #17a2b8; color: white; }
        .delete { background-color: #dc3545; color: white; }
        .url {
            font-family: monospace;
            font-weight: bold;
            color: #333;
        }
        .description {
            color: #666;
            margin-top: 5px;
        }
        .steps {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .step {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 4px;
            border-left: 4px solid #ffc107;
        }
        .step-number {
            font-weight: bold;
            color: #856404;
        }
        .current-plans {
            background: #d1ecf1;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .plan-item {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 4px;
            border-left: 4px solid #17a2b8;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-inactive {
            color: red;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .button.success {
            background-color: #28a745;
        }
        .button.success:hover {
            background-color: #218838;
        }
        .button.warning {
            background-color: #ffc107;
            color: black;
        }
        .button.warning:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👨‍💼 Admin Subscription Plan Management</h1>
        
        <div class="admin-info">
            <h3>🔐 Admin Access Information</h3>
            <p><strong>Admin User:</strong> admin@example.com</p>
            <p><strong>Password:</strong> password</p>
            <p><strong>Role:</strong> admin</p>
        </div>

        <div class="steps">
            <h3>📋 How to Access Admin Interface</h3>
            <div class="step">
                <span class="step-number">Step 1:</span> Login as admin user (admin@example.com)
            </div>
            <div class="step">
                <span class="step-number">Step 2:</span> Navigate to <code>/admin/subscription-plans</code>
            </div>
            <div class="step">
                <span class="step-number">Step 3:</span> You will see the admin dashboard for managing subscription plans
            </div>
        </div>

        <div class="current-plans">
            <h3>📊 Current Subscription Plans</h3>
            <div id="plans-list">
                <p>Loading plans...</p>
            </div>
        </div>

        <div class="route-list">
            <h3>🛠️ Available Admin Routes</h3>
            
            <div class="route-item">
                <span class="method get">GET</span>
                <span class="url">/admin/subscription-plans</span>
                <div class="description">List all subscription plans in admin dashboard</div>
            </div>
            
            <div class="route-item">
                <span class="method get">GET</span>
                <span class="url">/admin/subscription-plans/create</span>
                <div class="description">Show form to create a new subscription plan</div>
            </div>
            
            <div class="route-item">
                <span class="method post">POST</span>
                <span class="url">/admin/subscription-plans</span>
                <div class="description">Store a new subscription plan</div>
            </div>
            
            <div class="route-item">
                <span class="method get">GET</span>
                <span class="url">/admin/subscription-plans/{id}</span>
                <div class="description">View details of a specific subscription plan</div>
            </div>
            
            <div class="route-item">
                <span class="method get">GET</span>
                <span class="url">/admin/subscription-plans/{id}/edit</span>
                <div class="description">Show form to edit a subscription plan</div>
            </div>
            
            <div class="route-item">
                <span class="method put">PUT</span>
                <span class="url">/admin/subscription-plans/{id}</span>
                <div class="description">Update a subscription plan</div>
            </div>
            
            <div class="route-item">
                <span class="method patch">PATCH</span>
                <span class="url">/admin/subscription-plans/{id}/toggle-status</span>
                <div class="description">Toggle plan status (active/inactive)</div>
            </div>
            
            <div class="route-item">
                <span class="method delete">DELETE</span>
                <span class="url">/admin/subscription-plans/{id}</span>
                <div class="description">Delete a subscription plan (if no active subscriptions)</div>
            </div>
        </div>

        <div class="container">
            <h3>🎯 Admin Features</h3>
            <ul>
                <li><strong>Create Plans:</strong> Add new subscription plans with pricing and features</li>
                <li><strong>Edit Plans:</strong> Modify existing plan details, pricing, and features</li>
                <li><strong>Toggle Status:</strong> Activate or deactivate plans</li>
                <li><strong>View Details:</strong> See plan information and subscription statistics</li>
                <li><strong>Delete Plans:</strong> Remove plans (only if no active subscriptions)</li>
                <li><strong>Plan Management:</strong> Full CRUD operations for subscription plans</li>
            </ul>
        </div>

        <div class="container">
            <h3>🔗 Quick Access Links</h3>
            <a href="/login" class="button">🔐 Login as Admin</a>
            <a href="/admin/subscription-plans" class="button success">📋 Admin Plans Dashboard</a>
            <a href="/admin/subscription-plans/create" class="button warning">➕ Create New Plan</a>
            <a href="/test/subscription-plans-interface" class="button">🧪 Test Interface</a>
        </div>
    </div>

    <script>
        // Load current plans
        fetch('/test/subscription-plans')
            .then(response => response.json())
            .then(data => {
                const plansList = document.getElementById('plans-list');
                let html = '';
                
                data.plans.forEach(plan => {
                    html += `
                        <div class="plan-item">
                            <strong>${plan.name}</strong> 
                            <span class="${plan.is_active ? 'status-active' : 'status-inactive'}">
                                (${plan.is_active ? 'Active' : 'Inactive'})
                            </span>
                            <br>
                            <small>
                                Monthly: ${plan.currency} ${plan.monthly_price} | 
                                Yearly: ${plan.currency} ${plan.yearly_price} | 
                                Properties: ${plan.property_listings} | 
                                Featured: ${plan.featured_listings}
                            </small>
                        </div>
                    `;
                });
                
                plansList.innerHTML = html;
            })
            .catch(error => {
                document.getElementById('plans-list').innerHTML = '<p>Error loading plans</p>';
            });
    </script>
</body>
</html>
