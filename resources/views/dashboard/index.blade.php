@extends('dashboard.master')
@section('title')
    الرئيسية
@endsection
@section('style')
    <style>
        /* statistics style */
        .card2 {
            border-radius: 15px;
            overflow: hidden;
            background-color: #ffffff;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;

        }

        .card2:hover {
            box-shadow: 0 4px 15px #71df0a99;
            /* Yellow light effect */
            transform: scale(1.05);
            /* Slightly enlarge the card on hover */
            color: cadetblue;

        }

        .card2 .info-box-icon2 {
            transition: transform 0.3s ease;
        }

        .card2:hover .info-box-icon2 {
            transform: scale(1.1);
            /* Slightly enlarge the icon when hovering */
        }

        .card-body2 {
            padding: 20px;
        }

        .info-box-icon2 {
            font-size: 3rem;
            color: white;
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: #17a2b8;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .card-title2 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 15px;
        }

        .stats-result {
            margin-top: 20px;
        }

        #user-count-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
        }

        #revenue-count-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
        }

        #visit-count-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
        }

        .text-muted {
            font-size: 0.9rem;
            color: #6c757d;
        }


        #custom-date-range {
            margin-top: 10px;
        }

        #start-date,
        #end-date {
            width: 48%;
            display: inline-block;
            margin-right: 4%;
        }

        #apply-custom-filter {
            margin-top: 10px;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .info-box-icon2 {
                width: 50px;
                height: 50px;
                font-size: 2rem;
            }

            .card-title2 {
                font-size: 1rem;
            }

            #user-count-number {
                font-size: 2rem;
            }

            #revenue-count-number {
                font-size: 2rem;
            }

            #visit-count-number {
                font-size: 2rem;
            }
        }

        #user-stats-filter {
            font-size: 1rem;
            width: 100%;
        }

        #revenue-stats-filter {
            font-size: 1rem;
            width: 100%;
        }

        #visit-stats-filter {
            font-size: 1rem;
            width: 100%;
        }

        #custom-date-range {
            margin-top: 10px;
        }

        #start-date,
        #end-date {
            width: 48%;
            display: inline-block;
            margin-right: 4%;
        }

        #apply-custom-filter {
            margin-top: 10px;
            width: 100%;
        }

        /* Card Styling for Responsiveness */
        @media (max-width: 768px) {
            .info-box-icon {
                width: 40px;
                height: 40px;
                font-size: 1.8rem;
            }

            .card-title {
                font-size: 1rem;
            }

            #user-count-number {
                font-size: 2rem;
            }

            #revenue-count-number {
                font-size: 2rem;
            }

            #visit-count-number {
                font-size: 2rem;
            }
        }


        /* Drop Down Style */
        /* Custom Styling for Dropdown */
        .custom-dropdown {
            max-width: 250px;
            /* Control the width of the dropdown */
            border-radius: 8px;
            /* Rounded corners for a smooth look */
            background-color: #f8f9fa;
            /* Light background */
            border: 1px solid #ddd;
            /* Subtle border color */
            font-size: 1rem;
            /* Adjust the font size */
            font-weight: 500;
            /* Add a bit of boldness for readability */
            transition: all 0.3s ease;
            /* Smooth transition on hover */
        }

        .custom-dropdown:focus {
            outline: none;
            /* Remove outline when focused */
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            /* Add a blue glow on focus */
            border-color: #007bff;
            /* Change border color on focus */
        }

        .custom-dropdown option {
            padding: 10px 20px;
            /* Add padding for better spacing in options */
        }

        .custom-dropdown:hover {
            background-color: #f1f1f1;
            /* Light background when hovered */
        }

        /* Responsive design: dropdown width adjusts based on screen size */
        @media (max-width: 768px) {
            .custom-dropdown {
                max-width: 100%;
            }
        }

        /*  */
        .main-input {
            height: 100%;
            line-height: 40px;
            border: 1px solid #C6C6C6;
            padding: 0 15px;
            position: relative;
            overflow: hidden;
            height: 40px;
        }

        .main-input .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            right: 0;
            height: 100%;
        }

        .main-input i {
            position: absolute;
            width: 40px;
            text-align: center;
            height: 40px;
            line-height: 40px;
            z-index: 3;
            right: 0;
            left: auto;
            font-size: 20px;
        }

        .file-name {
            font-size: 14px;
            color: #928d8d;
            white-space: nowrap;
        }

        .main-input .uploaded-image {
            position: absolute;
            top: 50%;
            height: auto;
            right: 0;
            z-index: 9;
            transform: translate(0, -50%);
            cursor: pointer;
            transition: all .3s;
        }

        .main-input .uploaded-image img {
            max-height: 40px;
            min-width: 40px;
            display: block;
            border-radius: 8px;
            transition: all .3s;
            height: 100%;
        }

        .main-input .uploaded-image.active img {
            max-height: 240px;
            min-width: auto;
            max-width: calc(100vw - 20px);
            margin: auto;
            height: auto;
        }

        .main-input .uploaded-image.active {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999999;
            width: auto;
            height: auto;
            box-shadow: none;
        }

        .btns {
            padding: 15px 0;
        }

        #confirm-del form {
            justify-content: center;
        }

        .card-footer a i {
            margin: 0 5px;
        }

        #confirm-del form button,
        #add-user form button,
        #edit-user form button {
            margin: 5px;
        }

        .modal .modal-header .close {
            margin: 0;
            padding: 0;
            color: #fff
        }

        .modal .modal-header {
            align-items: center;
            padding: 10px;
            background-color: #343a40;
            color: #fff
        }

        .search-div form .form-in:not(:last-child),
        .search-div form .form-in:not(:last-child)+span {
            margin-right: 10px;
        }

        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
        }

        .bootstrap-switch {
            position: absolute;
            right: 16px;
            top: 6px;
            z-index: 99;
        }

        .mark-user .custom-control-label::before,
        .mark-user .custom-control-label::after {
            top: 8px;
            left: 0;
            width: 20px;
            height: 20px;
        }

        .showIndexData {
            height: 275px;
        }
    </style>
