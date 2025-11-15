<?php
require_once __DIR__ . '/db.php';

function format_date($ts)
{
    if (!$ts) return '';
    try {
        $dt = new DateTime($ts);
        return $dt->format('F j, Y');
    } catch (Throwable $e) {
        return (string)$ts;
    }
}

function fetch_clients(int $limit = 50): array
{
    $db = get_db();
    if (!table_exists($db, 'users')) return [];
    $hasRoleCol = column_exists($db, 'users', 'role');
    $sql = $hasRoleCol
        ? 'SELECT u.id, u.name, u.email, u.created_at FROM users u WHERE u.role = ? ORDER BY u.created_at DESC LIMIT ?'
        : 'SELECT u.id, u.name, u.email, u.created_at FROM users u JOIN user_roles r ON r.user_id = u.id AND r.role = ? ORDER BY u.created_at DESC LIMIT ?';
    $stmt = $db->prepare($sql);
    $stmt->execute(['client', $limit]);
    $rows = $stmt->fetchAll();
    foreach ($rows as &$row) {
        $row['status'] = 'active'; // default until status column exists
        $row['date_joined'] = format_date($row['created_at'] ?? null);
    }
    return $rows;
}

function fetch_providers(int $limit = 50): array
{
    $db = get_db();
    if (!table_exists($db, 'users')) return [];
    $hasRoleCol = column_exists($db, 'users', 'role');
    $joinBase = $hasRoleCol
        ? 'FROM users u LEFT JOIN providers p ON p.user_id = u.id WHERE u.role = ?'
        : 'FROM users u JOIN user_roles r ON r.user_id = u.id LEFT JOIN providers p ON p.user_id = u.id WHERE r.role = ?';
    $sql = 'SELECT u.id, u.name, u.created_at, p.rating, p.status, p.service_categories ' . $joinBase . ' ORDER BY u.created_at DESC LIMIT ?';
    $stmt = $db->prepare($sql);
    $stmt->execute(['provider', $limit]);
    $rows = $stmt->fetchAll();
    foreach ($rows as &$row) {
        $row['date_hired'] = format_date($row['created_at'] ?? null);
        $row['status'] = $row['status'] ?? 'active';
        $row['skills'] = '-';
        if (!empty($row['service_categories'])) {
            $cats = json_decode($row['service_categories'], true);
            if (is_array($cats) && !empty($cats)) {
                $row['skills'] = implode(', ', array_slice($cats, 0, 3));
            }
        }
        if (!empty($row['rating'])) {
            $row['rating_fmt'] = number_format((float)$row['rating'], 1) . '/5';
        } else {
            $row['rating_fmt'] = '—';
        }
    }
    return $rows;
}

// --- Extended helpers for search, pagination, and counts ---

function search_clients(string $q = '', ?string $status = null, int $limit = 10, int $offset = 0): array
{
    $db = get_db();
    if (!table_exists($db, 'users')) return [];
    $hasRoleCol = column_exists($db, 'users', 'role');
    $conds = [];
    $params = [];
    if ($hasRoleCol) {
        $sql = 'SELECT u.id, u.name, u.email, u.created_at FROM users u WHERE u.role = ?';
        $params[] = 'client';
    } else {
        $sql = 'SELECT u.id, u.name, u.email, u.created_at FROM users u JOIN user_roles r ON r.user_id = u.id AND r.role = ?';
        $params[] = 'client';
    }
    if ($q !== '') {
        $conds[] = '(u.name LIKE ? OR u.email LIKE ?)';
        $params[] = '%' . $q . '%';
        $params[] = '%' . $q . '%';
    }
    // Status filter placeholder (no status column on users; if providers/clients status exists elsewhere, adapt later)
    if (!empty($conds)) $sql .= ' AND ' . implode(' AND ', $conds);
    $sql .= ' ORDER BY u.created_at DESC LIMIT ? OFFSET ?';
    $params[] = $limit;
    $params[] = $offset;
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
    foreach ($rows as &$row) {
        $row['status'] = 'active';
        $row['date_joined'] = format_date($row['created_at'] ?? null);
    }
    return $rows;
}

function count_clients(?string $q = ''): int
{
    $db = get_db();
    if (!table_exists($db, 'users')) return 0;
    $hasRoleCol = column_exists($db, 'users', 'role');
    if ($hasRoleCol) {
        $sql = 'SELECT COUNT(*) AS c FROM users u WHERE u.role = ?';
        $params = ['client'];
    } else {
        $sql = 'SELECT COUNT(*) AS c FROM users u JOIN user_roles r ON r.user_id = u.id AND r.role = ?';
        $params = ['client'];
    }
    if ($q) { $sql .= ' AND (u.name LIKE ? OR u.email LIKE ?)'; $params[] = '%' . $q . '%'; $params[] = '%' . $q . '%'; }
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row ? (int)$row['c'] : 0;
}

