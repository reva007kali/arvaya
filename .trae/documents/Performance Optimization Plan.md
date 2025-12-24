I have analyzed your controllers and Livewire components. I found several N+1 query issues (where the application makes one database query per item in a list) and a critical performance bottleneck in how page views are counted.

Here is the optimization plan:

### 1. Fix N+1 Queries in Dashboard & Admin
These pages are making excessive queries because they fetch related data (like template names or guest counts) one by one in a loop.
- **`app/Livewire/Dashboard/Index.php`**:
  - **Issue**: Fetches `template` and counts `guests` individually for every invitation card.
  - **Fix**: Eager load `template` and use `withCount('guests')`.
- **`app/Livewire/Admin/ManageInvitation.php`**:
  - **Issue**: Fetches `template` and counts `guests` for every row in the admin table.
  - **Fix**: Add `with(['user', 'template'])` and `withCount('guests')`.
- **`app/Livewire/Admin/ManageUser.php`**:
  - **Issue**: Counts `invitations` for every user row.
  - **Fix**: Add `withCount('invitations')`.

### 2. Optimize "Visit Count" (Critical Bottleneck)
- **`app/Livewire/Frontend/ShowInvitation.php`**:
  - **Issue**: Every time an invitation is loaded, the database is written to (`increment('visit_count')`). This locks the database row and significantly limits your request throughput (requests/second).
  - **Fix**: Implement **Session Debouncing**. We will only increment the counter if the user hasn't visited in the current session, drastically reducing database writes.

### 3. Optimize Frontend Template Showcase
- **`app/Livewire/Frontend/TemplateShowcase.php`**:
  - **Issue**: Fetches all columns (`select *`) for templates.
  - **Fix**: Add `select(...)` to only fetch necessary columns (`name`, `slug`, `thumbnail`, etc.), reducing memory usage.

### 4. Verification
- After applying these changes, we will verify the pages load correctly and the N+1 queries are resolved.

This plan addresses the root causes of your performance limits on the 2-core VPS.
