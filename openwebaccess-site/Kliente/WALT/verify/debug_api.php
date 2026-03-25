<?php
header('Content-Type: text/plain');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$config = include($doc_root . '/amember/application/configs/config.php');
$db = $config['db']['mysql'];
$pdo = new PDO("mysql:host={$db['host']};dbname={$db['db']};charset=utf8mb4", $db['user'], $db['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// Product columns
echo "=== am_product columns ===\n";
$stmt = $pdo->query("DESCRIBE am_product");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $c) echo "  {$c['Field']} ({$c['Type']})\n";

// Active access with users
echo "\n=== Active access (top 10) ===\n";
$stmt = $pdo->query("
    SELECT u.user_id, u.email, u.name_f, u.name_l, u.status as user_status, u.is_approved,
           a.begin_date, a.expire_date, a.product_id, p.title as product
    FROM am_access a
    JOIN am_user u ON a.user_id = u.user_id
    JOIN am_product p ON a.product_id = p.product_id
    WHERE a.begin_date <= CURDATE() AND a.expire_date >= CURDATE()
    ORDER BY a.expire_date DESC LIMIT 10
");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    $em = substr($r['email'], 0, 2) . '***@' . explode('@', $r['email'])[1];
    echo "  uid={$r['user_id']} {$r['name_f']} {$r['name_l']} ({$em}) prod={$r['product']} [{$r['begin_date']} to {$r['expire_date']}] ustatus={$r['user_status']} approved={$r['is_approved']}\n";
}

// Membership products (IDs 1-7)
echo "\n=== Membership product IDs with active count ===\n";
$stmt = $pdo->query("
    SELECT p.product_id, p.title, 
           (SELECT COUNT(*) FROM am_access a WHERE a.product_id = p.product_id AND a.begin_date <= CURDATE() AND a.expire_date >= CURDATE()) as active_count
    FROM am_product p
    WHERE p.product_id IN (1,2,3,4,5,6,7)
");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "  [{$r['product_id']}] {$r['title']}: {$r['active_count']} active\n";
}

// User status values
echo "\n=== User status distribution ===\n";
$stmt = $pdo->query("SELECT status, is_approved, COUNT(*) as cnt FROM am_user GROUP BY status, is_approved ORDER BY status, is_approved");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo "  status={$r['status']} approved={$r['is_approved']}: {$r['cnt']}\n";
}

echo "\nDone\n";
