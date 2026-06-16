<x-layout title="Client Home">
    <x-partials.client.nav :name="auth()->user()->full_name"></x-partials.client.nav>
    <main class="m-4">
        <section class="card bg-base-100">
            <div class="card-body gap-4 sm:gap-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-base-content/60">Client Home</p>
                        <h1 class="card-title text-3xl sm:text-4xl">My reservations</h1>
                        <p class="mt-2 max-w-2xl text-base-content/70">
                            Review your active bookings and past stays in one place.
                        </p>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <section class="card border border-base-300 bg-base-100">
                        <div class="card-body gap-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h2 class="card-title text-2xl">Current reservations</h2>
                                    <p class="text-sm text-base-content/60">Bookings that are still upcoming or in progress.</p>
                                </div> 
                                <div class="badge badge-outline">0</div>
                                
                            </div>

                            <div class="overflow-x-auto">
                                <table class="table table-zebra table-sm">
                                    <thead>
                                        <tr>
                                            <th>Reservation</th>
                                            <th>Room</th>
                                            <th>Check-in</th>
                                            <th>Check-out</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="py-10 text-center text-base-content/60">
                                                There are no current reservations.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <section class="card border border-base-300 bg-base-100">
                        <div class="card-body gap-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h2 class="card-title text-2xl">Past reservations</h2>
                                    <p class="text-sm text-base-content/60">Completed or archived reservations.</p>
                                </div>
                                <div class="badge badge-outline">0</div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="table table-zebra table-sm">
                                    <thead>
                                        <tr>
                                            <th>Reservation</th>
                                            <th>Room</th>
                                            <th>Stay</th>
                                            <th>Guests</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="py-10 text-center text-base-content/60">
                                                There are no past reservations.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>

                <section class="card bg-base-200">
                    <div class="card-body flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="max-w-2xl">
                            <h2 class="card-title text-2xl">No reservations yet</h2>
                            <p class="text-base-content/70">
                                Once you reserve a room, your current and past reservations will appear here.
                            </p>
                        </div>

                        <div class="card-actions">
                            <a href="/reserve-slot" class="btn btn-primary btn-wide">Reserve a room</a>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>
</x-layout>