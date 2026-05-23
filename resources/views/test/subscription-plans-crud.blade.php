<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans CRUD Test</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        button.danger {
            background-color: #dc3545;
        }
        button.danger:hover {
            background-color: #c82333;
        }
        button.success {
            background-color: #28a745;
        }
        button.success:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-inactive {
            color: red;
            font-weight: bold;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Subscription Plans CRUD Test Interface</h1>
        <p>This interface allows you to test all CRUD operations for subscription plans.</p>
        
        <div id="message"></div>
        
        <h2>📋 Current Plans</h2>
        <button onclick="loadPlans()">🔄 Refresh Plans</button>
        <div id="plans-container">
            <p>Loading plans...</p>
        </div>
    </div>

    <div class="container">
        <h2>➕ Create New Plan</h2>
        <form id="create-form">
            <div class="form-group">
                <label for="name">Plan Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="monthly_price">Monthly Price:</label>
                <input type="number" id="monthly_price" name="monthly_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="yearly_price">Yearly Price:</label>
                <input type="number" id="yearly_price" name="yearly_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="currency">Currency:</label>
                <select id="currency" name="currency" required>
                    <option value="KES">KES</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </select>
            </div>
            <div class="form-group">
                <label for="property_listings">Property Listings:</label>
                <input type="number" id="property_listings" name="property_listings" min="0" required>
            </div>
            <div class="form-group">
                <label for="featured_listings">Featured Listings:</label>
                <input type="number" id="featured_listings" name="featured_listings" min="0" required>
            </div>
            <button type="submit" class="success">✅ Create Plan</button>
        </form>
    </div>

    <div class="container">
        <h2>✏️ Edit Plan</h2>
        <form id="edit-form" class="hidden">
            <input type="hidden" id="edit_id" name="id">
            <div class="form-group">
                <label for="edit_name">Plan Name:</label>
                <input type="text" id="edit_name" name="name" required>
            </div>
            <div class="form-group">
                <label for="edit_description">Description:</label>
                <textarea id="edit_description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="edit_monthly_price">Monthly Price:</label>
                <input type="number" id="edit_monthly_price" name="monthly_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="edit_yearly_price">Yearly Price:</label>
                <input type="number" id="edit_yearly_price" name="yearly_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="edit_currency">Currency:</label>
                <select id="edit_currency" name="currency" required>
                    <option value="KES">KES</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit_property_listings">Property Listings:</label>
                <input type="number" id="edit_property_listings" name="property_listings" min="0" required>
            </div>
            <div class="form-group">
                <label for="edit_featured_listings">Featured Listings:</label>
                <input type="number" id="edit_featured_listings" name="featured_listings" min="0" required>
            </div>
            <button type="submit" class="success">✅ Update Plan</button>
            <button type="button" onclick="cancelEdit()">❌ Cancel</button>
        </form>
    </div>

    <script>
        // Load plans on page load
        window.onload = function() {
            loadPlans();
        };

        // Load all plans
        function loadPlans() {
            fetch('/test/subscription-plans')
                .then(response => response.json())
                .then(data => {
                    displayPlans(data.plans);
                })
                .catch(error => {
                    showMessage('Error loading plans: ' + error.message, 'error');
                });
        }

        // Display plans in table
        function displayPlans(plans) {
            const container = document.getElementById('plans-container');
            
            if (plans.length === 0) {
                container.innerHTML = '<p>No plans found.</p>';
                return;
            }

            let html = `
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Monthly Price</th>
                            <th>Yearly Price</th>
                            <th>Currency</th>
                            <th>Property Listings</th>
                            <th>Featured Listings</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            plans.forEach(plan => {
                html += `
                    <tr>
                        <td>${plan.id}</td>
                        <td>${plan.name}</td>
                        <td>${plan.description}</td>
                        <td>${plan.monthly_price}</td>
                        <td>${plan.yearly_price}</td>
                        <td>${plan.currency}</td>
                        <td>${plan.property_listings}</td>
                        <td>${plan.featured_listings}</td>
                        <td class="${plan.is_active ? 'status-active' : 'status-inactive'}">
                            ${plan.is_active ? 'Active' : 'Inactive'}
                        </td>
                        <td>
                            <button onclick="editPlan(${plan.id})" class="success">✏️ Edit</button>
                            <button onclick="toggleStatus(${plan.id})" class="${plan.is_active ? 'danger' : 'success'}">
                                ${plan.is_active ? '⏸️ Deactivate' : '▶️ Activate'}
                            </button>
                            <button onclick="deletePlan(${plan.id})" class="danger">🗑️ Delete</button>
                        </td>
                    </tr>
                `;
            });

            html += '</tbody></table>';
            container.innerHTML = html;
        }

        // Create new plan
        document.getElementById('create-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            fetch('/test/subscription-plans', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, 'success');
                loadPlans();
                this.reset();
            })
            .catch(error => {
                showMessage('Error creating plan: ' + error.message, 'error');
            });
        });

        // Edit plan
        function editPlan(id) {
            fetch('/test/subscription-plans')
                .then(response => response.json())
                .then(data => {
                    const plan = data.plans.find(p => p.id === id);
                    if (plan) {
                        document.getElementById('edit_id').value = plan.id;
                        document.getElementById('edit_name').value = plan.name;
                        document.getElementById('edit_description').value = plan.description;
                        document.getElementById('edit_monthly_price').value = plan.monthly_price;
                        document.getElementById('edit_yearly_price').value = plan.yearly_price;
                        document.getElementById('edit_currency').value = plan.currency;
                        document.getElementById('edit_property_listings').value = plan.property_listings;
                        document.getElementById('edit_featured_listings').value = plan.featured_listings;
                        
                        document.getElementById('edit-form').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    showMessage('Error loading plan: ' + error.message, 'error');
                });
        }

        // Update plan
        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            const id = data.id;
            delete data.id;
            
            fetch(`/test/subscription-plans/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, 'success');
                loadPlans();
                cancelEdit();
            })
            .catch(error => {
                showMessage('Error updating plan: ' + error.message, 'error');
            });
        });

        // Cancel edit
        function cancelEdit() {
            document.getElementById('edit-form').classList.add('hidden');
            document.getElementById('edit-form').reset();
        }

        // Toggle plan status
        function toggleStatus(id) {
            fetch(`/test/subscription-plans/${id}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, 'success');
                loadPlans();
            })
            .catch(error => {
                showMessage('Error toggling status: ' + error.message, 'error');
            });
        }

        // Delete plan
        function deletePlan(id) {
            if (confirm('Are you sure you want to delete this plan?')) {
                fetch(`/test/subscription-plans/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        showMessage(data.error, 'error');
                    } else {
                        showMessage(data.message, 'success');
                        loadPlans();
                    }
                })
                .catch(error => {
                    showMessage('Error deleting plan: ' + error.message, 'error');
                });
            }
        }

        // Show message
        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.innerHTML = `<div class="message ${type}">${message}</div>`;
            setTimeout(() => {
                messageDiv.innerHTML = '';
            }, 5000);
        }
    </script>
</body>
</html>
