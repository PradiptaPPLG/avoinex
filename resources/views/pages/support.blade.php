@extends('layouts.app')

@section('title', 'Help & Support - Avoinex')

@section('content')
<div class="avx-support-bg pb-5">
    <!-- Header Hero Section -->
    <div class="avx-support-hero text-center text-white pb-5 pt-0">
        <div class="container py-5">
            <h1 class="display-5 fw-bold mb-3">How can we help you?</h1>
            <p class="lead mb-4 opacity-75">Search our knowledge base or browse categories below</p>
            
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-white border-0 text-muted px-4">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="faqSearch" class="form-control border-0 px-3 py-3" placeholder="e.g., How to change my flight?">
                        <button class="btn btn-primary px-4 fw-bold" type="button">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: -40px;">
        <!-- Quick Links Cards -->
        <div class="row g-4 mb-5 justify-content-center">
            <div class="col-md-4">
                <a href="{{ route('booking.index') }}" class="text-decoration-none">
                    <div class="card h-100 avx-support-card border-0 shadow-sm text-center p-4">
                        <div class="avx-icon-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                            <i class="bi bi-ticket-detailed"></i>
                        </div>
                        <h4 class="h5 fw-bold text-dark mb-2">My Bookings</h4>
                        <p class="text-muted small mb-0">View, modify, or cancel your existing flight reservations.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('booking.find.form') }}" class="text-decoration-none">
                    <div class="card h-100 avx-support-card border-0 shadow-sm text-center p-4">
                        <div class="avx-icon-circle bg-success bg-opacity-10 text-success mx-auto mb-3">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4 class="h5 fw-bold text-dark mb-2">Find E-Ticket</h4>
                        <p class="text-muted small mb-0">Retrieve your booking using your booking code and email.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="text-decoration-none">
                    <div class="card h-100 avx-support-card border-0 shadow-sm text-center p-4">
                        <div class="avx-icon-circle bg-warning bg-opacity-10 text-warning mx-auto mb-3">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <h4 class="h5 fw-bold text-dark mb-2">Baggage Info</h4>
                        <p class="text-muted small mb-0">Learn about our cabin and checked baggage allowances.</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden avx-faq-card">
            <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="fw-bold mb-0"><i class="bi bi-question-circle text-primary me-2"></i> Frequently Asked Questions</h3>
                <span id="noResultsMsg" class="text-muted small d-none mt-2 mt-md-0">No results found</span>
            </div>
            <div class="card-body p-4 pt-2">
                <div class="accordion accordion-flush" id="faqAccordion">
                    
                    <!-- FAQ 1 -->
                    <div class="accordion-item faq-item border-bottom">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed fw-semibold py-3 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                How do I receive my E-Ticket?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted px-1 pb-4">
                                Once your payment is confirmed, an E-Ticket will be automatically sent to the email address you provided during the booking process. If you booked as a guest, please check the email you entered in the Contact Details section. You can also retrieve your ticket anytime using the <a href="{{ route('booking.find.form') }}">Find Booking</a> page.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item faq-item border-bottom">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed fw-semibold py-3 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Can I change or cancel my flight?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted px-1 pb-4">
                                Yes, you can change or cancel your flight depending on the fare conditions of your ticket. If you have an account, you can manage this from the 'My Bookings' section. Cancellation fees may apply. Flash Sale tickets are generally non-refundable.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="accordion-item faq-item border-bottom">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed fw-semibold py-3 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                What is the baggage allowance?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted px-1 pb-4">
                                Economy class passengers are generally entitled to 1 piece of cabin baggage (up to 7kg). Checked baggage can be purchased during the booking process, with options ranging from 20kg to 60kg. Business class passengers receive complimentary checked baggage allowances.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="accordion-item faq-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed fw-semibold py-3 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                How early should I arrive at the airport?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted px-1 pb-4">
                                We recommend arriving at the airport at least 2 hours before departure for domestic flights, and 3 hours for international flights. Check-in counters typically close strictly 45 minutes prior to scheduled departure.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <h3 class="fw-bold mb-4 text-center">Contact Support</h3>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 avx-contact-card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="avx-contact-icon mx-auto mb-3 bg-success bg-opacity-10 text-success">
                        <i class="bi bi-whatsapp fs-3"></i>
                    </div>
                    <h4 class="fw-bold h5">WhatsApp Support</h4>
                    <p class="text-muted small mb-2">Chat with our team via WhatsApp.</p>
                    <div class="mb-3">
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-semibold">Usually replies in minutes</span>
                    </div>
                    <div class="fw-bold text-dark mb-3">+62 852-1958-3336</div>
                    <a href="https://wa.me/6285219583336?text=Halo%20Avoinex%2C%20saya%20butuh%20bantuan%20terkait%20booking%20saya" target="_blank" class="btn btn-success fw-bold px-4 rounded-pill mt-auto">Open Chat</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 avx-contact-card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="avx-contact-icon mx-auto mb-3 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-chat-dots-fill fs-3"></i>
                    </div>
                    <h4 class="fw-bold h5">Live Chat</h4>
                    <p class="text-muted small mb-2">Our support team is available 24/7 to assist you.</p>
                    <div class="mb-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold">Available 24/7</span>
                    </div>
                    <button class="btn btn-outline-primary fw-bold px-4 rounded-pill mt-auto" onclick="toggleChatbot()">Start Live Chat</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 avx-contact-card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="avx-contact-icon mx-auto mb-3 bg-info bg-opacity-10 text-info">
                        <i class="bi bi-envelope-paper-fill fs-3"></i>
                    </div>
                    <h4 class="fw-bold h5">Email Support</h4>
                    <p class="text-muted small mb-2">Send us an email and we'll reply within 24 hours.</p>
                    <div class="mb-3">
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2 fw-semibold">Best for complex queries</span>
                    </div>
                    <div class="fw-bold text-dark mb-3">support@avoinex.com</div>
                    <a href="mailto:support@avoinex.com" class="btn btn-primary fw-bold px-4 rounded-pill mt-auto">Send Email</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/6285219583336?text=Halo%20Avoinex%2C%20saya%20butuh%20bantuan%20terkait%20booking%20saya" target="_blank" class="avx-floating-wa shadow-lg">
    <i class="bi bi-whatsapp"></i>
