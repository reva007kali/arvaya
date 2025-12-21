I will update `regular.blade.php` to match the "Premium White Floral" design shown in the images.

**Key Changes:**

1. **Visual Style (CSS Variables):**

   * **Background:** Switch from Dark Royal (#121212) to **Light Paper/Floral White (#F3F4F6)**.

   * **Text:** Switch from Gold/White to **Dark Charcoal (#333)** and **Elegant Serif**.

   * **Accent:** Add **Purple (#9333EA)** for borders and highlights (as seen in the Groom's photo border).

   * **Fonts:** Keep `Cinzel` (Serif) and `Great Vibes` (Script) but adjust weights and sizes to match the reference.

2. **Hero Section:**

   * Remove dark overlays.

   * Add **Embossed Floral Decoration** (using CSS/SVG pattern) at top and bottom corners.

   * Center "The Wedding of" (Serif).

   * Style "Xavier & Yuna" in large **Script Font**.

   * Add **Bird Silhouette Icon**.

   * Style "Open" button as a minimal pill-shaped button.

3. **Couple Profile Section:**

   * Change layout to **Vertical Stack**.

   * Add **Vertical "Groom" / "Bride" text** on the left side of the photo.

   * Add **Purple Border** to couple photos.

   * Make photos grayscale by default (as per reference).

   * Style names in **Serif Uppercase**.

4. **RSVP & Gift Section:**

   * **RSVP:** Style as a "floating paper card" with shadow effect.

   * **Gift:** Add the **Two-Card Illustration** (using rotated icons) and clean typography.

   * Implement **Feature Gating** (check `hasFeature` for RSVP/Gifts).

5. **New Feature:**

   * Add **Dress Code Section** (enabled for Premium/Exclusive) consistent with the new light theme.

**Implementation Steps:**

1. Modify `regular.blade.php` to replace the "Dark Royal" CSS with "Premium White" CSS.
2. Re-structure the Hero, Couple, and RSVP/Gift HTML sections to match the layouts in the images.
3. Ensure all dynamic data (Names, Dates, Toggles) remains functional.

