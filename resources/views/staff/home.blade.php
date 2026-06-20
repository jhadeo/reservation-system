<x-layout>
    <x-partials.staff.nav :name="auth()->user()->full_name" />

    <h2 class="text-2xl font-bold mb-6">Current Reservations</h2>

    @if($reservations->isEmpty())
    <div role="alert" class="alert alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>No active reservations at the moment.</span>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->user?->full_name ?? 'N/A' }}</td>
                    <td>{{ $reservation->room?->name ?? 'N/A' }}</td>
                    <td>{{ $reservation->check_in_datetime?->format('M d, Y H:i') ?? 'N/A'}}</td>
                    <td>{{ $reservation->check_out_datetime?->format('M d, Y H:i') ?? 'N/A'}}</td>
                    <td>
                        <span class="badge badge-{{ match($reservation->status->value) {
                                        'pending' => 'warning',
                                        'reserved' => 'info',
                                        'active' => 'success',
                                        default => 'ghost'
                                    } }}">
                            {{ ucfirst($reservation->status->value) }}
                    <td>
                        <span class="badge badge-{{ match($reservation->payment_status?->value) {
                                        'paid' => 'success',
                                        'pending' => 'warning',
                                        'failed' => 'error',
                                        default => 'ghost'
                                    } }}">
                            {{ ucfirst($reservation->payment_status?->value ?? 'unknown') }}
                        </span>
                    </td>
                    </td>
                    <td>
                        <span class="badge badge-{{ match($reservation->payment_status?->value) {
                                        'paid' => 'success',
                                        'pending' => 'warning',
                                        'failed' => 'error',
                                        default => 'ghost'
                                    } }}">
                            {{ ucfirst($reservation->payment_status?->value ?? 'unknown') }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    </div>
</x-layout>