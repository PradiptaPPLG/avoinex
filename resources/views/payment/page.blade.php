@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Payment Method</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->booking_id }}">
                        
                        <div class="mb-4">
                            <h6>Select Payment Method</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                <label class="form-check-label" for="credit_card">
                                    <i class="bi bi-credit-card"></i> Credit/Debit Card
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                <label class="form-check-label" for="bank_transfer">
                                    <i class="bi bi-bank"></i> Bank Transfer
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="ewallet" value="ewallet">
                                <label class="form-check-label" for="ewallet">
                                    <i class="bi bi-wallet2"></i> E-Wallet
                                </label>
                            </div>
                        </div>

                        <!-- Simulasi kartu kredit -->
                        <div id="credit-card-form">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" class="form-control" placeholder="1234 5678 9012 3456" value="4111111111111111">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" placeholder="MM/YY" value="12/30">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-control" placeholder="123" value="123">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Cardholder Name</label>
                                    <input type="text" class="form-control" value="{{ $booking->client->first_name }} {{ $booking->client->last_name }}">
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> This is a demo payment. No real transaction will be processed.
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-lock"></i> Pay Now ${{ number_format($booking->total_price_usd, 2) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <h6>Booking #{{ $booking->booking_code ?? 'PENDING' }}</h6>
                    <p class="mb-1"><strong>{{ $booking->flightInstance->schedule->flight_number }}</strong></p>
                    <p class="mb-1">{{ $booking->flightInstance->schedule->originAirport->city }} → 
                        {{ $booking->flightInstance->schedule->destinationAirport->city }}</p>
                    <p class="mb-3">{{ $booking->flightInstance->flight_date->format('d M Y') }}</p>
                    
                    <h6>Passengers</h6>
                    <ul class="list-unstyled">
                        @foreach($booking->bookingSeats as $seat)
                        <li class="mb-1">
                            <small>{{ $seat->passenger_first_name }} {{ $seat->passenger_last_name }}</small>
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="border-top pt-3">
                        <table class="table table-sm">
                            <tr>
                                <th>Total Amount</th>
                                <th class="text-end">${{ number_format($booking->total_price_usd, 2) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tampilkan form sesuai payment method
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('credit-card-form').style.display = 
            this.value === 'credit_card' ? 'block' : 'none';
    });
});
</script>
@endsection