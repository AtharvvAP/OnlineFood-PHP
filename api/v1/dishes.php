<?php
/**
 * Dishes API Endpoint
 * RESTful API for dish management
 */

require_once '../../config/config.php';

Session::start();

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$method = $_SERVER['REQUEST_METHOD'];
$dishModel = new Dish();

switch ($method) {
    case 'GET':
        handleGet($dishModel);
        break;
    case 'POST':
        handlePost($dishModel);
        break;
    case 'PUT':
        handlePut($dishModel);
        break;
    case 'DELETE':
        handleDelete($dishModel);
        break;
    default:
        Response::error('Method not allowed', null, 405);
}

function handleGet($dishModel) {
    $id = $_GET['id'] ?? null;
    $restaurantId = $_GET['restaurant_id'] ?? null;
    $type = $_GET['type'] ?? 'all';
    $limit = $_GET['limit'] ?? ITEMS_PER_PAGE;
    $offset = $_GET['offset'] ?? 0;
    
    if ($id) {
        $dish = $dishModel->findById($id);
        if ($dish) {
            // Calculate discounted price
            $dish['discounted_price'] = $dishModel->calculateDiscountedPrice($dish['price'], $dish['discount']);
            Response::success('Dish retrieved', $dish);
        } else {
            Response::error('Dish not found', null, 404);
        }
    } elseif ($restaurantId) {
        $dishes = $dishModel->getByRestaurant($restaurantId, $limit);
        foreach ($dishes as &$dish) {
            $dish['discounted_price'] = $dishModel->calculateDiscountedPrice($dish['price'], $dish['discount']);
        }
        Response::success('Dishes retrieved', $dishes);
    } elseif ($type === 'popular') {
        $dishes = $dishModel->getPopular($limit);
        foreach ($dishes as &$dish) {
            $dish['discounted_price'] = $dishModel->calculateDiscountedPrice($dish['price'], $dish['discount']);
        }
        Response::success('Popular dishes retrieved', $dishes);
    } elseif ($type === 'discounted') {
        $dishes = $dishModel->getDiscounted($limit);
        foreach ($dishes as &$dish) {
            $dish['discounted_price'] = $dishModel->calculateDiscountedPrice($dish['price'], $dish['discount']);
        }
        Response::success('Discounted dishes retrieved', $dishes);
    } else {
        $dishes = $dishModel->getAll($limit, $offset);
        foreach ($dishes as &$dish) {
            $dish['discounted_price'] = $dishModel->calculateDiscountedPrice($dish['price'], $dish['discount']);
        }
        $total = $dishModel->count();
        Response::success('Dishes retrieved', [
            'dishes' => $dishes,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset
        ]);
    }
}

function handlePost($dishModel) {
    if (!Session::isAdmin()) {
        Response::error('Unauthorized', null, 403);
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $validator = new Validator($data);
    $validator
        ->required('rs_id')->numeric('rs_id')
        ->required('title')->min('title', 3)
        ->required('price')->numeric('price')
        ->required('img');
    
    if (!$validator->isValid()) {
        Response::error('Validation failed', $validator->getErrors(), 422);
    }
    
    try {
        $dishId = $dishModel->create($data);
        Response::success('Dish created successfully', ['dish_id' => $dishId], 201);
    } catch (Exception $e) {
        Response::error('Failed to create dish', null, 500);
    }
}

function handlePut($dishModel) {
    if (!Session::isAdmin()) {
        Response::error('Unauthorized', null, 403);
    }
    
    $id = $_GET['id'] ?? null;
    if (!$id) {
        Response::error('Dish ID required', null, 400);
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    try {
        $success = $dishModel->update($id, $data);
        if ($success) {
            Response::success('Dish updated successfully');
        } else {
            Response::error('Dish not found', null, 404);
        }
    } catch (Exception $e) {
        Response::error('Failed to update dish', null, 500);
    }
}

function handleDelete($dishModel) {
    if (!Session::isAdmin()) {
        Response::error('Unauthorized', null, 403);
    }
    
    $id = $_GET['id'] ?? null;
    if (!$id) {
        Response::error('Dish ID required', null, 400);
    }
    
    try {
        $success = $dishModel->delete($id);
        if ($success) {
            Response::success('Dish deleted successfully');
        } else {
            Response::error('Dish not found', null, 404);
        }
    } catch (Exception $e) {
        Response::error('Failed to delete dish', null, 500);
    }
}
