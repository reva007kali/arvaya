I will update `app/Livewire/Dashboard/Invitation/Edit.php` to handle larger file uploads with specific warnings and constraints as requested.

### Changes in `app/Livewire/Dashboard/Invitation/Edit.php`:

1.  **Increase Memory Limit**: In `processImage()`, temporarily increase PHP memory limit to `512M` to safely handle processing/resizing of large (up to 20MB) high-resolution photos.
2.  **Custom Validation Messages**: Add a `messages()` method to define custom error messages:
    -   For files > 20MB: Reject and suggest using online tools like **iloveimg.com** or **tinypng.com**.
3.  **Realtime Validation Hooks**: Implement `updatedNewCover`, `updatedNewGroom`, and `updatedNewBride` methods to:
    -   Validate file size (`max:20480` aka 20MB).
    -   Check if file > 10MB: Dispatch a "Warning" notification that upload/processing may take longer.
4.  **Update `updatedNewMoments`**:
    -   Increase validation limit to 20MB.
    -   Add the same >10MB warning logic for gallery uploads.

This ensures the system accepts professional camera photos (up to 20MB) while managing user expectations regarding processing time and preventing server crashes.