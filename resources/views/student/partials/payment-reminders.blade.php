@if (($paymentReminders ?? collect())->isNotEmpty())
    <section class="payment-reminders" aria-label="Payment reminders">
        @foreach ($paymentReminders as $bill)
            @php($isOverdue = $bill->due_date->isBefore(today()))
            <div class="payment-reminder {{ $isOverdue ? 'payment-reminder--overdue' : 'payment-reminder--due' }}" role="status">
                <span class="payment-reminder-icon" aria-hidden="true">
                    <i class="fa-solid {{ $isOverdue ? 'fa-triangle-exclamation' : 'fa-bell' }}"></i>
                </span>
                <div class="payment-reminder-content">
                    <div class="payment-reminder-heading">
                        <strong>{{ $isOverdue ? 'Overdue payment' : ($bill->due_date->isToday() ? 'Payment due today' : 'Payment due soon') }}</strong>
                        <span class="payment-reminder-due">Due {{ $bill->due_date->format('M d, Y') }}</span>
                    </div>
                    <div class="payment-reminder-details">
                        <span>Bill for {{ $bill->billing_month->format('F Y') }}</span>
                        <span>Outstanding: <strong>&#8369;{{ number_format($bill->reminderBalance(), 2) }}</strong></span>
                    </div>
                    @if ($bill->payments->contains(fn ($payment) => $payment->status === 'pending'))
                        <small>A submitted payment is awaiting administrator verification.</small>
                    @endif
                </div>
                <a class="payment-reminder-action" href="{{ route('payments') }}">Review payment <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        @endforeach
    </section>
@endif
