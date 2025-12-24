I will update the **Manage Templates** feature to include image compression, fix the missing preview URL input, and restore the image preview functionality.

### **Plan:**

1.  **Backend: `app/Livewire/Admin/ManageTemplates.php`**
    *   **Optimize Query**: Change `Template::latest()->get()` to `Template::select(...)->latest()->get()` to fetch only necessary columns.
    *   **Add Properties**: Add `$preview_url` and `$oldThumbnail` (to hold the existing image path during editing).
    *   **Implement Image Compression**: Use `Intervention Image` (v3) to resize (scale width to 800px) and compress (WebP quality 80) uploaded thumbnails before saving them to storage.
    *   **Update Logic**:
        *   `edit()`: Populate `$preview_url` and `$oldThumbnail`.
        *   `save()`: Handle the `preview_url` field and the new image compression logic.

2.  **Frontend: `resources/views/livewire/admin/manage-templates.blade.php`**
    *   **Add Input**: Insert a text input field for **Preview URL** (e.g., for linking to a live demo).
    *   **Fix Image Preview**:
        *   Logic: If a new file is uploaded (`$thumbnail`), show `temporaryUrl()`.
        *   Else if editing an existing template (`$oldThumbnail`), show the stored image `asset(...)`.
    *   **UI Cleanup**: Ensure the form layout is clean and responsive.

I will proceed with these changes.