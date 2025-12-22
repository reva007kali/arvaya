I will update the main background image in the `royal-luxury.blade.php` template.

**Change:**
*   Currently, the background is using `bg-[url('/public/img/login.png')]`.
*   I will change this to use the first image from the **moments** gallery (`$moments[0]`).
*   If `$moments[0]` is not available, I will fallback to `$coverImage` (which already falls back to a default if needed).

**Implementation:**
*   Locate the main container `div` with class `bg-[url('/public/img/login.png')]`.
*   Replace the hardcoded URL with an inline style or dynamic class that uses `asset($moments[0] ?? $coverImage)`.
*   Since `bg-cover` and `bg-fixed` are already present, I will ensure they work with the dynamic image.

I will proceed with this update.