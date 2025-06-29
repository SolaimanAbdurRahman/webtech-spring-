// CarRental Pro - Main JavaScript File

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeDatePickers();
    initializeVehicleFilters();
    initializeDamageCanvas();
    initializeFuelGauge();
    initializeLoyaltyCalculator();
    initializeToastNotifications();
    initializeCalendar();
    
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]:not([data-bs-toggle]):not([role="button"])').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            // Skip if href is just '#'
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Date Picker Initialization
function initializeDatePickers() {
    const pickupDate = document.getElementById('pickup_date');
    const returnDate = document.getElementById('return_date');
    
    if (pickupDate && returnDate) {
        // Set minimum date to today
        const today = new Date().toISOString().slice(0, 16);
        pickupDate.min = today;
        
        // Update return date minimum when pickup date changes
        pickupDate.addEventListener('change', function() {
            returnDate.min = this.value;
            if (returnDate.value && returnDate.value < this.value) {
                returnDate.value = this.value;
            }
            updatePricing();
        });
        
        returnDate.addEventListener('change', function() {
            updatePricing();
        });
    }
}

// Vehicle Filter System
function initializeVehicleFilters() {
    const filterForm = document.getElementById('vehicle-filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyVehicleFilters();
        });
    }
    
    // Real-time filter updates
    const filterInputs = document.querySelectorAll('.vehicle-filter');
    filterInputs.forEach(input => {
        input.addEventListener('change', applyVehicleFilters);
    });
}

function applyVehicleFilters() {
    const category = document.getElementById('category-filter')?.value;
    const priceMin = document.getElementById('price-min')?.value;
    const priceMax = document.getElementById('price-max')?.value;
    const transmission = document.getElementById('transmission-filter')?.value;
    const seats = document.getElementById('seats-filter')?.value;
    
    const vehicles = document.querySelectorAll('.vehicle-card');
    
    vehicles.forEach(vehicle => {
        let show = true;
        
        // Category filter
        if (category && vehicle.dataset.category !== category) {
            show = false;
        }
        
        // Price filter
        const price = parseFloat(vehicle.dataset.price);
        if (priceMin && price < parseFloat(priceMin)) {
            show = false;
        }
        if (priceMax && price > parseFloat(priceMax)) {
            show = false;
        }
        
        // Transmission filter
        if (transmission && vehicle.dataset.transmission !== transmission) {
            show = false;
        }
        
        // Seats filter
        if (seats && vehicle.dataset.seats !== seats) {
            show = false;
        }
        
        vehicle.style.display = show ? 'block' : 'none';
    });
    
    // Update availability count
    updateAvailabilityCount();
}

function updateAvailabilityCount() {
    const visibleVehicles = document.querySelectorAll('.vehicle-card[style*="block"], .vehicle-card:not([style*="none"])');
    const countElement = document.getElementById('available-count');
    if (countElement) {
        countElement.textContent = visibleVehicles.length;
    }
}

// Pricing Calculator
function updatePricing() {
    const pickupDate = document.getElementById('pickup_date')?.value;
    const returnDate = document.getElementById('return_date')?.value;
    const vehicleId = document.getElementById('vehicle_id')?.value;
    const insurancePackage = document.getElementById('insurance_package')?.value;
    
    if (pickupDate && returnDate && vehicleId) {
        const startDate = new Date(pickupDate);
        const endDate = new Date(returnDate);
        const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
        
        if (days > 0) {
            // Get vehicle daily rate
            const vehicleElement = document.querySelector(`[data-vehicle-id="${vehicleId}"]`);
            const dailyRate = vehicleElement ? parseFloat(vehicleElement.dataset.dailyRate) : 0;
            
            // Calculate base cost
            const baseCost = dailyRate * days;
            
            // Calculate insurance cost
            let insuranceCost = 0;
            if (insurancePackage) {
                const insuranceElement = document.querySelector(`[data-insurance-id="${insurancePackage}"]`);
                insuranceCost = insuranceElement ? parseFloat(insuranceElement.dataset.dailyRate) * days : 0;
            }
            
            // Calculate additional services cost
            const additionalServices = document.querySelectorAll('input[name="additional_services[]"]:checked');
            let servicesCost = 0;
            additionalServices.forEach(service => {
                const serviceElement = document.querySelector(`[data-service-id="${service.value}"]`);
                servicesCost += serviceElement ? parseFloat(serviceElement.dataset.dailyRate) * days : 0;
            });
            
            // Calculate total
            const subtotal = baseCost + insuranceCost + servicesCost;
            const tax = subtotal * 0.08; // 8% tax
            const total = subtotal + tax;
            
            // Update display
            updatePricingDisplay({
                days: days,
                baseCost: baseCost,
                insuranceCost: insuranceCost,
                servicesCost: servicesCost,
                tax: tax,
                total: total
            });
        }
    }
}

function updatePricingDisplay(pricing) {
    const elements = {
        'rental-days': pricing.days,
        'base-cost': formatCurrency(pricing.baseCost),
        'insurance-cost': formatCurrency(pricing.insuranceCost),
        'services-cost': formatCurrency(pricing.servicesCost),
        'tax-amount': formatCurrency(pricing.tax),
        'total-amount': formatCurrency(pricing.total)
    };
    
    Object.keys(elements).forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = elements[id];
        }
    });
}

// Damage Report Canvas
function initializeDamageCanvas() {
    const canvas = document.getElementById('damage-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let annotations = [];
        
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);
        
        function startDrawing(e) {
            isDrawing = true;
            draw(e);
        }
        
        function draw(e) {
            if (!isDrawing) return;
            
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            ctx.lineWidth = 3;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#dc3545';
            
            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }
        
        function stopDrawing() {
            isDrawing = false;
            ctx.beginPath();
        }
        
        // Clear canvas button
        const clearBtn = document.getElementById('clear-canvas');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                annotations = [];
            });
        }
    }
}

