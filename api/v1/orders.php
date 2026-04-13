<?php
/**
 * Orders API Endpoint
 * RESTful API for order management
 */

require_once '../../config/config.php';

Session::start();

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

if (!Session::isLoggedIn()) {
    Response::error('Unauthorized', null, 401);
}

$method = $_SERVER['REQUEST_METHOD'];
$orderModel = new Order();

switch ($method) {
    case 'GET':
        handleGet($orderModel);
        break;
    case 'POST':
        handlePost($orderModel);
        break;
    case 'PUT':
        handlePut($orderModel);
        break;
    case 'DELETE':
        handleDelete($orderModel);
        break;
    default:
        Response::error('Method not allowed', null, 405);
}

function handleGet($orderModel) {
    $id = $_GET['id'] ?? null;
    $userId = Session::getUserId();
    $limit = $_GET['limit'] ?? ITEMS_PER_PAGE;
    $offset = $_GET['offset'] ?? 0;
    
    if ($id) {
        $order = $orderModel->findById($id);
        if ($order && ($order['u_id'] == $userId || Session::isAdmin())) {
            Response::success('Order retrieved', $order);
        } else {
            Response::error('Order not found', null, 404);
        }
    } elseif (Session::isAdmin()) {
        $orders = $orderModel->getAll($limit, $offset);
        $total = $orderModel->count();
        Response::success('Orders retrieved', [
            'orders' => $orders,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset
        ]);
    } else {
        $orders = $orderModel->getByUser($userId, $limit, $offset);
        Response::success('Orders retrieved', $orders);
    }
}

function handlePost($orderModel) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (empty($data['items']) || !is_array($data['items'])) {
        Response::error('Invalid order items', null, 400);
    }
    
    $userId = Session::getUserId();
    
    try {
        $success = $orderModel->create($userId, $data['items']);
        if ($success) {
            Response::success('Order placed successfully', null, 201);
        } else {
            Response::error('Failed to place order', null, 500);
        }
    } catch (Exception $e) {
        Response::error('Failed to place order', null, 500);
    }
}

function handlePut($orderModel) {
    if (!Session::isAdmin()) {
        Response::error('Unauthorized', null, 403);
    }
    
    $id = $_GET['id'] ?? null;
    if (!$id) {
        Response::error('Order ID required', null, 400);
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (empty($data['status'])) {
        Response::error('Status required', null, 400);
    }
    
    try {
        $success = $orderModel->updateStatus($id, $data['status']);
        if ($success) {
            Response::success('Order status updated');
        } else {
            Response::error('Order not found or invalid status', null, 404);
        }
    } catch (Exception $e) {
        Response::error('Failed to update order', null, 500);
    }
}

function handleDelete($orderModel) {
    if (!Session::isAdmin()) {
        Response::error('Unauthorized', null, 403);
    }
    
    $id = $_GET['id'] ?? null;
    if (!$id) {
        Response::error('Order ID required', null, 400);
    }
    
    try {
        $success = $orderModel->delete($id);
        if ($success) {
            Response::success('Order deleted successfully');
        } else {
            Response::error('Order not found', null, 404);
        }
    } catch (Exception $e) {
        Response::error('Failed to delete order', null, 500);
    }
}
