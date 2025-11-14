# Notification System Integration

## Overview
The system alerts in `job_status_monitor.php` are now connected to the notification database, allowing all admin actions to be tracked and recorded.

## How It Works

### 1. System Alerts Connected to Notifications
When admins perform actions in the Job Status Monitor, the following events are recorded:

- **Cancellation Approved** - When admin approves a cancellation request
- **Cancellation Declined** - When admin rejects a cancellation request  
- **Return Approved** - When admin approves a return request
- **Return Declined** - When admin rejects a return request

### 2. Data Flow

```
job_status_monitor.php (Frontend)
          ↓
    Admin clicks action button
          ↓
    JavaScript event handler
          ↓
    Fetch POST to /api/save-notification.php
          ↓
    API validates and saves to storage/data/notifications.json
          ↓
    Notification appears in notification system
```

### 3. Notification Structure

Each notification saved includes:

```json
{
  "id": 1699999999,
  "message": "Cancellation approved for booking #123",
  "href": "job_status_monitor.php",
  "created_at": "2025-11-13T10:30:00+00:00",
  "read": false,
  "type": "cancellation_approved"
}
```

### 4. Notification Types

- `cancellation_approved` - Admin approved a cancellation
- `cancellation_declined` - Admin declined a cancellation
- `return_approved` - Admin approved a return request
- `return_declined` - Admin declined a return request
- `booking` - New booking created
- `provider` - Provider related update
- `voucher` - Voucher redeemed
- `system` - General system notification

### 5. API Endpoint

**POST** `/admin_haustap/admin_haustap/api/save-notification.php`

**Request Body:**
```json
{
  "message": "Cancellation approved for booking #123",
  "href": "job_status_monitor.php",
  "created_at": "2025-11-13T10:30:00+00:00",
  "read": false,
  "type": "cancellation_approved"
}
```

**Response:**
```json
{
  "success": true,
  "notification": {
    "id": 1699999999,
    "message": "Cancellation approved for booking #123",
    ...
  }
}
```

### 6. Storage Location

Notifications are stored in: `storage/data/notifications.json`

### 7. JavaScript Implementation

The frontend automatically sends notifications when:

```javascript
// Fetch POST to save notification
fetch('/admin_haustap/admin_haustap/api/save-notification.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    message: `Cancellation approved for booking #${bookingId}`,
    href: 'job_status_monitor.php',
    created_at: new Date().toISOString(),
    read: false,
    type: 'cancellation_approved'
  })
}).catch(err => console.warn('Could not save notification', err));
```

### 8. Future Enhancements

To extend this system to other pages:

1. **manage_applicant.php** - Save notifications when approving/rejecting applicants
2. **manage_provider.php** - Save notifications when updating provider status
3. **manage_client.php** - Save notifications when managing clients
4. **manage_booking.php** - Save notifications when updating booking status

## Example Usage

### In job_status_monitor.php

When admin clicks "Approve Cancellation":

1. JavaScript captures the event
2. Confirmation dialog shows
3. If confirmed:
   - Row status is updated
   - POST request sent to save-notification.php
   - Notification is saved to database
   - Alert dialog confirms action
4. New notification appears in notification system

### In notifications.php (or notification button)

The notification system can now display:
- "Cancellation approved for booking #123" (2 minutes ago)
- "Return declined for booking #456" (15 minutes ago)
- New notifications marked as unread

## Testing

To test the notification system:

1. Open `job_status_monitor.php`
2. Click ">" button on any booking with "Cancelled" status
3. Click "Approve" or "Decline" button
4. Check `storage/data/notifications.json` to verify notification was saved
5. Check browser console for any errors (should see no errors)

## Error Handling

If the notification fails to save:
- A warning is logged to console: "Could not save notification"
- The action still completes (graceful degradation)
- Admin sees the success alert regardless

This ensures the system is resilient and doesn't block critical operations.
