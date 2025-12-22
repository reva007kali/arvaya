I will update `resources/views/livewire/dashboard/index.blade.php` so each invitation card shows the first event date from `event_data[0]`, not `created_at` or the raw array.

Changes:

* Use the already computed `$eventDate = isset($event['date']) ? Carbon::parse($event['date']) : null;`.

* Replace `{{ $invitation->event_data[0] }}` in the date pill with a formatted value like `{{ $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Tanggal belum ditentukan' }}`.

* Keep the existing icon and styling.

Fallbacks:

* If `event_data` is empty or the date is invalid, show "Tanggal belum ditentukan" to avoid errors.

