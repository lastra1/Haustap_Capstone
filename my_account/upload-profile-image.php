<?php
// Simple upload handler for profile images
// Accepts multipart/form-data with field name 'profile_image'
header('Content-Type: application/json; charset=utf-8');

$maxBytes = 3 * 1024 * 1024; // 3MB
$allowed = ["image/jpeg", "image/png"];

if (!isset($_FILES['profile_image'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'No file uploaded']);
    exit;
}

$f = $_FILES['profile_image'];
if ($f['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Upload error code: ' . $f['error']]);
    exit;
}

if ($f['size'] > $maxBytes) {
    http_response_code(413);
    echo json_encode(['success' => false, 'error' => 'File too large']);
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $f['tmp_name']);
finfo_close($finfo);
if (!in_array($mime, $allowed, true)) {
    http_response_code(415);
    echo json_encode(['success' => false, 'error' => 'Unsupported file type']);
    exit;
}

$ext = $mime === 'image/png' ? 'png' : 'jpg';
$uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'uploads';
if (!is_dir($uploadsDir)) {
    @mkdir($uploadsDir, 0755, true);
}

$basename = bin2hex(random_bytes(8));
$target = $uploadsDir . DIRECTORY_SEPARATOR . $basename . '.' . $ext;
if (!move_uploaded_file($f['tmp_name'], $target)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file']);
    exit;
}

$urlPath = '/storage/uploads/' . $basename . '.' . $ext;
echo json_encode(['success' => true, 'url' => $urlPath]);
exit;