</a>

<!-- Simple Chatbot UI (Hidden by default) -->
<div class="avx-chatbot-container shadow-lg" id="chatbotContainer">
    <div class="avx-chatbot-header bg-primary text-white p-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="avx-chatbot-avatar bg-white text-primary me-2">
                <i class="bi bi-robot"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold">Avoinex Assistant</h6>
                <small class="opacity-75" style="font-size: 0.75rem;">Usually replies instantly</small>
            </div>
        </div>
        <button class="btn btn-sm text-white border-0 bg-transparent" onclick="toggleChatbot()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <div class="avx-chatbot-messages p-3" id="chatbotMessages">
        <div class="d-flex mb-3 text-center justify-content-center">
            <span class="badge bg-light text-muted fw-normal rounded-pill px-3 py-1">Today</span>
        </div>
        <div class="avx-chatbot-message bot mb-3">
            <div class="avx-chatbot-bubble">
                Hello! I'm Avoinex Assistant. How can I help you today?
            </div>
            <div class="avx-chatbot-time text-muted small mt-1">Just now</div>
        </div>
    </div>
    <div class="avx-chatbot-input border-top p-3 bg-white">
        <div class="input-group">
            <input type="text" class="form-control border-light shadow-sm rounded-pill px-3" placeholder="Type a message..." aria-label="Type a message">
            <button class="btn btn-primary rounded-circle ms-2 shadow-sm d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;" type="button">
                <i class="bi bi-send-fill" style="margin-right: -2px;"></i>
            </button>
        </div>
    </div>
</div>

