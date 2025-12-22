## Dashboard Card Redesign
- Replace expandable/mobile dropdown card with a compact “ATM-size” card.
- Card contents:
  - Cover picture from `gallery_data['cover']` (fallback to default).
  - Invitation title `title`.
  - First event date from `event_data[0]['date']` formatted with Carbon.
  - Template used: resolve via `Invitation::template()` relation; show template name/tier if available, else slug.
  - Small payment status badge using `payment_status`.
- Make entire card clickable to `route('dashboard.invitation.edit', $invitation->id)`; remove `x-data="{ expanded: false }"` and related dropdown logic.
- Files:
  - Edit `resources/views/livewire/dashboard/index.blade.php` around the card block (see lines near 166–186) to output the new condensed markup.
  - Keep hero/swiper banner intact.

## Dashboard Search Bar
- Add a search input above the grid to filter invitations by `title` or `slug`.
- Livewire changes:
  - Update `App\Livewire\Dashboard\Index` to include `public $search = ''` and filter the query: `Auth::user()->invitations()->where('title','like',"%$this->search%")->orWhere('slug','like',"%$this->search%")...`.
  - View changes in `resources/views/livewire/dashboard/index.blade.php`: add an input with `wire:model.live.debounce.300ms="search"` and a magnifier icon.
- Behavior: shows filtered results as the user types.

## Invitation Edit Page Header Stats
- At the top of `resources/views/livewire/dashboard/invitation/edit.blade.php`, add a summary header with:
  - Views: `visit_count`.
  - Guest count: `$invitation->guests()->count()`.
  - Reservation data breakdown: counts of guests by `rsvp_status` from `App\Models\Guest` constants.
  - Message count: `$invitation->messages()->count()`.
  - Template used and payment status badge.
- Keep existing tabs (Bio/Quote/Events/Gallery/Gifts/Theme/Music/DressCode/Closing) below the summary.

## Music Play Button (No Video)
- In the edit page header, add a small play/pause button to preview `theme.music_url`.
- If the URL is a direct audio (e.g., `.mp3`), use a hidden `<audio>` element; if it’s not audio, disable the button with a tooltip.
- No embedded video; strictly audio preview.

## Data and Formatting
- Event date formatting consistent with templates: `translatedFormat('l, d F Y')`.
- Fallbacks:
  - Cover image: default Unsplash if missing.
  - Event date: show `Tanggal belum ditentukan` if absent.
  - Template name: show slug if related `Template` record missing.

## Files To Modify
- `app/Livewire/Dashboard/Index.php`: add `search` property and filtered query.
- `resources/views/livewire/dashboard/index.blade.php`: new card markup + search bar.
- `resources/views/livewire/dashboard/invitation/edit.blade.php`: add header summary and audio preview button.

## Notes & Consistency
- Use existing styling tokens and classes to match current UI.
- Keep accessibility: alt tags on images; readable badges.
- No changes to migrations or data schema.

## Verification
- Confirm card links navigate to edit page.
- Test search filtering and empty state.
- Validate date formatting and fallbacks.
- Ensure audio button does not throw errors when URL is not audio.

If you approve, I will implement these changes in the listed files and verify with the app’s existing Livewire flows.