function search_providers(string $q = '', ?string $status = null, int $limit = 10, int $offset = 0): array
{
    $db = get_db();
    if (!table_exists($db, 'users')) return [];
    $hasRoleCol = column_exists($db, 'users', 'role');
    $joinBase = $hasRoleCol
        ? 'FROM users u LEFT JOIN providers p ON p.user_id = u.id WHERE u.role = ?'
        : 'FROM users u JOIN user_roles r ON r.user_id = u.id LEFT JOIN providers p ON p.user_id = u.id WHERE r.role = ?';
    $sql = 'SELECT u.id, u.name, u.created_at, p.rating, p.status, p.service_categories ' . $joinBase;
    $params = ['provider'];
    if ($q !== '') { $sql .= ' AND (u.name LIKE ? OR u.email LIKE ?)'; $params[] = '%' . $q . '%'; $params[] = '%' . $q . '%'; }
    if ($status) { $sql .= ' AND (p.status = ?)'; $params[] = $status; }
    $sql .= ' ORDER BY u.created_at DESC LIMIT ? OFFSET ?';
    $params[] = $limit; $params[] = $offset;
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
    foreach ($rows as &$row) {
        $row['date_hired'] = format_date($row['created_at'] ?? null);
        $row['status'] = $row['status'] ?? 'active';
        $row['skills'] = '-';
        if (!empty($row['service_categories'])) {
            $cats = json_decode($row['service_categories'], true);
            if (is_array($cats) && !empty($cats)) { $row['skills'] = implode(', ', array_slice($cats, 0, 3)); }
        }
        $row['rating_fmt'] = !empty($row['rating']) ? number_format((float)$row['rating'], 1) . '/5' : '—';
    }
    return $rows;
}

function count_providers(?string $q = '', ?string $status = null): int
{
    $db = get_db();
    if (!table_exists($db, 'users')) return 0;
    $hasRoleCol = column_exists($db, 'users', 'role');
    $joinBase = $hasRoleCol
        ? 'FROM users u LEFT JOIN providers p ON p.user_id = u.id WHERE u.role = ?'
        : 'FROM users u JOIN user_roles r ON r.user_id = u.id LEFT JOIN providers p ON p.user_id = u.id WHERE r.role = ?';
    $sql = 'SELECT COUNT(*) AS c ' . $joinBase;
    $params = ['provider'];
    if ($q) { $sql .= ' AND (u.name LIKE ? OR u.email LIKE ?)'; $params[] = '%' . $q . '%'; $params[] = '%' . $q . '%'; }
    if ($status) { $sql .= ' AND (p.status = ?)'; $params[] = $status; }
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row ? (int)$row['c'] : 0;
}

function count_bookings(): int
{
    $db = get_db();
    if (!table_exists($db, 'bookings')) return 0;
    $row = $db->query('SELECT COUNT(*) AS c FROM bookings')->fetch();
    return $row ? (int)$row['c'] : 0;
}

function count_pending_jobs(): int
{
    $db = get_db();
    if (!table_exists($db, 'bookings')) return 0;
    $stmt = $db->prepare('SELECT COUNT(*) AS c FROM bookings WHERE status = ?');
    $stmt->execute(['pending']);
    $row = $stmt->fetch();
    return $row ? (int)$row['c'] : 0;
}

function count_verified_providers(): int
{
    $db = get_db();
    // Prefer provider_statuses approved; else fallback to providers.status
    if (table_exists($db, 'provider_statuses')) {
        $row = $db->query("SELECT COUNT(*) AS c FROM provider_statuses WHERE status = 'approved'")->fetch();
        return $row ? (int)$row['c'] : 0;
    }
    if (table_exists($db, 'providers')) {
        $row = $db->query("SELECT COUNT(*) AS c FROM providers WHERE status = 'approved'")->fetch();
        return $row ? (int)$row['c'] : 0;
    }
    return 0;
}

function client_status_counts(): array
{
    // Placeholder since status not modeled for clients yet; infer active by presence in users
    $total = count_clients();
    return [ 'total' => $total, 'active' => $total, 'inactive' => 0, 'suspend' => 0 ];
}

function provider_status_counts(): array
{
    $total = count_providers();
    // Infer approved as verified providers, others as inactive for now
    $approved = count_verified_providers();
    return [ 'total' => $total, 'active' => $approved, 'inactive' => max(0, $total - $approved), 'suspend' => 0 ];
}

?>