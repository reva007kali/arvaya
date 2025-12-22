I will implement a background slideshow feature for the **Royal Luxury** template, specifically tailored for desktop view.

**Requirements:**
*   **Desktop Only:** The main invitation content will be centered (`max-w-sm` as existing).
*   **Background:** Instead of a static image, I will implement a slideshow of the "Moments" images.
*   **Layout:** The slideshow will appear on the left and right sides of the centered invitation on larger screens. On mobile, it will likely just be the background behind the content.
*   **Source:** Use `$moments` array. If empty, fallback to `$coverImage`.

**Implementation Plan:**
1.  **Modify Main Container:** Change the outer wrapper to support the slideshow logic.
2.  **Add Slideshow Script/Logic:**
    *   I'll use Alpine.js (since it's already used for countdown) to handle a simple crossfade slideshow.
    *   The slideshow will be `absolute inset-0` behind the main content `div`.
3.  **Images:** I will iterate through `$moments` to generate the slide elements.
4.  **Styling:** Ensure the slides cover the screen (`bg-cover`) and fade smoothly.

I will update `royal-luxury.blade.php` now.