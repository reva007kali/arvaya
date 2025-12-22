I will add `data-anim="fade-up"` and `data-duration="1.5s"` to all key sections and elements in `royal-luxury.blade.php` to create a smooth, slow animation effect as requested.

**Implementation Plan:**

1.  **Identify Target Elements**:
    *   **Hero/Cover**: Title, Names, Date, Guest Name.
    *   **Quote Section**: The main quote container.
    *   **Couple Section**: Groom & Bride photos, names, and details.
    *   **Event Section**: Event card, Countdown, Google Maps button.
    *   **Dress Code**: Main container or inner content.
    *   **Gallery**: Each photo item (staggered if possible, but uniform for now).
    *   **Gifts**: Each gift card.
    *   **RSVP & Wishes**: Form containers.
    *   **Thank You/Closing**: The closing message text.

2.  **Apply Attributes**:
    *   Add `data-anim="fade-up"` (or `fade-left`/`fade-right` for variety if appropriate, but user asked for data-anim generally, likely implied fade-up or similar) to these elements.
    *   Add `data-duration="1.5s"` to all these elements to slow down the animation.

3.  **Refine Existing Animations**:
    *   Update any existing `data-anim` attributes to include `data-duration="1.5s"`.

I will proceed with applying these changes systematically through the file.