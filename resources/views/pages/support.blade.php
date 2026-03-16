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
                        <input type="text" class="form-control border-0 px-3 py-3" placeholder="e.g., How to change my flight?">
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
                <div class="card h-100 avx-support-card border-0 shadow-sm text-center p-4" style="cursor: pointer;">
                    <div class="avx-icon-circle bg-warning bg-opacity-10 text-warning mx-auto mb-3">
                        <i class="bi bi-suitcase"></i>
                    </div>
                    <h4 class="h5 fw-bold text-dark mb-2">Baggage Info</h4>
                    <p class="text-muted small mb-0">Learn about our cabin and checked baggage allowances.</p>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 p-4 pb-0">
                <h3 class="fw-bold mb-0"><i class="bi bi-question-circle text-primary me-2"></i> Frequently Asked Questions</h3>
            </div>
            <div class="card-body p-4">
                <div class="accordion accordion-flush" id="faqAccordion">
                    
                    <!-- FAQ 1 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold py-3 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How do I receive my E-Ticket?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted px-1 pb-4">
                                Once your payment is confirmed, an E-Ticket will be automatically sent to the email address you provided during the booking process. If you booked as a guest, please check the email you entered in the Contact Details section. You can also retrieve your ticket anytime using the <a href="{{ route('booking.find.form') }}">Find Booking</a> page.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold py-3 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Can I change or cancel my flight?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted px-1 pb-4">
                                Yes, you can change or cancel your flight depending on the fare conditions of your ticket. If you have an account, you can manage this from the 'My Bookings' section. Cancellation fees may apply. Flash Sale tickets are generally non-refundable.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="accordion-item border-bottom">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold py-3 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What is the baggage allowance?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted px-1 pb-4">
                                Economy class passengers are generally entitled to 1 piece of cabin baggage (up to 7kg). Checked baggage can be purchased during the booking process, with options ranging from 20kg to 60kg. Business class passengers receive complimentary checked baggage allowances.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold py-3 px-1" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How early should I arrive at the airport?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted px-1 pb-4">
                                We recommend arriving at the airport at least 2 hours before departure for domestic flights, and 3 hours for international flights. Check-in counters typically close strictly 45 minutes prior to scheduled departure.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="avx-contact-icon mx-auto mb-3 bg-light text-primary">
                        <i class="bi bi-chat-dots-fill fs-3"></i>
                    </div>
                    <h4 class="fw-bold h5">Chat with Us</h4>
                    <p class="text-muted small mb-4">Our support team is available 24/7 to assist you with any inquiries.</p>
                    <button class="btn btn-outline-primary fw-bold px-4 rounded-pill">Start Live Chat</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="avx-contact-icon mx-auto mb-3 bg-light text-primary">
                        <i class="bi bi-envelope-paper-fill fs-3"></i>
                    </div>
                    <h4 class="fw-bold h5">Email Support</h4>
                    <p class="text-muted small mb-4">Send us an email and we'll get back to you within 24 hours.</p>
                    <a href="mailto:support@avoinex.com" class="btn btn-primary fw-bold px-4 rounded-pill">support@avoinex.com</a>
                </div>
            </div>
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
</style>
@endsection
