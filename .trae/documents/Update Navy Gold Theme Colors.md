I will update the `navy-gold.blade.php` template to replace Zinc and Black colors with Navy Blue shades, creating a true "Navy Gold" aesthetic.

**Implementation Plan:**

1.  **Analyze CSS Variables**:
    *   The file already has `--color-bg: #051025` (Navy).
    *   I need to ensure classes like `bg-zinc-900`, `bg-black`, `text-zinc-x` are replaced with custom navy hex codes or classes.

2.  **Replace Colors**:
    *   **Main Backgrounds**: Replace `bg-zinc-900` with `#0A192F` (Dark Navy).
    *   **Section Backgrounds**: Replace `bg-black` with `#051025` (Deep Navy).
    *   **Gradients**: Update gradients to use navy stops (e.g., `from-zinc-800 to-zinc-900` -> `from-[#0F2942] to-[#0A192F]`).
    *   **Text**: Ensure text is legible on navy (white/gold is fine, but check for gray/zinc text).
    *   **Overlays**: Change black overlays (`bg-black/x`) to navy overlays (`bg-[#051025]/x`).

3.  **Specific Replacements**:
    *   `bg-zinc-900` -> `bg-[#0A192F]`
    *   `bg-zinc-800` -> `bg-[#112240]`
    *   `bg-black` -> `bg-[#020c1b]`
    *   `shadow-black` -> `shadow-[#020c1b]`

I will apply these changes systematically throughout the file.