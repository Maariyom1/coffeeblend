@extends('layouts.admin.admin')

@section('content')
    <div class="row">
        <!-- Overview Cards -->
        @foreach ([
            ['bg-primary', 'Total Orders', $countOrders, 'fas fa-shopping-cart'],
            ['bg-success', 'Total Revenue', $totalRevenue, 'fas fa-dollar-sign'],
            ['bg-warning', 'Pending Orders', $pendingOrders, 'fas fa-clock'],
            ['bg-danger', 'Customer Feedback', 78, 'fas fa-comments'],
            ['bg-success', 'Bookings', $countBookings, 'fas fa-book'],
            ['bg-primary', 'Total Carts', $countCarts, 'fas fa-shopping-cart'],
        ] as $card)
            <div class="col-lg-3 col-md-6 mb-4"> <!-- Added mb-4 for bottom margin -->
                <div class="card {{ $card[0] }} text-white">
                    <div class="card-body">{{ $card[1] }}</div>
                    <div class="card-footer d-flex justify-content-between">
                        <span>{{ $card[2] }}</span>
                        <i class="{{ $card[3] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <!-- Pie Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Orders by Status</div>
                <div class="card-body">
                    <canvas id="ordersPieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Doughnut Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Revenue by Product Category</div>
                <div class="card-body">
                    <canvas id="revenueDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Bar Chart -->
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">Monthly Revenue</div>
                <div class="card-body">
                    <canvas id="revenueBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Recent Orders</div>
                <div class="card-body">
                    <!-- Search Input -->
                    <input type="text" id="orderSearch" class="form-control mb-3" placeholder="Search orders...">
                    <table id="ordersTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Pay Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerOrders as $index => $orders)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $orders->id }}</td>
                                    <td>{{ $orders->firstname }}</td>
                                    <td><a href="mailto:{{ $orders->email }}">{{ $orders->email }}</a></td>
                                    <td><a href="tel:{{ $orders->phone }}">{{ $orders->phone }}</a></td>
                                    <td>${{ $orders->total_price }}</td>
                                    <td>
                                        <span class="badge {{ $orders->payment_status == 'Completed' ? 'bg-success' : 'bg-primary' }}">
                                            {{ $orders->payment_status }}
                                        </span>
                                    </td>
                                    <td>{{ $orders->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary">
                        <a href="{{ route('admin.orders') }}" class="text-white">View more orders</a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Recent Bookings</div>
                <div class="card-body">
                    <!-- Search Input -->
                    <input type="text" id="bookingSearch" class="form-control mb-3" placeholder="Search bookings...">
                    <table id="bookingsTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Booking Date</th>
                                <th>Booking Time</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerBookings as $index => $bookings)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bookings->id }}</td>
                                    <td>{{ $bookings->firstname }}</td>
                                    <td><a href="tel:{{ $bookings->phone }}">{{ $bookings->phone }}</a></td>
                                    <td>{{ $bookings->message }}</td>
                                    <td>{{ $bookings->date }}</td>
                                    <td>{{ $bookings->time }}</td>
                                    <td>{{ $bookings->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary">
                        <a href="{{ route('admin.bookings') }}" class="text-white">View more bookings</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Pie Chart for Orders by Status
        var ctxPie = document.getElementById('ordersPieChart').getContext('2d');
        var ordersPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Completed', 'Pending', 'Canceled'],
                datasets: [{
                    data: [100, 25, 15], // Adjust the data
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Doughnut Chart for Revenue by Product Category
        var ctxDoughnut = document.getElementById('revenueDoughnutChart').getContext('2d');
        var revenueDoughnutChart = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Coffee', 'Tea', 'Accessories'],
                datasets: [{
                    data: [8000, 2500, 2000], // Adjust the data
                    backgroundColor: ['#007bff', '#ffc107', '#28a745'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Bar Chart for Monthly Revenue
        var ctxBar = document.getElementById('revenueBarChart').getContext('2d');
        var revenueBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Adjust the months
                datasets: [{
                    label: 'Revenue',
                    data: [1200, 1500, 1800, 2000, 2200, 2500], // Adjust the data
                    backgroundColor: '#007bff',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Search functionality for Recent Orders
        document.getElementById('orderSearch').addEventListener('input', function() {
        const searchTerm = this.value;

        fetch(`/search-orders?query=${searchTerm}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#ordersTable tbody');
                tbody.innerHTML = ''; // Clear the existing rows

                data.forEach(order => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${order.id}</td>
                        <td>${order.customer_name}</td>
                        <td>${order.product}</td>
                        <!-- Add more columns as necessary -->
                    `;
                    tbody.appendChild(row);
                });
            });
    });

        // Search functionality for Recent Bookings
        document.getElementById('bookingSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#bookingsTable tbody tr');

            rows.forEach(row => {
                const columns = row.querySelectorAll('td');
                const bookingData = Array.from(columns).map(column => column.textContent.toLowerCase());
                const matches = bookingData.some(data => data.includes(searchTerm));

                if (matches) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