<style>
.avx-support-bg {
    background-color: #f8fbff;
    min-height: 80vh;
}
.avx-support-hero {
    background: linear-gradient(135deg, #11549D 0%, #279ED6 100%);
    padding-bottom: 60px !important;
}
.avx-support-hero .input-group {
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
}
.avx-support-hero .input-group:focus-within {
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2) !important;
}
.avx-support-hero .form-control:focus {
    box-shadow: none;
}
.avx-support-card {
    border-radius: 16px;
    transition: all 0.3s ease;
}
.avx-support-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
}
.avx-faq-card {
    transition: all 0.3s ease;
}
.avx-faq-card:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important;
}
.avx-contact-card {
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}
.avx-contact-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}
.avx-icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.avx-contact-icon {
    width: 70px;
    height: 70px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.accordion-button:not(.collapsed) {
    background-color: transparent;
    color: #279ED6;
    box-shadow: none;
}
.accordion-button:focus {
    box-shadow: none;
}
.faq-item {
    transition: all 0.2s ease;
}

/* Floating WA Button */
.avx-floating-wa {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    z-index: 999;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.avx-floating-wa:hover {
    transform: scale(1.1);
    color: white;
    box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4) !important;
}

/* Chatbot UI */
.avx-chatbot-container {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 350px;
    height: 500px;
    background: #f8fbff;
    border-radius: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform: scale(0);
    transform-origin: bottom right;
    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    opacity: 0;
    pointer-events: none;
}
.avx-chatbot-container.active {
    transform: scale(1);
    opacity: 1;
    pointer-events: all;
}
.avx-chatbot-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
.avx-chatbot-messages {
    flex: 1;
    overflow-y: auto;
    background-color: #f0f4f8;
}
.avx-chatbot-message.bot .avx-chatbot-bubble {
    background: white;
    color: #333;
    padding: 12px 16px;
    border-radius: 16px;
    border-top-left-radius: 4px;
    display: inline-block;
    max-width: 85%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.avx-chatbot-message.bot .avx-chatbot-time {
    margin-left: 5px;
}
.avx-chatbot-message.user {
    text-align: right;
}
.avx-chatbot-message.user .avx-chatbot-bubble {
    background: #11549D;
    color: white;
    padding: 12px 16px;
    border-radius: 16px;
    border-top-right-radius: 4px;
    display: inline-block;
    max-width: 85%;
    text-align: left;
    box-shadow: 0 2px 5px rgba(17, 84, 157, 0.2);
}

@media (max-width: 768px) {
    .avx-chatbot-container {
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        border-radius: 0;
    }
    .avx-floating-wa {
        bottom: 20px;
        right: 20px;
        width: 55px;
        height: 55px;
        font-size: 28px;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. FAQ Accordion Manual Toggle (Fallback if Bootstrap JS is missing)
    const accordionButtons = document.querySelectorAll('.accordion-button');
    accordionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            const targetContent = document.querySelector(targetId);
            const isCurrentlyOpen = !this.classList.contains('collapsed');
            
            // Close all items first (Flush behavior)
            document.querySelectorAll('.accordion-collapse.show').forEach(el => el.classList.remove('show'));
            document.querySelectorAll('.accordion-button:not(.collapsed)').forEach(btn => {
                btn.classList.add('collapsed');
                btn.setAttribute('aria-expanded', 'false');
            });
            
            // If it was closed, open it now
            if (!isCurrentlyOpen && targetContent) {
                this.classList.remove('collapsed');
                this.setAttribute('aria-expanded', 'true');
                targetContent.classList.add('show');
            }
        });
    });

    // 2. FAQ Live Search
    const searchInput = document.getElementById('faqSearch');
    const searchBtn = searchInput.nextElementSibling;
    const faqItems = document.querySelectorAll('.faq-item');
    const noResultsMsg = document.getElementById('noResultsMsg');

    function filterFAQs() {
        const query = searchInput.value.toLowerCase().trim();
        let hasVisible = false;

        faqItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
            
            if (question.includes(query) || answer.includes(query)) {
                item.style.display = 'block';
                hasVisible = true;
                
                // If there's a search term, expand matching items, else collapse them
                const collapseBtn = item.querySelector('.accordion-button');
                const collapseBody = item.querySelector('.accordion-collapse');
                
                if (query !== '') {
                    collapseBtn.classList.remove('collapsed');
                    collapseBody.classList.add('show');
                } else {
                    collapseBtn.classList.add('collapsed');
                    collapseBody.classList.remove('show');
                }
            } else {
                item.style.display = 'none';
            }
        });

        if (!hasVisible && query !== '') {
            noResultsMsg.classList.remove('d-none');
        } else {
            noResultsMsg.classList.add('d-none');
        }
    }

    searchInput.addEventListener('input', filterFAQs);
    searchBtn.addEventListener('click', filterFAQs);
});

// Chatbot Toggle
function toggleChatbot() {
    const container = document.getElementById('chatbotContainer');
    container.classList.toggle('active');
}
</script>
@endpush
@endsection