@endsection

@section('content')
    {{-- Test Style Of Statistics --}}
    <div class="container mt-4">
        <div class="row p-3">
            <!-- Dropdown Filter for All Cards -->
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">الإحصائيات</h3>
                    <div>
                        <!-- Custom Styled Dropdown -->
                        <select id="user-stats-filter" class="form-select custom-dropdown shadow-sm p-3">
                            <option value="all-time" selected>كل الوقت</option>
                            <option value="today">اليوم</option>
                            <option value="this-week">هذا الأسبوع</option>
                            <option value="this-month">هذا الشهر</option>
                            <option value="previous-month">الشهر الماضي</option>
                            <option value="last-three-months">آخر 3 أشهر</option>
                            <option value="this-year">هذه السنة</option>
                            <option value="previous-year">السنة الماضية</option>
                            <option value="custom">أدخل تاريخ مخصص</option>
                        </select>
                    </div>

                </div>
                <!-- Custom Date Range Inputs -->
                <div id="custom-date-range" style="display: none;">
                    <input type="date" id="start-date" class="form-control mb-2" placeholder="Start Date">
                    <input type="date" id="end-date" class="form-control mb-2" placeholder="End Date">
                    <button id="apply-custom-filter" class="btn btn-primary btn-sm w-100">تطبيق</button>
                </div>
            </div>

            <!-- User Statistics Card -->
            <div class="col-md-4 mb-4">
                <div class="card2 shadow-sm border-0 rounded-lg">
                    <div class="card-body2">
                        <div class="d-flex flex-column align-items-center">
                            <span class="info-box-icon2 bg-info2 shadow-lg">
                                <i class="fas fa-user-tie"></i>
                            </span>

                            <h5 class="card-title2">المشتركين</h5>

                            <!-- User Count Display -->
                            <div id="user-count" class="stats-result mt-3 text-center">
                                <p>
                                    <span id="user-count-number" class="fw-bold fs-3">0</span>
                                </p>
                                <p class="text-muted">جميع المشتركين</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="col-md-4 mb-4">
                <div class="card2 shadow-sm border-0 rounded-lg">
                    <div class="card-body2">
                        <div class="d-flex flex-column align-items-center">
                            <span class="info-box-icon2 bg-info2 shadow-lg">
                                <i class="fas fa-wallet"></i>
                            </span>

                            <h5 class="card-title2">الأرباح</h5>

                            <!-- Revenue Count Display -->
                            <div id="revenue-count" class="stats-result mt-3 text-center">
                                <p>
                                    <span id="revenue-count-number" class="fw-bold fs-3">0</span>
                                </p>
                                <p class="text-muted">ريال سعودي</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visits Card -->
            <div class="col-md-4 mb-4">
                <div class="card2 shadow-sm border-0 rounded-lg">
                    <div class="card-body2">
                        <div class="d-flex flex-column align-items-center">
                            <span class="info-box-icon2 bg-warning2 shadow-lg">
                                <i class="fas fa-eye"></i>
                            </span>

                            <h5 class="card-title2">زيارات الموقع</h5>

                            <!-- Visit Count Display -->
                            <div id="visit-count" class="stats-result mt-3 text-center">
                                <p>
                                    <span id="visit-count-number" class="fw-bold fs-3">0</span>
                                </p>
                                <p class="text-muted">إجمالي الزيارات</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="{{ route('admins') }}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-tie"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">المديرين</span>
                                    <span class="info-box-number">
                                        {{ count(get_users_by('admin', 'asc', 0)) }}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="{{ route('users') }}">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">الاعضاء</span>
                                    <span class="info-box-number">
                                        {{ count(get_users_by('client', 'asc', 0)) }}
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="{{ route('sliders', 'app') }}">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-image"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">الاعلانات</span>
                                    <span class="info-box-number">{{ App\Models\Slider::whereType('app')->count() }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="{{ route('contacts', 'contact') }}">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-envelope"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">تواصل معنا</span>
                                    <span
                                        class="info-box-number">{{ App\Models\Contact::where('seen', '0')->count() }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->


                <!-- Main row -->
                <div class="row">

                    <div class="col-md-12">
                        <!-- USERS LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">أحدث الاعضاء</h3>

                                <div class="card-tools">
                                    <span class="badge badge-danger">اعضاء جدد</span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>

                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body showIndexData p-0">
                                <ul class="users-list clearfix">
                                    @foreach (get_users_by('client', 'desc', 8) as $item)
                                        <li>
                                            <img src="{{ is_null($item->avatar) ? url('public/user.png') : url('' . $item->avatar) }}"
                                                alt="{{ $item->name }}">
                                            <a class="users-list-name" href="#">{{ $item->name }}</a>
                                            <span
                                                class="users-list-date">{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <!-- /.users-list -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('users') }}">عرض الكل</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!--/.card -->
                    </div>
                    <!-- /.col -->

                    {{-- <div class="col-12">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Latest Orders</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                <tr>
                                <th>Order ID</th>
                                <th>Item</th>
                                <th>Status</th>
                                <th>Popularity</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="badge badge-success">Shipped</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                </td>
                                </tr>
                                <tr>
                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                <td>Samsung Smart TV</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                                </td>
                                </tr>
                                <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>iPhone 6 Plus</td>
                                <td><span class="badge badge-danger">Delivered</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                                </td>
                                </tr>
                                <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>Samsung Smart TV</td>
                                <td><span class="badge badge-info">Processing</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                                </td>
                                </tr>
                                <tr>
                                <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                <td>Samsung Smart TV</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                                </td>
                                </tr>
                                <tr>
                                <td><a href="pages/examples/invoice.html">OR7429</a></td>
                                <td>iPhone 6 Plus</td>
                                <td><span class="badge badge-danger">Delivered</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                                </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div> --}}
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    @endsection
    @section('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const filterDropdown = document.getElementById('user-stats-filter');
                const customDateRange = document.getElementById('custom-date-range');
                const applyCustomFilter = document.getElementById('apply-custom-filter');
                const userCountNumber = document.getElementById('user-count-number');

                const fetchUserStats = (filter, startDate = null, endDate = null) => {
                    let url = `/admin/user-stats?filter=${filter}`;
                    if (startDate && endDate) {
                        url += `&start_date=${startDate}&end_date=${endDate}`;
                    }

                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to fetch user stats.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.count !== undefined) {
                                userCountNumber.textContent = data.count;
                            } else if (data.error) {
                                alert(data.error);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                };

                // Listen for filter changes
                filterDropdown.addEventListener('change', function() {
                    const selectedFilter = this.value;

                    if (selectedFilter === 'custom') {
                        customDateRange.style.display = 'block';
                    } else {
                        customDateRange.style.display = 'none';
                        fetchUserStats(selectedFilter);
                    }
                });

                // Apply custom filter
                applyCustomFilter.addEventListener('click', function() {
                    const startDate = document.getElementById('start-date').value;
                    const endDate = document.getElementById('end-date').value;

                    if (!startDate || !endDate) {
                        alert('Please select both start and end dates.');
                        return;
                    }

                    if (new Date(startDate) > new Date(endDate)) {
                        alert('Start date must be earlier than end date.');
                        return;
                    }

                    fetchUserStats('custom', startDate, endDate);
                });

                // Initial load
                fetchUserStats('all-time');
            });


            ////###### for revenu card ######
            document.addEventListener('DOMContentLoaded', function() {
                const filterDropdown = document.getElementById('user-stats-filter');
                const customDateRange = document.getElementById('custom-date-range');
                const startDateInput = document.getElementById('start-date');
                const endDateInput = document.getElementById('end-date');
                const applyCustomFilterButton = document.getElementById('apply-custom-filter');
                const revenueCountNumber = document.getElementById('revenue-count-number');

                // Function to fetch and update revenue
                function updateRevenue(filter, startDate = null, endDate = null) {
                    let url = `/api/revenue-stats?filter=${filter}`;
                    if (filter === 'custom' && startDate && endDate) {
                        url += `&start_date=${startDate}&end_date=${endDate}`;
                    }

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data.total_revenue !== undefined) {
                                revenueCountNumber.textContent = data.total_revenue.toFixed(
                                    2); // Show revenue with 2 decimals
                            } else {
                                revenueCountNumber.textContent = '0';
                            }
                        })
                        .catch(error => console.error('Error fetching revenue:', error));
                }

                // Handle filter changes
                filterDropdown.addEventListener('change', function() {
                    const selectedFilter = this.value;

                    // Show or hide custom date range inputs
                    if (selectedFilter === 'custom') {
                        customDateRange.style.display = 'block';
                    } else {
                        customDateRange.style.display = 'none';
                        updateRevenue(selectedFilter);
                    }
                });

                // Handle custom date filter application
                applyCustomFilterButton.addEventListener('click', function() {
                    const startDate = startDateInput.value;
                    const endDate = endDateInput.value;

                    if (!startDate || !endDate) {
                        alert('Please select both start and end dates.');
                        return;
                    }

                    updateRevenue('custom', startDate, endDate);
                });

                // Initial revenue update for the default filter
                updateRevenue('all-time');
            });

            // Function to fetch and update visit count
            document.addEventListener('DOMContentLoaded', function() {
                const filterDropdownVisits = document.getElementById('user-stats-filter');
                const customDateRangeVisits = document.getElementById('custom-date-range-visits');
                const startDateVisits = document.getElementById('start-date-visits');
                const endDateVisits = document.getElementById('end-date-visits');
                const applyCustomFilterVisits = document.getElementById('apply-custom-filter-visits');
                const visitCountNumber = document.getElementById('visit-count-number');

                // Function to fetch and update visit count
                function updateVisits(filter, startDate = null, endDate = null) {
                    console.log('Updating visits with filter:', filter); // Add this log for debugging

                    let url = `/api/visit-stats?filter=${filter}`;
                    if (filter === 'custom' && startDate && endDate) {
                        url += `&start_date=${startDate}&end_date=${endDate}`;
                    }

                    console.log('Request URL:', url); // Log the URL to ensure it's correct

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Visit data:', data); // Log the response data
                            if (data.count !== undefined) {
                                visitCountNumber.textContent = data.count; // Update the visit count
                            } else {
                                visitCountNumber.textContent = '0'; // Default to 0 if no count is found
                            }
                        })
                        .catch(error => console.error('Error fetching visit data:', error));
                }

                // Initial visits update for the default filter
                updateVisits('all-time');
            });
        </script>
    @endsection
