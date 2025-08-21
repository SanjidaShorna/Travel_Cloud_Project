<?php
<?php
$servername = getenv('MYSQL_HOST');
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');
$dbname = getenv('MYSQL_DATABASE');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BanglaTravel - Smart Travel Planning</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
        }
        .destination-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .destination-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .tab-active {
            border-bottom: 3px solid #047857;
            color: #047857;
            font-weight: 600;
        }
        .prediction-card {
            background: linear-gradient(135deg, #f6f8fa 0%, #e9f1f7 100%);
        }
        .modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .modal-content {
            transition: transform 0.3s ease;
        }
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        .modal.active .modal-content {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="ml-2 text-xl font-bold text-emerald-700">BanglaTravel</span>
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="#" class="text-gray-700 hover:text-emerald-700">Home</a>
                <a href="#" class="text-gray-700 hover:text-emerald-700">Destinations</a>
                <a href="#" class="text-gray-700 hover:text-emerald-700">Packages</a>
                <a href="#" class="text-gray-700 hover:text-emerald-700">About Us</a>
                <a href="#" class="text-gray-700 hover:text-emerald-700">Contact</a>
            </div>
            <div class="flex items-center space-x-4">
                <button class="bg-emerald-700 text-white px-4 py-2 rounded-md hover:bg-emerald-800 transition">Sign In</button>
                <button class="md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Discover Your Dream Destination</h1>
            <p class="text-xl mb-8">Smart travel planning for Bangladeshi travelers</p>
            
            <!-- Search Form -->
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Destination</label>
                        <select id="destination" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-700">
                            <option value="">Select Destination</option>
                            <option value="bali">Bali, Indonesia</option>
                            <option value="tokyo">Tokyo, Japan</option>
                            <option value="bangkok">Bangkok, Thailand</option>
                            <option value="dubai">Dubai, UAE</option>
                            <option value="singapore">Singapore</option>
                            <option value="maldives">Maldives</option>
                            <option value="paris">Paris, France</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Check-in Date</label>
                        <input type="date" id="checkin" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Check-out Date</label>
                        <input type="date" id="checkout" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-700">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Travelers</label>
                        <select id="travelers" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-700">
                            <option value="1">1 Person</option>
                            <option value="2">2 People</option>
                            <option value="3">3 People</option>
                            <option value="4">4 People</option>
                            <option value="5">5+ People</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Accommodation Type</label>
                        <select id="accommodation" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-700">
                            <option value="all">All Types</option>
                            <option value="hotel">Hotel</option>
                            <option value="airbnb">Airbnb</option>
                            <option value="apartment">Rental Apartment</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button id="search-btn" class="w-full bg-emerald-700 text-white p-3 rounded-md hover:bg-emerald-800 transition">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Destinations -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Popular Destinations</h2>
            <div id="popular-destinations" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Destinations will be populated by JS -->
            </div>
            <div class="text-center mt-10">
                <button id="view-more-btn" class="bg-emerald-700 text-white px-6 py-3 rounded-md hover:bg-emerald-800 transition">View All Destinations</button>
            </div>
        </div>
    </section>

    <!-- ML Destination Details Section (Initially Hidden) -->
    <section id="ml-destination-details" class="py-16 bg-gray-50 hidden">
        <div class="container mx-auto px-4">
            <div class="flex items-center mb-8">
                <button id="back-btn" class="mr-4 text-emerald-700 hover:text-emerald-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <h2 id="destination-title" class="text-3xl font-bold"></h2>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-8">
                <div class="flex flex-wrap -mb-px">
                    <button class="tab-btn tab-active mr-8 py-4 px-1" data-tab="overview">Overview</button>
                    <button class="tab-btn mr-8 py-4 px-1" data-tab="predictions">Price Predictions</button>
                    <button class="tab-btn mr-8 py-4 px-1" data-tab="trending">Trending Places</button>
                    <button class="tab-btn mr-8 py-4 px-1" data-tab="accommodations">Accommodations</button>
                </div>
            </div>

            <!-- Tab Content -->
            <div id="tab-content">
                <!-- Overview Tab (Default) -->
                <div id="overview-content" class="tab-content">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                                <h3 class="text-xl font-bold mb-4">Destination Highlights</h3>
                                <div id="destination-highlights" class="prose max-w-none">
                                    <!-- Content will be populated by JS -->
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h3 class="text-xl font-bold mb-4">Best Time to Visit</h3>
                                <div id="best-time-content" class="prose max-w-none">
                                    <!-- Content will be populated by JS -->
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                                <h3 class="text-xl font-bold mb-4">Quick Facts</h3>
                                <ul id="quick-facts" class="space-y-3">
                                    <!-- Content will be populated by JS -->
                                </ul>
                            </div>
                            
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h3 class="text-xl font-bold mb-4">Weather</h3>
                                <div id="weather-info" class="space-y-4">
                                    <!-- Content will be populated by JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Predictions Tab -->
                <div id="predictions-content" class="tab-content hidden">
                    <div class="mb-6 bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4">Price Prediction Settings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Travel Month</label>
                                <select id="prediction-month" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-700">
                                    <option value="0">January</option>
                                    <option value="1">February</option>
                                    <option value="2">March</option>
                                    <option value="3">April</option>
                                    <option value="4">May</option>
                                    <option value="5">June</option>
                                    <option value="6">July</option>
                                    <option value="7" selected>August</option>
                                    <option value="8">September</option>
                                    <option value="9">October</option>
                                    <option value="10">November</option>
                                    <option value="11">December</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-2">Trip Duration</label>
                                <select id="prediction-duration" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-700">
                                    <option value="3">3 days</option>
                                    <option value="5">5 days</option>
                                    <option value="7" selected>7 days</option>
                                    <option value="10">10 days</option>
                                    <option value="14">14 days</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button id="update-prediction-btn" class="w-full bg-emerald-700 text-white p-3 rounded-md hover:bg-emerald-800 transition">Update Predictions</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-bold mb-4">Flight Price Prediction</h3>
                            <div class="mb-6">
                                <canvas id="flight-price-chart" height="250"></canvas>
                            </div>
                            <div id="flight-prediction-details" class="mt-4">
                                <!-- Content will be populated by JS -->
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-xl font-bold mb-4">Accommodation Price Prediction</h3>
                            <div class="mb-6">
                                <canvas id="accommodation-price-chart" height="250"></canvas>
                            </div>
                            <div id="accommodation-prediction-details" class="mt-4">
                                <!-- Content will be populated by JS -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="prediction-card rounded-lg shadow-md p-6">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-xl font-bold ml-2">Best Time to Visit for Budget</h3>
                            </div>
                            <div id="budget-time-details" class="prose max-w-none">
                                <!-- Content will be populated by JS -->
                            </div>
                        </div>
                        
                        <div class="prediction-card rounded-lg shadow-md p-6">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                <h3 class="text-xl font-bold ml-2">Best Overall Experience</h3>
                            </div>
                            <div id="best-experience-details" class="prose max-w-none">
                                <!-- Content will be populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Trending Places Tab -->
                <div id="trending-content" class="tab-content hidden">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-6">Most Visited Places</h3>
                        <div id="trending-places" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Content will be populated by JS -->
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold mb-6">Popular Activities</h3>
                        <div id="popular-activities" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Content will be populated by JS -->
                        </div>
                    </div>
                </div>
                
                <!-- Accommodations Tab -->
                <div id="accommodations-content" class="tab-content hidden">
                    <div class="flex flex-wrap gap-4 mb-6">
                        <button class="accommodation-filter px-4 py-2 rounded-full bg-emerald-700 text-white" data-filter="all">All</button>
                        <button class="accommodation-filter px-4 py-2 rounded-full bg-gray-200 text-gray-700" data-filter="hotel">Hotels</button>
                        <button class="accommodation-filter px-4 py-2 rounded-full bg-gray-200 text-gray-700" data-filter="airbnb">Airbnb</button>
                        <button class="accommodation-filter px-4 py-2 rounded-full bg-gray-200 text-gray-700" data-filter="apartment">Apartments</button>
                    </div>
                    
                    <div id="accommodations-list" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Content will be populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Destinations Section (Initially Hidden) -->
    <section id="all-destinations-section" class="py-16 bg-gray-50 hidden">
        <div class="container mx-auto px-4">
            <div class="flex items-center mb-8">
                <button id="back-to-home-btn" class="mr-4 text-emerald-700 hover:text-emerald-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <h2 class="text-3xl font-bold">All Destinations</h2>
            </div>
            
            <div class="mb-8">
                <div class="relative">
                    <input type="text" id="destination-search" placeholder="Search destinations..." class="w-full p-4 pl-12 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 absolute left-4 top-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            <div id="all-destinations-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Will be populated by JS -->
            </div>
        </div>
    </section>

    <!-- Booking Modal -->
    <div id="booking-modal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center opacity-0 invisible">
        <div class="modal-content bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 transform translate-y-8">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-800" id="booking-modal-title">Book Your Stay</h3>
                    <button id="close-modal-btn" class="text-gray-400 hover:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div id="booking-accommodation-image" class="h-64 bg-cover bg-center rounded-lg mb-4"></div>
                        <h4 id="booking-accommodation-name" class="text-xl font-bold mb-2"></h4>
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span id="booking-accommodation-rating" class="ml-1 text-gray-700"></span>
                            <span class="mx-2 text-gray-400">•</span>
                            <span id="booking-accommodation-location" class="text-gray-700"></span>
                        </div>
                        <div id="booking-accommodation-features" class="flex flex-wrap gap-2 mb-4">
                            <!-- Will be populated by JS -->
                        </div>
                        <div class="mb-4">
                            <span class="text-2xl font-bold text-emerald-700" id="booking-accommodation-price"></span>
                            <span class="text-gray-500">/night</span>
                        </div>
                    </div>
                    
                    <div>
                        <form id="booking-form">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="booking-name">Full Name</label>
                                <input type="text" id="booking-name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="booking-email">Email Address</label>
                                <input type="email" id="booking-email" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="booking-phone">Phone Number</label>
                                <input type="tel" id="booking-phone" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="booking-checkin">Check-in Date</label>
                                    <input type="date" id="booking-checkin" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="booking-checkout">Check-out Date</label>
                                    <input type="date" id="booking-checkout" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="booking-guests">Number of Guests</label>
                                <select id="booking-guests" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <option value="1">1 Guest</option>
                                    <option value="2">2 Guests</option>
                                    <option value="3">3 Guests</option>
                                    <option value="4">4 Guests</option>
                                    <option value="5">5+ Guests</option>
                                </select>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="booking-requests">Special Requests</label>
                                <textarea id="booking-requests" rows="3" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-emerald-700 text-white p-3 rounded-md hover:bg-emerald-800 transition">Confirm Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Confirmation Modal -->
    <div id="confirmation-modal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center opacity-0 invisible">
        <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform translate-y-8 p-6 text-center">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Booking Confirmed!</h3>
            <p class="text-gray-600 mb-6">Your booking has been successfully confirmed. A confirmation email has been sent to your email address.</p>
            <div id="booking-reference" class="bg-gray-100 p-4 rounded-md mb-6">
                <p class="text-gray-700">Booking Reference: <span class="font-bold" id="booking-reference-number"></span></p>
            </div>
            <button id="close-confirmation-btn" class="w-full bg-emerald-700 text-white p-3 rounded-md hover:bg-emerald-800 transition">Close</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">BanglaTravel</h3>
                    <p class="text-gray-300">Smart travel planning for Bangladeshi travelers with ML-powered insights.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Destinations</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Packages</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">About Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>+880 1712-345678</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>info@banglatravel.com</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Gulshan, Dhaka, Bangladesh</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Newsletter</h4>
                    <p class="text-gray-300 mb-4">Subscribe for travel deals and tips</p>
                    <div class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 w-full rounded-l-md focus:outline-none text-gray-800">
                        <button class="bg-emerald-700 px-4 py-2 rounded-r-md hover:bg-emerald-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2023 BanglaTravel. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Destination data
        const destinationData = {
            bali: {
                title: "Bali, Indonesia",
                image: "https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                price: "৳85,000",
                mlEnabled: true,
                highlights: `
                    <p>Bali, known as the Island of the Gods, is a paradise destination that offers something for every traveler. From pristine beaches and lush rice terraces to ancient temples and vibrant cultural experiences, Bali is a feast for the senses.</p>
                    <p>The island's unique blend of stunning natural beauty, rich cultural heritage, and warm hospitality makes it one of the most popular destinations for Bangladeshi travelers seeking an international getaway.</p>
                    <p>Whether you're looking to relax on beautiful beaches, explore ancient temples, enjoy thrilling water sports, or immerse yourself in the local culture, Bali offers endless possibilities for an unforgettable vacation.</p>
                `,
                bestTime: `
                    <p>The best time to visit Bali is during the dry season from April to October, with May, June, and September being ideal months when the weather is pleasant and tourist crowds are smaller.</p>
                    <p><strong>For budget travelers:</strong> The lowest prices for both flights and accommodations can be found in February and November, during the shoulder seasons.</p>
                    <p><strong>For the best experience:</strong> Visit between June and August for perfect weather, though this is also peak tourist season with higher prices.</p>
                `,
                quickFacts: [
                    { icon: "🕒", text: "Time Zone: GMT+8 (2 hours ahead of Bangladesh)" },
                    { icon: "💰", text: "Currency: Indonesian Rupiah (IDR)" },
                    { icon: "🔌", text: "Power Socket: Type C & F (230V)" },
                    { icon: "🗣️", text: "Language: Indonesian (Bahasa Indonesia)" },
                    { icon: "🚕", text: "Local Transport: Taxis, Ride-sharing apps, Scooter rentals" },
                    { icon: "📱", text: "SIM Card: Available at airport (Telkomsel recommended)" }
                ],
                weather: [
                    { month: "Jan-Mar", temp: "26-32°C", condition: "Rainy season, occasional showers" },
                    { month: "Apr-Jun", temp: "25-31°C", condition: "Dry season, sunny days" },
                    { month: "Jul-Sep", temp: "24-30°C", condition: "Dry season, coolest months" },
                    { month: "Oct-Dec", temp: "25-32°C", condition: "Transition to rainy season" }
                ],
                flightPrices: {
                    // Different price patterns for each month
                    0: { // January
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [92000, 90000, 88000, 91000, 93000, 95000, 92000]
                    },
                    1: { // February
                        days: [1, 5, 10, 15, 20, 25, 28],
                        prices: [85000, 84000, 83000, 85000, 87000, 86000, 88000]
                    },
                    2: { // March
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [88000, 89000, 90000, 92000, 91000, 89000, 88000]
                    },
                    3: { // April
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [95000, 97000, 98000, 96000, 95000, 97000, 99000]
                    },
                    4: { // May
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [98000, 99000, 100000, 102000, 103000, 101000, 99000]
                    },
                    5: { // June
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [110000, 112000, 115000, 118000, 116000, 114000, 112000]
                    },
                    6: { // July
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [125000, 127000, 130000, 132000, 135000, 133000, 130000]
                    },
                    7: { // August - Special detailed data for August
                        days: [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29, 31],
                        prices: [128000, 127500, 129000, 131500, 134000, 136500, 138000, 139500, 138000, 136000, 133000, 130000, 127000, 125000, 124000, 123000]
                    },
                    8: { // September
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [105000, 103000, 102000, 100000, 98000, 97000, 95000]
                    },
                    9: { // October
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [95000, 94000, 93000, 92000, 93000, 94000, 95000]
                    },
                    10: { // November
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [87000, 86000, 85000, 84000, 85000, 86000, 87000]
                    },
                    11: { // December
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [115000, 118000, 120000, 125000, 130000, 135000, 130000]
                    }
                },
                accommodationPrices: {
                    // Different price patterns for each month
                    0: { // January
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [5500, 5400, 5300, 5400, 5500, 5600, 5500]
                    },
                    1: { // February
                        days: [1, 5, 10, 15, 20, 25, 28],
                        prices: [5000, 4900, 4800, 4900, 5000, 5100, 5200]
                    },
                    2: { // March
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [5200, 5300, 5400, 5500, 5400, 5300, 5200]
                    },
                    3: { // April
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [5800, 5900, 6000, 5900, 5800, 5900, 6000]
                    },
                    4: { // May
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [6500, 6600, 6700, 6800, 6700, 6600, 6500]
                    },
                    5: { // June
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [7200, 7300, 7400, 7500, 7400, 7300, 7200]
                    },
                    6: { // July
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [8500, 8600, 8700, 8800, 8700, 8600, 8500]
                    },
                    7: { // August - Special detailed data for August
                        days: [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29, 31],
                        prices: [8800, 8950, 9100, 9250, 9400, 9550, 9700, 9800, 9700, 9500, 9300, 9100, 8900, 8700, 8600, 8500]
                    },
                    8: { // September
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [7000, 6900, 6800, 6700, 6600, 6500, 6400]
                    },
                    9: { // October
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [6200, 6100, 6000, 5900, 6000, 6100, 6200]
                    },
                    10: { // November
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [5100, 5000, 4900, 4800, 4900, 5000, 5100]
                    },
                    11: { // December
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [7500, 7700, 7900, 8100, 8300, 8500, 8300]
                    }
                },
                budgetTime: `
                    <p>Based on our ML analysis of historical data, the most budget-friendly time to visit Bali is in <strong>February</strong>, when both flight and accommodation prices are at their lowest.</p>
                    <ul class="list-disc pl-5 mt-3">
                        <li>Average flight price: ৳85,000 (round trip from Dhaka)</li>
                        <li>Average accommodation price: ৳5,000 per night</li>
                        <li>Total estimated savings: Up to 30% compared to peak season</li>
                    </ul>
                    <p class="mt-3">November is another good option for budget travelers, with prices only slightly higher than February.</p>
                `,
                bestExperience: `
                    <p>For the optimal balance of good weather, reasonable prices, and manageable crowds, our ML model recommends visiting Bali in <strong>May</strong> or <strong>September</strong>.</p>
                    <ul class="list-disc pl-5 mt-3">
                        <li>Weather: Dry and sunny with comfortable temperatures</li>
                        <li>Crowds: Moderate, avoiding the July-August peak</li>
                        <li>Prices: Mid-range, about 15-20% lower than peak season</li>
                        <li>Activities: All attractions and activities are fully operational</li>
                    </ul>
                    <p class="mt-3">These months offer the perfect balance for an exceptional Bali experience.</p>
                `,
                trendingPlaces: [
                    {
                        name: "Ubud",
                        description: "Cultural heart of Bali with art markets, monkey forest, and rice terraces",
                        icon: "🏞️",
                        visitRate: "92% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1604999333679-b86d54738315?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Seminyak Beach",
                        description: "Upscale beach area with luxury resorts, shopping, and dining",
                        icon: "🏖️",
                        visitRate: "85% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1621242118749-9a78c8a06d6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Tanah Lot Temple",
                        description: "Iconic sea temple perched on a rock formation",
                        icon: "🛕",
                        visitRate: "78% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1558005137-d9619a5c539f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Sacred Monkey Forest",
                        description: "Natural sanctuary with hundreds of playful monkeys",
                        icon: "🐒",
                        visitRate: "75% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1584535556333-5deb46f8b779?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Tegallalang Rice Terraces",
                        description: "Stunning stepped rice fields using traditional Balinese irrigation",
                        icon: "🌾",
                        visitRate: "72% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1531592937781-344ad608fabf?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Uluwatu Temple",
                        description: "Clifftop temple with spectacular sunset views and Kecak dance performances",
                        icon: "🌅",
                        visitRate: "68% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    }
                ],
                popularActivities: [
                    {
                        name: "Bali Swing Experience",
                        description: "Swing over jungle valleys for incredible photos",
                        icon: "🌴",
                        popularity: "Trending up 45% this year",
                        image: "https://images.unsplash.com/photo-1573790387438-4da905039392?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Mount Batur Sunrise Trek",
                        description: "Early morning hike to witness spectacular sunrise from an active volcano",
                        icon: "🌋",
                        popularity: "Trending up 38% this year",
                        image: "https://images.unsplash.com/photo-1518002054494-3a6f94352e9d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Balinese Cooking Class",
                        description: "Learn to prepare authentic Balinese dishes with local ingredients",
                        icon: "👨‍🍳",
                        popularity: "Trending up 32% this year",
                        image: "https://images.unsplash.com/photo-1589647363585-f4a7d3877b10?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Nusa Penida Island Tour",
                        description: "Day trip to explore stunning cliffs and beaches of nearby island",
                        icon: "🏝️",
                        popularity: "Trending up 55% this year",
                        image: "https://images.unsplash.com/photo-1570789210967-2cac24afeb00?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Waterbom Bali",
                        description: "Premium water park with thrilling slides and attractions",
                        icon: "🎢",
                        popularity: "Trending up 25% this year",
                        image: "https://images.unsplash.com/photo-1582650949011-13de0bf05443?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Uluwatu Sunset & Kecak Dance",
                        description: "Traditional fire dance performance with dramatic clifftop setting",
                        icon: "💃",
                        popularity: "Trending up 30% this year",
                        image: "https://images.unsplash.com/photo-1518002054494-3a6f94352e9d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    }
                ],
                accommodations: [
                    {
                        name: "Padma Resort Ubud",
                        type: "hotel",
                        location: "Ubud",
                        price: "৳18,500",
                        rating: 4.8,
                        features: ["Infinity pool", "Spa", "Multiple restaurants", "Valley views"],
                        image: "https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Luxury Villa with Private Pool",
                        type: "airbnb",
                        location: "Seminyak",
                        price: "৳15,200",
                        rating: 4.9,
                        features: ["Private pool", "3 bedrooms", "Full kitchen", "Daily cleaning"],
                        image: "https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Beachfront Apartment",
                        type: "apartment",
                        location: "Kuta",
                        price: "৳8,500",
                        rating: 4.5,
                        features: ["Ocean view", "2 bedrooms", "Shared pool", "24h security"],
                        image: "https://images.unsplash.com/photo-1540541338287-41700207dee6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "The Kayon Resort",
                        type: "hotel",
                        location: "Ubud",
                        price: "৳16,800",
                        rating: 4.7,
                        features: ["Jungle setting", "Infinity pool", "Spa treatments", "Free shuttle"],
                        image: "https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Traditional Balinese Villa",
                        type: "airbnb",
                        location: "Canggu",
                        price: "৳12,300",
                        rating: 4.6,
                        features: ["Garden", "2 bedrooms", "Open-air bathroom", "Breakfast included"],
                        image: "https://images.unsplash.com/photo-1615880484746-a134be9a6ecf?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Modern Loft Apartment",
                        type: "apartment",
                        location: "Seminyak",
                        price: "৳7,200",
                        rating: 4.4,
                        features: ["Rooftop pool", "1 bedroom", "Gym access", "Walking distance to beach"],
                        image: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    }
                ]
            },
            tokyo: {
                title: "Tokyo, Japan",
                image: "https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                price: "৳120,000",
                mlEnabled: true,
                highlights: `
                    <p>Tokyo, Japan's bustling capital, is a fascinating blend of ultramodern and traditional, where neon-lit skyscrapers coexist with historic temples and gardens. This dynamic metropolis offers an unparalleled experience for travelers from Bangladesh seeking to explore one of Asia's most advanced cities.</p>
                    <p>From world-class shopping and dining to cultural landmarks and technological wonders, Tokyo presents endless opportunities for discovery. The city's efficient public transportation, cleanliness, and safety make it an ideal destination for both first-time and seasoned travelers.</p>
                    <p>Whether you're interested in exploring ancient traditions, experiencing cutting-edge technology, or indulging in exceptional cuisine, Tokyo offers a unique and unforgettable travel experience.</p>
                `,
                bestTime: `
                    <p>The best times to visit Tokyo are during spring (March to May) for cherry blossoms and autumn (September to November) for colorful foliage and pleasant temperatures.</p>
                    <p><strong>For budget travelers:</strong> January and February offer the lowest prices for both flights and accommodations, though temperatures can be cold.</p>
                    <p><strong>For the best experience:</strong> Late March to early April for cherry blossom season, though this is also one of the most expensive and crowded periods.</p>
                `,
                quickFacts: [
                    { icon: "🕒", text: "Time Zone: GMT+9 (3 hours ahead of Bangladesh)" },
                    { icon: "💰", text: "Currency: Japanese Yen (JPY)" },
                    { icon: "🔌", text: "Power Socket: Type A & B (100V)" },
                    { icon: "🗣️", text: "Language: Japanese" },
                    { icon: "🚇", text: "Local Transport: Metro, JR trains, buses, taxis" },
                    { icon: "📱", text: "SIM Card: Available at airport (Docomo, Softbank, AU)" }
                ],
                weather: [
                    { month: "Jan-Mar", temp: "5-15°C", condition: "Cold, occasionally snowy in Jan-Feb" },
                    { month: "Apr-Jun", temp: "14-25°C", condition: "Pleasant spring, rainy in June" },
                    { month: "Jul-Sep", temp: "22-31°C", condition: "Hot & humid, typhoon season" },
                    { month: "Oct-Dec", temp: "8-22°C", condition: "Cool autumn, cold in December" }
                ],
                flightPrices: {
                    // Different price patterns for each month
                    0: { // January
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [115000, 114000, 113000, 114000, 115000, 116000, 115000]
                    },
                    1: { // February
                        days: [1, 5, 10, 15, 20, 25, 28],
                        prices: [112000, 111000, 110000, 111000, 112000, 113000, 114000]
                    },
                    2: { // March - Cherry blossom season starts
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [135000, 138000, 140000, 142000, 145000, 148000, 150000]
                    },
                    3: { // April - Peak cherry blossom
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [145000, 148000, 150000, 148000, 145000, 142000, 140000]
                    },
                    4: { // May
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [130000, 128000, 126000, 125000, 126000, 128000, 130000]
                    },
                    5: { // June
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [125000, 124000, 123000, 124000, 125000, 126000, 127000]
                    },
                    6: { // July
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [140000, 142000, 144000, 146000, 144000, 142000, 140000]
                    },
                    7: { // August - Special detailed data for August
                        days: [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29, 31],
                        prices: [142000, 145000, 148000, 151000, 153000, 155000, 156000, 157000, 155000, 153000, 150000, 147000, 145000, 143000, 141000, 140000]
                    },
                    8: { // September
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [128000, 127000, 126000, 125000, 126000, 127000, 128000]
                    },
                    9: { // October - Autumn colors start
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [132000, 134000, 136000, 138000, 136000, 134000, 132000]
                    },
                    10: { // November - Peak autumn colors
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [120000, 122000, 124000, 126000, 124000, 122000, 120000]
                    },
                    11: { // December
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [138000, 140000, 142000, 144000, 146000, 148000, 146000]
                    }
                },
                accommodationPrices: {
                    // Different price patterns for each month
                    0: { // January
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [8500, 8400, 8300, 8400, 8500, 8600, 8500]
                    },
                    1: { // February
                        days: [1, 5, 10, 15, 20, 25, 28],
                        prices: [8200, 8100, 8000, 8100, 8200, 8300, 8400]
                    },
                    2: { // March - Cherry blossom season starts
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [12500, 13000, 13500, 14000, 14500, 15000, 15500]
                    },
                    3: { // April - Peak cherry blossom
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [14800, 15000, 15200, 15000, 14800, 14600, 14400]
                    },
                    4: { // May
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [11000, 10800, 10600, 10500, 10600, 10800, 11000]
                    },
                    5: { // June
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [9500, 9400, 9300, 9400, 9500, 9600, 9700]
                    },
                    6: { // July
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [10500, 10700, 10900, 11100, 10900, 10700, 10500]
                    },
                    7: { // August - Special detailed data for August
                        days: [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23, 25, 27, 29, 31],
                        prices: [11200, 11500, 11800, 12100, 12400, 12600, 12800, 13000, 12700, 12400, 12100, 11800, 11500, 11300, 11100, 11000]
                    },
                    8: { // September
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [10800, 10700, 10600, 10500, 10600, 10700, 10800]
                    },
                    9: { // October - Autumn colors start
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [12000, 12200, 12400, 12600, 12400, 12200, 12000]
                    },
                    10: { // November - Peak autumn colors
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [9800, 10000, 10200, 10400, 10200, 10000, 9800]
                    },
                    11: { // December
                        days: [1, 5, 10, 15, 20, 25, 30],
                        prices: [11500, 11700, 11900, 12100, 12300, 12500, 12300]
                    }
                },
                budgetTime: `
                    <p>Based on our ML analysis of historical data, the most budget-friendly time to visit Tokyo is in <strong>February</strong>, when both flight and accommodation prices are at their lowest.</p>
                    <ul class="list-disc pl-5 mt-3">
                        <li>Average flight price: ৳112,000 (round trip from Dhaka)</li>
                        <li>Average accommodation price: ৳8,200 per night</li>
                        <li>Total estimated savings: Up to 35% compared to cherry blossom season</li>
                    </ul>
                    <p class="mt-3">January is also economical, with November being another good option for budget travelers with slightly milder weather.</p>
                `,
                bestExperience: `
                    <p>For the optimal balance of good weather, reasonable prices, and special experiences, our ML model recommends visiting Tokyo in <strong>late October to early November</strong> or <strong>late March to early April</strong> (if budget allows).</p>
                    <ul class="list-disc pl-5 mt-3">
                        <li>Weather: Pleasant temperatures with low humidity</li>
                        <li>Scenery: Beautiful autumn colors (October-November) or cherry blossoms (March-April)</li>
                        <li>Prices: Mid-range in autumn, premium during cherry blossom season</li>
                        <li>Crowds: Moderate in autumn, very high during cherry blossom season</li>
                    </ul>
                    <p class="mt-3">May is also an excellent choice with pleasant weather and lower prices after the cherry blossom peak.</p>
                `,
                trendingPlaces: [
                    {
                        name: "Shibuya Crossing",
                        description: "World's busiest pedestrian crossing with iconic neon displays",
                        icon: "🚶",
                        visitRate: "95% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1542051841857-5f90071e7989?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Tokyo Skytree",
                        description: "Tallest tower in Japan with observation decks offering panoramic views",
                        icon: "🗼",
                        visitRate: "88% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1536098561742-ca998e48cbcc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Sensō-ji Temple",
                        description: "Tokyo's oldest and most significant Buddhist temple",
                        icon: "🏮",
                        visitRate: "85% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Shinjuku Gyoen National Garden",
                        description: "Beautiful park with Japanese, English and French gardens",
                        icon: "🌸",
                        visitRate: "78% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1554797589-7241bb691973?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Akihabara Electric Town",
                        description: "Center for anime, manga, and electronics shopping",
                        icon: "🎮",
                        visitRate: "75% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1524413840807-0c3cb6fa808d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Meiji Shrine",
                        description: "Serene Shinto shrine dedicated to Emperor Meiji and Empress Shoken",
                        icon: "⛩️",
                        visitRate: "72% of Bangladeshi visitors",
                        image: "https://images.unsplash.com/photo-1583084647979-b53fbbc15e79?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    }
                ],
                popularActivities: [
                    {
                        name: "TeamLab Borderless Digital Art Museum",
                        description: "Immersive digital art experience with interactive installations",
                        icon: "🎨",
                        popularity: "Trending up 60% this year",
                        image: "https://images.unsplash.com/photo-1553901753-215db344677a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Tokyo Food Tour",
                        description: "Guided culinary experience through local neighborhoods",
                        icon: "🍣",
                        popularity: "Trending up 45% this year",
                        image: "https://images.unsplash.com/photo-1611143669185-af224c5e3252?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Mt. Fuji Day Trip",
                        description: "Excursion to Japan's iconic mountain with lake views",
                        icon: "🗻",
                        popularity: "Trending up 40% this year",
                        image: "https://images.unsplash.com/photo-1570789210967-2cac24afeb00?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Robot Restaurant Show",
                        description: "Futuristic entertainment with robots, lights, and music",
                        icon: "🤖",
                        popularity: "Trending up 35% this year",
                        image: "https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Sumo Wrestling Tournament",
                        description: "Experience Japan's traditional sport at Ryogoku Kokugikan",
                        icon: "🥋",
                        popularity: "Trending up 30% this year",
                        image: "https://images.unsplash.com/photo-1581955957646-b5a446c6029d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Kimono Experience",
                        description: "Rent a traditional kimono and explore historic districts",
                        icon: "👘",
                        popularity: "Trending up 38% this year",
                        image: "https://images.unsplash.com/photo-1528360983277-13d401cdc186?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    }
                ],
                accommodations: [
                    {
                        name: "Park Hyatt Tokyo",
                        type: "hotel",
                        location: "Shinjuku",
                        price: "৳32,500",
                        rating: 4.9,
                        features: ["Luxury rooms", "Spa", "Multiple restaurants", "Featured in 'Lost in Translation'"],
                        image: "https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Modern Apartment in Shibuya",
                        type: "airbnb",
                        location: "Shibuya",
                        price: "৳15,800",
                        rating: 4.7,
                        features: ["Central location", "1 bedroom", "Pocket WiFi included", "Modern amenities"],
                        image: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Family-Friendly Rental Home",
                        type: "apartment",
                        location: "Asakusa",
                        price: "৳18,200",
                        rating: 4.6,
                        features: ["Traditional elements", "2 bedrooms", "Close to Sensō-ji Temple", "Fully equipped kitchen"],
                        image: "https://images.unsplash.com/photo-1554995207-c18c203602cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Tokyu Stay Shinjuku",
                        type: "hotel",
                        location: "Shinjuku",
                        price: "৳14,500",
                        rating: 4.5,
                        features: ["In-room washer/dryer", "Kitchenette", "Business center", "Central location"],
                        image: "https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Stylish Loft in Roppongi",
                        type: "airbnb",
                        location: "Roppongi",
                        price: "৳17,300",
                        rating: 4.8,
                        features: ["Nightlife district", "Modern design", "1 bedroom", "City views"],
                        image: "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    },
                    {
                        name: "Keio Plaza Hotel",
                        type: "hotel",
                        location: "Shinjuku",
                        price: "৳22,800",
                        rating: 4.7,
                        features: ["Swimming pool", "Multiple restaurants", "Shopping arcade", "Airport limousine stop"],
                        image: "https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    }
                ]
            },
            bangkok: {
                title: "Bangkok, Thailand",
                image: "https://images.unsplash.com/photo-1508009603885-50cf7c579365?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                price: "৳65,000",
                mlEnabled: false
            },
            dubai: {
                title: "Dubai, UAE",
                image: "https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                price: "৳95,000",
                mlEnabled: false
            },
            singapore: {
                title: "Singapore",
                image: "https://images.unsplash.com/photo-1525625293386-3f8f99389edd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                price: "৳72,000",
                mlEnabled: false
            },
            maldives: {
                title: "Maldives",
                image: "https://images.unsplash.com/photo-1514282401047-d79a71a590e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                price: "৳110,000",
                mlEnabled: false
            },
            paris: {
                title: "Paris, France",
                image: "https://images.unsplash.com/photo-1502602898657-3e91760cbb34?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                price: "৳145,000",
                mlEnabled: false
            }
        };

        // DOM elements
        const popularDestinationsContainer = document.getElementById('popular-destinations');
        const allDestinationsGrid = document.getElementById('all-destinations-grid');
        const viewMoreBtn = document.getElementById('view-more-btn');
        const backBtn = document.getElementById('back-btn');
        const backToHomeBtn = document.getElementById('back-to-home-btn');
        const searchBtn = document.getElementById('search-btn');
        const destinationSelect = document.getElementById('destination');
        const mlDestinationDetails = document.getElementById('ml-destination-details');
        const allDestinationsSection = document.getElementById('all-destinations-section');
        const destinationTitle = document.getElementById('destination-title');
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        const updatePredictionBtn = document.getElementById('update-prediction-btn');
        const predictionMonth = document.getElementById('prediction-month');
        const accommodationFilters = document.querySelectorAll('.accommodation-filter');
        const bookingModal = document.getElementById('booking-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const bookingForm = document.getElementById('booking-form');
        const confirmationModal = document.getElementById('confirmation-modal');
        const closeConfirmationBtn = document.getElementById('close-confirmation-btn');
        const destinationSearch = document.getElementById('destination-search');

        // Charts
        let flightPriceChart = null;
        let accommodationPriceChart = null;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Set today's date as the minimum date for check-in and check-out
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('checkin').min = today;
            document.getElementById('checkout').min = today;
            
            // Set default check-in and check-out dates (today + 30 days, today + 37 days)
            const defaultCheckin = new Date();
            defaultCheckin.setDate(defaultCheckin.getDate() + 30);
            const defaultCheckout = new Date();
            defaultCheckout.setDate(defaultCheckout.getDate() + 37);
            
            document.getElementById('checkin').value = defaultCheckin.toISOString().split('T')[0];
            document.getElementById('checkout').value = defaultCheckout.toISOString().split('T')[0];
            
            // Populate popular destinations
            populatePopularDestinations();
            
            // Event listeners
            setupEventListeners();
        });

        // Populate popular destinations
        function populatePopularDestinations() {
            const popularDestinations = ['bali', 'tokyo', 'bangkok', 'dubai'];
            
            popularDestinationsContainer.innerHTML = '';
            
            popularDestinations.forEach(destKey => {
                const dest = destinationData[destKey];
                const mlBadge = dest.mlEnabled ? 
                    `<span class="absolute top-4 right-4 bg-emerald-700 text-white text-xs font-bold px-2 py-1 rounded-full">ML Insights</span>` : '';
                
                const card = `
                    <div class="destination-card relative bg-white rounded-lg shadow-md overflow-hidden" data-destination="${destKey}">
                        ${mlBadge}
                        <div class="h-48 bg-cover bg-center" style="background-image: url('${dest.image}')"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">${dest.title}</h3>
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="ml-1 text-gray-700">From ${dest.price}</span>
                            </div>
                            <button class="explore-btn w-full bg-emerald-700 text-white py-2 rounded-md hover:bg-emerald-800 transition" data-destination="${destKey}">Explore</button>
                        </div>
                    </div>
                `;
                
                popularDestinationsContainer.innerHTML += card;
            });
            
            // Add event listeners to explore buttons
            document.querySelectorAll('.explore-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const destKey = this.getAttribute('data-destination');
                    showDestinationDetails(destKey);
                });
            });
        }

        // Populate all destinations
        function populateAllDestinations() {
            allDestinationsGrid.innerHTML = '';
            
            Object.keys(destinationData).forEach(destKey => {
                const dest = destinationData[destKey];
                const mlBadge = dest.mlEnabled ? 
                    `<span class="absolute top-4 right-4 bg-emerald-700 text-white text-xs font-bold px-2 py-1 rounded-full">ML Insights</span>` : '';
                
                const card = `
                    <div class="destination-card relative bg-white rounded-lg shadow-md overflow-hidden" data-destination="${destKey}">
                        ${mlBadge}
                        <div class="h-40 bg-cover bg-center" style="background-image: url('${dest.image}')"></div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2">${dest.title}</h3>
                            <div class="flex items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-700">From ${dest.price}</span>
                            </div>
                            <button class="explore-all-btn w-full bg-emerald-700 text-white py-1.5 text-sm rounded-md hover:bg-emerald-800 transition" data-destination="${destKey}">Explore</button>
                        </div>
                    </div>
                `;
                
                allDestinationsGrid.innerHTML += card;
            });
            
            // Add event listeners to explore buttons
            document.querySelectorAll('.explore-all-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const destKey = this.getAttribute('data-destination');
                    showDestinationDetails(destKey);
                });
            });
        }

        // Show destination details
        function showDestinationDetails(destKey) {
            const dest = destinationData[destKey];
            
            if (!dest.mlEnabled) {
                alert("ML insights are currently only available for Bali and Tokyo. Please select one of these destinations.");
                return;
            }
            
            // Set destination title
            destinationTitle.textContent = dest.title;
            
            // Populate overview tab
            document.getElementById('destination-highlights').innerHTML = dest.highlights;
            document.getElementById('best-time-content').innerHTML = dest.bestTime;
            
            // Populate quick facts
            const quickFactsList = document.getElementById('quick-facts');
            quickFactsList.innerHTML = '';
            dest.quickFacts.forEach(fact => {
                quickFactsList.innerHTML += `
                    <li class="flex items-start">
                        <span class="mr-2 text-xl">${fact.icon}</span>
                        <span>${fact.text}</span>
                    </li>
                `;
            });
            
            // Populate weather info
            const weatherInfo = document.getElementById('weather-info');
            weatherInfo.innerHTML = '';
            dest.weather.forEach(season => {
                weatherInfo.innerHTML += `
                    <div class="flex items-center justify-between">
                        <span class="font-medium">${season.month}</span>
                        <span class="text-gray-700">${season.temp}</span>
                        <span class="text-sm text-gray-600">${season.condition}</span>
                    </div>
                `;
            });
            
            // Populate trending places
            const trendingPlaces = document.getElementById('trending-places');
            trendingPlaces.innerHTML = '';
            dest.trendingPlaces.forEach(place => {
                trendingPlaces.innerHTML += `
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('${place.image}')"></div>
                        <div class="p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-2">${place.icon}</span>
                                <h4 class="text-lg font-bold">${place.name}</h4>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">${place.description}</p>
                            <div class="bg-emerald-50 text-emerald-800 text-xs font-medium px-2.5 py-1.5 rounded-full inline-block">
                                ${place.visitRate}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            // Populate popular activities
            const popularActivities = document.getElementById('popular-activities');
            popularActivities.innerHTML = '';
            dest.popularActivities.forEach(activity => {
                popularActivities.innerHTML += `
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('${activity.image}')"></div>
                        <div class="p-4">
                            <div class="flex items-center mb-2">
                                <span class="text-2xl mr-2">${activity.icon}</span>
                                <h4 class="text-lg font-bold">${activity.name}</h4>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">${activity.description}</p>
                            <div class="bg-blue-50 text-blue-800 text-xs font-medium px-2.5 py-1.5 rounded-full inline-block">
                                ${activity.popularity}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            // Populate accommodations
            populateAccommodations(dest.accommodations);
            
            // Populate prediction data
            populatePredictionData(destKey, 7);
            
            // Show ML destination details section
            mlDestinationDetails.classList.remove('hidden');
            allDestinationsSection.classList.add('hidden');
            
            // Scroll to top
            window.scrollTo(0, 0);
        }

        // Populate accommodations
        function populateAccommodations(accommodations, filter = 'all') {
            const accommodationsList = document.getElementById('accommodations-list');
            accommodationsList.innerHTML = '';
            
            accommodations.forEach(acc => {
                if (filter === 'all' || acc.type === filter) {
                    const featuresList = acc.features.map(feature => 
                        `<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded">${feature}</span>`
                    ).join('');
                    
                    accommodationsList.innerHTML += `
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="grid grid-cols-1 md:grid-cols-3">
                                <div class="md:col-span-1">
                                    <div class="h-full bg-cover bg-center" style="background-image: url('${acc.image}')"></div>
                                </div>
                                <div class="md:col-span-2 p-6">
                                    <h4 class="text-xl font-bold mb-2">${acc.name}</h4>
                                    <div class="flex items-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="ml-1 text-gray-700">${acc.rating}/5</span>
                                        <span class="mx-2 text-gray-400">•</span>
                                        <span class="text-gray-700">${acc.location}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2 mb-6">
                                        ${featuresList}
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-2xl font-bold text-emerald-700">${acc.price}</span>
                                            <span class="text-gray-500">/night</span>
                                        </div>
                                        <button class="book-now-btn bg-emerald-700 text-white px-4 py-2 rounded-md hover:bg-emerald-800 transition" data-accommodation='${JSON.stringify(acc)}'>Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
            
            // Add event listeners to book now buttons
            document.querySelectorAll('.book-now-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const accommodation = JSON.parse(this.getAttribute('data-accommodation'));
                    openBookingModal(accommodation);
                });
            });
        }

        // Populate prediction data
        function populatePredictionData(destKey, duration) {
            const dest = destinationData[destKey];
            const selectedMonth = parseInt(predictionMonth.value);
            
            // Populate budget time and best experience details
            document.getElementById('budget-time-details').innerHTML = dest.budgetTime;
            document.getElementById('best-experience-details').innerHTML = dest.bestExperience;
            
            // Create flight price chart
            createFlightPriceChart(dest.flightPrices[selectedMonth]);
            
            // Create accommodation price chart
            createAccommodationPriceChart(dest.accommodationPrices[selectedMonth]);
            
            // Calculate average prices
            const flightPrices = dest.flightPrices[selectedMonth].prices;
            const accommodationPrices = dest.accommodationPrices[selectedMonth].prices;
            
            const avgFlightPrice = Math.round(flightPrices.reduce((a, b) => a + b, 0) / flightPrices.length);
            const avgAccommodationPrice = Math.round(accommodationPrices.reduce((a, b) => a + b, 0) / accommodationPrices.length);
            const totalAccommodationCost = avgAccommodationPrice * duration;
            
            // Update prediction details
            document.getElementById('flight-prediction-details').innerHTML = `
                <div class="bg-gray-50 p-4 rounded-md">
                    <p class="font-medium">Average flight price for ${getMonthName(selectedMonth)}: <span class="text-emerald-700 font-bold">৳${avgFlightPrice.toLocaleString()}</span> (round trip from Dhaka)</p>
                    <p class="text-sm text-gray-600 mt-2">Prices may vary based on airline, booking time, and availability.</p>
                </div>
            `;
            
            document.getElementById('accommodation-prediction-details').innerHTML = `
                <div class="bg-gray-50 p-4 rounded-md">
                    <p class="font-medium">Average nightly rate for ${getMonthName(selectedMonth)}: <span class="text-emerald-700 font-bold">৳${avgAccommodationPrice.toLocaleString()}</span></p>
                    <p class="font-medium mt-1">Estimated total for ${duration} nights: <span class="text-emerald-700 font-bold">৳${totalAccommodationCost.toLocaleString()}</span></p>
                    <p class="text-sm text-gray-600 mt-2">Prices may vary based on location, property type, and availability.</p>
                </div>
            `;
        }

        // Create flight price chart
        function createFlightPriceChart(data) {
            const ctx = document.getElementById('flight-price-chart').getContext('2d');
            
            if (flightPriceChart) {
                flightPriceChart.destroy();
            }
            
            flightPriceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.days.map(day => `Day ${day}`),
                    datasets: [{
                        label: 'Flight Price (৳)',
                        data: data.prices,
                        borderColor: '#047857',
                        backgroundColor: 'rgba(4, 120, 87, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `৳${context.parsed.y.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                callback: function(value) {
                                    return '৳' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // Create accommodation price chart
        function createAccommodationPriceChart(data) {
            const ctx = document.getElementById('accommodation-price-chart').getContext('2d');
            
            if (accommodationPriceChart) {
                accommodationPriceChart.destroy();
            }
            
            accommodationPriceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.days.map(day => `Day ${day}`),
                    datasets: [{
                        label: 'Accommodation Price (৳)',
                        data: data.prices,
                        borderColor: '#0369a1',
                        backgroundColor: 'rgba(3, 105, 161, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `৳${context.parsed.y.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                callback: function(value) {
                                    return '৳' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // Open booking modal
        function openBookingModal(accommodation) {
            // Set accommodation details in modal
            document.getElementById('booking-modal-title').textContent = `Book Your Stay at ${accommodation.name}`;
            document.getElementById('booking-accommodation-image').style.backgroundImage = `url('${accommodation.image}')`;
            document.getElementById('booking-accommodation-name').textContent = accommodation.name;
            document.getElementById('booking-accommodation-rating').textContent = `${accommodation.rating}/5`;
            document.getElementById('booking-accommodation-location').textContent = accommodation.location;
            document.getElementById('booking-accommodation-price').textContent = accommodation.price;
            
            // Set features
            const featuresContainer = document.getElementById('booking-accommodation-features');
            featuresContainer.innerHTML = '';
            accommodation.features.forEach(feature => {
                featuresContainer.innerHTML += `
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-1 rounded">${feature}</span>
                `;
            });
            
            // Set check-in and check-out dates from search form
            document.getElementById('booking-checkin').value = document.getElementById('checkin').value;
            document.getElementById('booking-checkout').value = document.getElementById('checkout').value;
            
            // Show modal
            bookingModal.classList.add('active');
        }

        // Close booking modal
        function closeBookingModal() {
            bookingModal.classList.remove('active');
        }

        // Show confirmation modal
        function showConfirmationModal() {
            // Generate random booking reference
            const bookingRef = 'BT' + Math.floor(100000 + Math.random() * 900000);
            document.getElementById('booking-reference-number').textContent = bookingRef;
            
            // Hide booking modal and show confirmation modal
            bookingModal.classList.remove('active');
            confirmationModal.classList.add('active');
        }

        // Close confirmation modal
        function closeConfirmationModal() {
            confirmationModal.classList.remove('active');
        }

        // Helper function to get month name
        function getMonthName(monthIndex) {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            return months[monthIndex];
        }

        // Setup event listeners
        function setupEventListeners() {
            // View more button
            viewMoreBtn.addEventListener('click', function() {
                populateAllDestinations();
                allDestinationsSection.classList.remove('hidden');
                mlDestinationDetails.classList.add('hidden');
            });
            
            // Back button
            backBtn.addEventListener('click', function() {
                mlDestinationDetails.classList.add('hidden');
            });
            
            // Back to home button
            backToHomeBtn.addEventListener('click', function() {
                allDestinationsSection.classList.add('hidden');
            });
            
            // Search button
            searchBtn.addEventListener('click', function() {
                const selectedDestination = destinationSelect.value;
                if (selectedDestination) {
                    if (destinationData[selectedDestination].mlEnabled) {
                        showDestinationDetails(selectedDestination);
                    } else {
                        alert("ML insights are currently only available for Bali and Tokyo. Please select one of these destinations.");
                    }
                } else {
                    alert("Please select a destination.");
                }
            });
            
            // Tab buttons
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    
                    // Remove active class from all tabs
                    tabBtns.forEach(b => b.classList.remove('tab-active'));
                    tabContents.forEach(c => c.classList.add('hidden'));
                    
                    // Add active class to clicked tab
                    this.classList.add('tab-active');
                    document.getElementById(`${tabId}-content`).classList.remove('hidden');
                });
            });
            
            // Update prediction button
            updatePredictionBtn.addEventListener('click', function() {
                const destKey = destinationTitle.textContent.includes('Bali') ? 'bali' : 'tokyo';
                const duration = parseInt(document.getElementById('prediction-duration').value);
                populatePredictionData(destKey, duration);
            });
            
            // Accommodation filters
            accommodationFilters.forEach(filter => {
                filter.addEventListener('click', function() {
                    const filterType = this.getAttribute('data-filter');
                    const destKey = destinationTitle.textContent.includes('Bali') ? 'bali' : 'tokyo';
                    
                    // Update active filter
                    accommodationFilters.forEach(f => {
                        f.classList.remove('bg-emerald-700', 'text-white');
                        f.classList.add('bg-gray-200', 'text-gray-700');
                    });
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-emerald-700', 'text-white');
                    
                    // Filter accommodations
                    populateAccommodations(destinationData[destKey].accommodations, filterType);
                });
            });
            
            // Close modal button
            closeModalBtn.addEventListener('click', closeBookingModal);
            
            // Booking form submission
            bookingForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Generate booking reference
                const bookingRef = 'BT' + Math.floor(100000 + Math.random() * 900000);
                
                // Get current accommodation details
                const accommodationName = document.getElementById('booking-accommodation-name').textContent;
                const accommodationLocation = document.getElementById('booking-accommodation-location').textContent;
                
                // Create booking data object
                const bookingData = {
                    booking_reference: bookingRef,
                    full_name: document.getElementById('booking-name').value,
                    email: document.getElementById('booking-email').value,
                    phone: document.getElementById('booking-phone').value,
                    checkin: document.getElementById('booking-checkin').value,
                    checkout: document.getElementById('booking-checkout').value,
                    guests: document.getElementById('booking-guests').value,
                    accommodation_name: accommodationName,
                    accommodation_location: accommodationLocation,
                    special_requests: document.getElementById('booking-requests').value
                };

                try {
                    // Send booking data to server
                    const response = await fetch('process_booking.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(bookingData)
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        // Update booking reference in confirmation modal
                        document.getElementById('booking-reference-number').textContent = bookingRef;
                        
                        // Show confirmation modal
                        closeBookingModal();
                        confirmationModal.classList.add('active');
                    } else {
                        alert('Error creating booking: ' + result.message);
                    }
                } catch (error) {
                    alert('Error creating booking: ' + error.message);
                }
            });
            
            // Close confirmation button
            closeConfirmationBtn.addEventListener('click', closeConfirmationModal);
            
            // Destination search
            destinationSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const allDestinationCards = allDestinationsGrid.querySelectorAll('.destination-card');
                
                allDestinationCards.forEach(card => {
                    const destKey = card.getAttribute('data-destination');
                    const destTitle = destinationData[destKey].title.toLowerCase();
                    
                    if (destTitle.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'969827a07057a478',t:'MTc1NDI0ODY0My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
