# Quick Filter Fix Guide - Apply to Remaining Pages

This guide shows how to quickly fix Apply buttons on other admin pages.

## Pattern to Follow

### Before (Non-functional):
```html
<button class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</button>
<div class="dropdown-content">
  <label><input type="checkbox" value="pending"> Pending</label>
  <label><input type="checkbox" value="ongoing"> Ongoing</label>
  <button class="apply-btn">Apply</button>
</div>

<script>
// Filter button toggle might work, but Apply button does nothing!
const filterBtn = document.querySelector('.filter-btn');
const dropdownContent = filterBtn?.parentElement?.querySelector('.dropdown-content');
if (filterBtn && dropdownContent) {
  filterBtn.addEventListener('click', () => {
    dropdownContent.classList.toggle('show');
  });
}
// Apply button has NO event listener!
</script>
```

### After (Fully Functional):
```html
<button class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</button>
<div class="dropdown-content">
  <label><input type="checkbox" value="pending"> Pending</label>
  <label><input type="checkbox" value="ongoing"> Ongoing</label>
  <button class="apply-btn">Apply</button>
</div>

<script src="js/filter-utils.js" defer></script>
<script>
// Ensure filter-utils.js is loaded, then in your script section:
const filterBtn = document.querySelector('.filter-btn');
const dropdownContent = filterBtn?.parentElement?.querySelector('.dropdown-content');

if (filterBtn && dropdownContent) {
  // 1. Toggle dropdown
  filterBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    dropdownContent.classList.toggle('show');
    filterBtn.setAttribute('aria-expanded', dropdownContent.classList.contains('show'));
  });

  // 2. Close dropdown when clicking outside
  window.addEventListener('click', (e) => {
    if (!dropdownContent.contains(e.target) && !filterBtn.contains(e.target)) {
      dropdownContent.classList.remove('show');
      filterBtn.setAttribute('aria-expanded', 'false');
    }
  });

  // 3. STATUS FILTER (for manage_booking.php, manage_provider.php, etc.)
  if (dropdownContent.querySelector('input[type="checkbox"]')) {
    const checkboxes = dropdownContent.querySelectorAll('input[type="checkbox"]');
    const applyBtn = dropdownContent.querySelector('.apply-btn');

    function applyStatusFilter() {
      const selected = new Set(
        Array.from(checkboxes)
          .filter(cb => cb.checked)
          .map(cb => cb.value)
      );

      const rows = document.querySelectorAll('tbody tr');
      rows.forEach(row => {
        const badge = row.querySelector('.status');
        let status = '';
        
        if (badge) {
          if (badge.classList.contains('pending')) status = 'pending';
          else if (badge.classList.contains('ongoing')) status = 'ongoing';
          else if (badge.classList.contains('complete')) status = 'complete';
          else if (badge.classList.contains('cancelled')) status = 'cancelled';
          else if (badge.classList.contains('return')) status = 'return';
          // Add more status types as needed
        }

        const shouldShow = selected.size === 0 || selected.has(status);
        row.style.display = shouldShow ? '' : 'none';
      });

      console.debug('Status filter applied:', { selected: Array.from(selected) });
    }

    if (applyBtn) {
      applyBtn.addEventListener('click', (e) => {
        e.preventDefault();
        applyStatusFilter();
        dropdownContent.classList.remove('show');
        filterBtn.setAttribute('aria-expanded', 'false');
      });
    }
  }

  // 4. DATE FILTER (for manage_booking_pending.php, manage_client_activity.php, etc.)
  const fromInput = dropdownContent.querySelector('[id*="from"]');
  const toInput = dropdownContent.querySelector('[id*="to"]');
  
  if (fromInput && toInput) {
    const applyBtn = dropdownContent.querySelector('.apply-btn');

    function parseRowDate(text) {
      if (!text) return null;
      const m = text.match(/(\d{4})\D(\d{2})\D(\d{2})(?:[^\d]*(\d{2}):?(\d{2}))?/);
      if (m) {
        const y = m[1], mo = m[2], d = m[3];
        const hh = m[4] || '00', mm = m[5] || '00';
        const iso = `${y}-${mo}-${d}T${hh}:${mm}:00`;
        const dt = new Date(iso);
        if (!isNaN(dt.getTime())) return dt;
      }
      const p = Date.parse(text);
      if (!isNaN(p)) return new Date(p);
      return null;
    }

    function applyDateFilter() {
      const fromVal = fromInput.value;
      const toVal = toInput.value;
      const fromDate = fromVal ? new Date(fromVal) : null;
      const toDateRaw = toVal ? new Date(toVal) : null;
      const toDate = toDateRaw ? new Date(toDateRaw.getTime() + 86399999) : null;

      const rows = document.querySelectorAll('tbody tr');
      rows.forEach(row => {
        // Column 4 is typically the date column (adjust index as needed for your page)
        const dateCell = row.querySelector('td:nth-child(5)');
        const rowDate = parseRowDate(dateCell ? dateCell.textContent.trim() : '');
        
        if (!rowDate) {
          row.style.display = '';
          return;
        }

        const within = (!fromDate || rowDate >= fromDate) && (!toDate || rowDate <= toDate);
        row.style.display = within ? '' : 'none';
      });

      console.debug('Date filter applied:', { fromVal, toVal });
    }

    if (applyBtn) {
      applyBtn.addEventListener('click', (e) => {
        e.preventDefault();
        applyDateFilter();
        dropdownContent.classList.remove('show');
        filterBtn.setAttribute('aria-expanded', 'false');
      });
    }

    // Optional: Auto-filter when user changes dates
    fromInput.addEventListener('change', applyDateFilter);
    toInput.addEventListener('change', applyDateFilter);
  }
}
</script>
```

