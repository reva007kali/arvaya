I will implement the realtime updates and conditional UI for the Gallery tab as requested.

### Backend Changes (`app/Livewire/Dashboard/Invitation/Edit.php`)
1.  **Update `removeMoment`**: Add `$this->invitation->update(['gallery_data' => $this->gallery]);` to ensure deletions are saved to the database immediately.

### Frontend Changes (`resources/views/livewire/dashboard/invitation/partials/tabs/gallery.blade.php`)
1.  **Remove `wire:ignore`**: Remove the `wire:ignore` directive from the gallery list container. This is the root cause of the "not refreshing" issue, as it prevents Livewire from updating the DOM when photos are added or removed.
2.  **Conditional UI Logic**:
    -   **Empty State**: When `count($gallery['moments']) == 0`, display the existing **Big Upload Box**.
    -   **Populated State**: When photos exist, hide the Big Box and instead show a **"Tambah Foto" (Add Photo) button** next to the header.
3.  **Unified Upload Input**: Create a single hidden file input linked to `wire:model="newMoments"` that can be triggered by either the Big Box or the Add Button.
4.  **Wire Keys**: Add `wire:key` to the list items to help Livewire track DOM elements correctly during updates and reordering.
5.  **Loading State**: Ensure the loading/uploading spinner is visible in both states.

This approach ensures that as soon as a user uploads or deletes a photo, the changes are saved to the database and immediately reflected in the UI without requiring a page refresh.