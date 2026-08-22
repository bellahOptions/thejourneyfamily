<footer class="border-t border-[#d8cec0] bg-[#f7f4ee]">
    <div class="mx-auto max-w-6xl px-5 py-14 sm:px-8">
        <div class="grid gap-10 sm:grid-cols-3">
            <div>
                <img src="{{ asset('logo.png') }}" alt="The Journey Couples Retreat" class="h-auto w-32">
                <p class="mt-4 max-w-xs text-sm leading-6 text-[#52625c]">
                    {{ config('retreat.name') }} — a Christian-based retreat for homes, hosted at Redemption Camp.
                </p>
            </div>

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#23352f]">Payment details</p>
                <dl class="mt-4 space-y-2 text-sm text-[#52625c]">
                    <div><dt class="inline text-[#68766f]">Bank:</dt> <dd class="inline font-medium">{{ config('retreat.payment.bank_name') }}</dd></div>
                    <div><dt class="inline text-[#68766f]">Account name:</dt> <dd class="inline font-medium">{{ config('retreat.payment.account_name') }}</dd></div>
                    <div><dt class="inline text-[#68766f]">Account number:</dt> <dd class="inline font-medium">{{ config('retreat.payment.account_number') }}</dd></div>
                </dl>
            </div>

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#23352f]">Explore</p>
                <ul class="mt-4 space-y-2 text-sm text-[#52625c]">
                    <li><a href="{{ route('registrations.create') }}" class="hover:text-blue-600">Register</a></li>
                    <li><a href="{{ route('confessions.index') }}" class="hover:text-blue-600">Confessions</a></li>
                    <li><a href="{{ route('questions.create') }}" class="hover:text-blue-600">Ask a question</a></li>
                </ul>
            </div>
        </div>

        <p class="mt-12 text-xs text-[#68766f]">
            &copy; {{ now()->year }} {{ config('retreat.name') }}. All rights reserved.
        </p>
    </div>
</footer>