## Step-by-Step Instructions for Each Page Type

### Type A: Status Filter Pages
**Examples:** manage_booking.php, manage_provider.php, manage_client_booking.php

1. Find the filter section with checkboxes
2. Copy the **STATUS FILTER** code block (section 3 above)
3. Paste it into the page's `<script>` section
4. Adjust status class names if needed (check the HTML for actual classes):
   - Look for `<span class="status pending">Pending</span>`
   - Extract the class name after "status": "pending"

### Type B: Date Filter Pages  
**Examples:** manage_booking_pending.php, manage_client_activity.php, manage_provider_activity.php

1. Find the filter section with date inputs
2. Copy the **DATE FILTER** code block (section 4 above)
3. Paste it into the page's `<script>` section
4. Adjust the date column index if needed:
   - Count columns from left starting at 1
   - Find which column has the date/time
   - Subtract 1 from count for nth-child index
   - Example: If date is 5th column → `td:nth-child(5)`

### Type C: Mixed Filter Pages
**Examples:** manage_booking.php (has both status and date in dropdown options)

Combine both Type A and Type B code blocks in the same filter section.

---

## Quick Checklist Per Page

For **manage_booking_pending.php**:
- [ ] Find filter button and dropdown
- [ ] Copy date filter code (section 4)
- [ ] Paste into script
- [ ] Check date column position
- [ ] Test: Click Filter → Set dates → Click Apply → Verify rows filter

For **manage_provider.php**:
- [ ] Find filter button and dropdown  
- [ ] Copy status filter code (section 3)
- [ ] Paste into script
- [ ] Check status class names match
- [ ] Test: Click Filter → Check statuses → Click Apply → Verify rows filter

For **manage_client_activity.php**:
- [ ] Find filter button and dropdown
- [ ] Copy date filter code (section 4)
- [ ] Paste into script  
- [ ] Check date column position
- [ ] Test: Click Filter → Set dates → Click Apply → Verify rows filter

---

## CSS Requirements

Make sure the dropdown CSS includes:

```css
.dropdown-content {
    display: none;
}

.dropdown-content.show {
    display: block;
}
```

If your page uses different class names (e.g., `.filter-dropdown`), update the CSS accordingly:

```css
.filter-dropdown {
    display: none;
}

.filter-dropdown.show {
    display: block;
}
```

---

## Debugging Tips

If Apply button still doesn't work:

1. **Check browser console** (F12 → Console tab)
   - Look for JavaScript errors
   - Look for filter debug messages

2. **Verify HTML structure:**
   ```html
   <!-- ✓ Correct -->
   <button class="filter-btn">Filter</button>
   <div class="dropdown-content">
     <button class="apply-btn">Apply</button>
   </div>

   <!-- ✗ Wrong -->
   <div class="filter-btn">Filter</div>  <!-- Should be button -->
   <div class="filter-dropdown">          <!-- Check if apply-btn exists -->
   ```

3. **Check date column index:**
   - Right-click table row → Inspect
   - Count `<td>` from left (starting at 1)
   - `5th <td>` = `td:nth-child(5)`
   - Adjust script accordingly

4. **Verify status class names:**
   - Right-click status badge → Inspect
   - Find the class name (e.g., `class="status cancelled"`)
   - Use the class name in the filter (e.g., `status = 'cancelled'`)

---

## Estimate

- **Per page time:** 5-10 minutes
- **Total remaining pages:** ~15 pages
- **Total estimated time:** 1.5-2.5 hours
- **Complexity:** Low (mostly copy-paste with minor adjustments)

---

## Questions?

Refer to:
1. **FILTER_IMPLEMENTATION_REPORT.md** - Detailed explanation of fixes
2. **js/filter-utils.js** - Reusable library (can use instead of copy-paste)
3. **activity_logs.php, manage_client.php, feedback_reviews.php** - Working examples

---

Generated: November 13, 2025