// Fuel Gauge
function initializeFuelGauge() {
    const fuelGauge = document.getElementById('fuel-gauge');
    if (fuelGauge) {
        const fuelLevel = fuelGauge.dataset.level || 'full';
        updateFuelGauge(fuelLevel);
    }
}

function updateFuelGauge(level) {
    const fuelGauge = document.getElementById('fuel-gauge');
    if (fuelGauge) {
        const fuelLevel = fuelGauge.querySelector('.fuel-level');
        fuelLevel.className = `fuel-level fuel-${level}`;
        
        // Update hidden input
        const fuelInput = document.getElementById('fuel_level');
        if (fuelInput) {
            fuelInput.value = level;
        }
    }
}

// Loyalty Program Calculator
function initializeLoyaltyCalculator() {
    const loyaltyForm = document.getElementById('loyalty-calculator');
    if (loyaltyForm) {
        loyaltyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateLoyaltyPoints();
        });
    }
}

function calculateLoyaltyPoints() {
    const amount = parseFloat(document.getElementById('rental-amount')?.value) || 0;
    const pointsPerDollar = 10; // 10 points per dollar
    const points = Math.floor(amount * pointsPerDollar);
    
    const pointsDisplay = document.getElementById('points-earned');
    if (pointsDisplay) {
        pointsDisplay.textContent = points;
    }
    
    // Calculate tier
    let tier = 'bronze';
    if (amount >= 1000) tier = 'platinum';
    else if (amount >= 500) tier = 'gold';
    else if (amount >= 100) tier = 'silver';
    
    const tierDisplay = document.getElementById('tier-level');
    if (tierDisplay) {
        tierDisplay.textContent = tier.charAt(0).toUpperCase() + tier.slice(1);
        tierDisplay.className = `tier-badge tier-${tier}`;
    }
}

// Calendar System
function initializeCalendar() {
    const calendar = document.getElementById('booking-calendar');
    if (calendar) {
        generateCalendar();
    }
}

function generateCalendar() {
    const calendar = document.getElementById('booking-calendar');
    const currentDate = new Date();
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDay = firstDay.getDay();
    
    let calendarHTML = `
        <div class="calendar-header">
            <h4>${new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</h4>
        </div>
        <div class="calendar-grid">
            <div class="calendar-day-header">Sun</div>
            <div class="calendar-day-header">Mon</div>
            <div class="calendar-day-header">Tue</div>
            <div class="calendar-day-header">Wed</div>
            <div class="calendar-day-header">Thu</div>
            <div class="calendar-day-header">Fri</div>
            <div class="calendar-day-header">Sat</div>
    `;
    
    // Add empty cells for days before the first day of the month
    for (let i = 0; i < startingDay; i++) {
        calendarHTML += '<div class="calendar-day empty"></div>';
    }
    
    // Add days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const isToday = date.toDateString() === currentDate.toDateString();
        const isPast = date < currentDate;
        const isAvailable = !isPast && Math.random() > 0.3; // Random availability for demo
        
        let dayClass = 'calendar-day';
        if (isToday) dayClass += ' today';
        if (isPast) dayClass += ' past';
        if (isAvailable) dayClass += ' available';
        else if (!isPast) dayClass += ' unavailable';
        
        calendarHTML += `<div class="${dayClass}" data-date="${date.toISOString().split('T')[0]}">${day}</div>`;
    }
    
    calendarHTML += '</div>';
    calendar.innerHTML = calendarHTML;
    
    // Add click handlers
    document.querySelectorAll('.calendar-day:not(.empty):not(.past)').forEach(day => {
        day.addEventListener('click', function() {
            const date = this.dataset.date;
            selectDate(date);
        });
    });
}

function selectDate(date) {
    // Remove previous selection
    document.querySelectorAll('.calendar-day.selected').forEach(day => {
        day.classList.remove('selected');
    });
    
    // Add selection to clicked date
    const selectedDay = document.querySelector(`[data-date="${date}"]`);
    if (selectedDay) {
        selectedDay.classList.add('selected');
    }
    
    // Update date inputs
    const pickupDate = document.getElementById('pickup_date');
    const returnDate = document.getElementById('return_date');
    
    if (pickupDate && !pickupDate.value) {
        pickupDate.value = date + 'T10:00';
    } else if (returnDate && !returnDate.value) {
        returnDate.value = date + 'T18:00';
    }
    
    updatePricing();
}

// Toast Notifications
function initializeToastNotifications() {
    // Create toast container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container';
        document.body.appendChild(toastContainer);
    }
}

function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast show bg-${type} text-white`;
    toast.innerHTML = `
        <div class="toast-body">
            ${message}
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

// Utility Functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// AJAX Helper Functions
function makeRequest(url, method = 'GET', data = null) {
    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: data ? JSON.stringify(data) : null
    })
    .then(response => response.json())
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'danger');
    });
}

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// Loading States
function setLoadingState(elementId, isLoading) {
    const element = document.getElementById(elementId);
    if (element) {
        if (isLoading) {
            element.disabled = true;
            element.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
        } else {
            element.disabled = false;
            element.innerHTML = element.dataset.originalText || 'Submit';
        }
    }
}

// Export functions for global use
window.CarRental = {
    showToast,
    formatCurrency,
    formatDate,
    makeRequest,
    validateForm,
    setLoadingState,
    updatePricing,
    updateFuelGauge,
    calculateLoyaltyPoints
}; 