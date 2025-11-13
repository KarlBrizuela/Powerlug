# Policy Form Database Connection - Troubleshooting Guide

## Issue Found and Fixed ✅

**Problem**: View cache was causing "View [pages.policy] not found" error
**Solution**: Ran `php artisan view:clear` to clear cached views

## What Was Done

### 1. ✅ Added "Policy List" Button
- Location: Top-right of the Policy Form page
- Shows a blue button: "Policy List" 
- Clicking it navigates to `/policies` to view all submitted policies

### 2. ✅ Fixed View Cache Issue
- Cleared Laravel compiled views that were causing page load errors

### 3. ✅ Verified Database Connection
- Database: `powerlug_db`
- Host: `127.0.0.1`
- All migrations applied successfully

## How to Test the Form Submission

### Step 1: Access the Policy Form
- URL: `http://localhost/powerlug/public/policy`
- Or navigate through your application menu

### Step 2: Fill Out the Form
You must fill at least **ONE** of these sections:

**OPTION A: Policy Details Section**
- Insurance Provider (required if Policy Details selected)
- Issue Date
- Coverage Period From/To
- Chassis/Motor/MV File numbers
- Mortgage
- Remarks

**OPTION B: Walk-in Details Section**  
- Walk-in Date
- Estimate Amount
- Size
- Services (checkboxes)
- Rate
- Payment

**OPTION C: Both Sections** ✅ (Recommended for complete data)

### Step 3: Submit the Form
- Click "Submit Policy" button at the bottom
- Form validates all fields
- If successful, redirects to policies list

### Step 4: View Your Data
- Click the "Policy List" button at the top
- Or navigate to `/policies`
- Your submitted policy should appear in the table

## Fields in the Policy Form

### Always Required
- **Policy Number** (auto-unique)

### Optional but Recommended
- Client Name
- Address
- Email
- Contact Number
- Make/Model/Plate Number
- Color

### Policy Details Tab
- Insurance Provider
- Issue/Coverage Dates
- Chassis/Engine/MV numbers
- Mortgage info
- Remarks

### Walk-in Details Tab  
- Walk-in Date
- Estimate Amount
- Size
- Services (carwash, oil change, etc.)
- Rate & Payment

### Premium Summary Section
- Premium
- VAT
- Documentary Stamp Tax
- Local Gov Tax
- Amount Due
- COC VP
- Premium Remarks

### Payment Information
- Payment Terms
- Paid Amount
- Payment Method (Cash, Transfer, PDC, Cancelled)
- Bank Transfer (if Transfer selected)
- Reference Number

## Validation Rules

| Field | Rule |
|-------|------|
| policy_number | Required, unique in policies table |
| Email | Must be valid email format (if provided) |
| Numeric Fields | Must be ≥ 0 |
| Dates | Must be valid date format |
| Payment Method | Only: Cash, Transfer, PDC, Cancelled |
| Status | Only: active, inactive, expired, cancelled |
| Billing Status | Only: paid, unpaid, partial |

## Database Fields Added

The migration added 31 new columns to support all form data:
- Client information (name, address, email, contact)
- Vehicle information (make, model, plate, color)
- Policy details (insurance provider, dates, numbers)
- Walk-in details (date, estimate, size, services, rates)
- Payment information (terms, amounts, method, bank)
- Premium summary (taxes, amounts, remarks)

## Common Issues & Solutions

### Issue: "View [pages.policy] not found"
- **Solution**: Clear view cache
```bash
php artisan view:clear
```

### Issue: Form shows validation errors after submit
- **Cause**: Either Policy Details OR Walk-in Details must have data
- **Solution**: Fill at least one section with data

### Issue: Data not appearing in database
- **Check**:
  1. Browser console for JavaScript errors (F12)
  2. Network tab - verify POST request was sent
  3. Laravel logs at `storage/logs/laravel.log`
  4. Database directly: Check `powerlug_db.policies` table

### Issue: Policy List button not showing
- **Cause**: Could be theme/CSS issue
- **Solution**: Check if `route('policies.index')` is accessible

## Database Query to Verify Data

If data was saved, you can check your database:

```sql
SELECT * FROM powerlug_db.policies ORDER BY created_at DESC LIMIT 10;
```

## Files Modified

✅ **Created**:
- `database/migrations/2025_11_11_000002_add_fields_to_policies_table.php`
- `POLICY_INTEGRATION_NOTES.md`

✅ **Modified**:
- `app/Models/Policy.php` - Added fields to fillable array
- `app/Http/Controllers/PolicyController.php` - Updated validation & added smart validation
- `resources/views/pages/policy.blade.php` - Added Policy List button and error display

✅ **No files deleted** - All existing files preserved

## Next Steps

1. **Try submitting the form** with test data
2. **Check the policies list** to see if data appears
3. **If issues persist**, check:
   - Browser Developer Tools (F12)
   - Laravel logs: `storage/logs/laravel.log`
   - Database directly via phpMyAdmin or MySQL client

## Support

If the form still doesn't save:
1. Share the error message from Laravel logs
2. Share what happens when you submit (stays on form? redirects? error message?)
3. Check if validation errors appear on the form
