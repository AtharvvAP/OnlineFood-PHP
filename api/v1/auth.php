<?php
/**
 * Authentication API Endpoint
 * RESTful API for user authentication
 */

require_once '../../config/config.php';

Session::start();

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_GET['action'] ?? '';
    
    switch ($action) {
        case 'login':
            handleLogin();
            break;
        case 'register':
            handleRegister();
            break;
        case 'logout':
            handleLogout();
            break;
        default:
            Response::error('Invalid action', null, 404);
    }
} else {
    Response::error('Method not allowed', null, 405);
}

function handleLogin() {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $validator = new Validator($data);
    $validator->required('username')->required('password');
    
    if (!$validator->isValid()) {
        Response::error('Validation failed', $validator->getErrors(), 422);
    }
    
    $userModel = new User();
    $user = $userModel->authenticate($data['username'], $data['password']);
    
    if ($user) {
        Session::set('user_id', $user['u_id']);
        Session::set('username', $user['username']);
        Session::generateCSRFToken();
        
        Response::success('Login successful', [
            'user' => [
                'id' => $user['u_id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'name' => $user['f_name'] . ' ' . $user['l_name']
            ],
            'csrf_token' => Session::get(CSRF_TOKEN_NAME)
        ]);
    } else {
        Response::error('Invalid credentials', null, 401);
    }
}

function handleRegister() {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $validator = new Validator($data);
    $validator
        ->required('username')->min('username', 3)->max('username', 50)
        ->required('email')->email('email')
        ->required('password')->min('password', 6)
        ->required('f_name')->required('l_name')
        ->required('phone')->numeric('phone');
    
    if (!$validator->isValid()) {
        Response::error('Validation failed', $validator->getErrors(), 422);
    }
    
    $userModel = new User();
    
    // Check if username exists
    if ($userModel->findByUsername($data['username'])) {
        Response::error('Username already exists', null, 409);
    }
    
    // Check if email exists
    if ($userModel->findByEmail($data['email'])) {
        Response::error('Email already exists', null, 409);
    }
    
    try {
        $userId = $userModel->create($data);
        
        Session::set('user_id', $userId);
        Session::set('username', $data['username']);
        Session::generateCSRFToken();
        
        Response::success('Registration successful', [
            'user_id' => $userId,
            'csrf_token' => Session::get(CSRF_TOKEN_NAME)
        ], 201);
    } catch (Exception $e) {
        Response::error('Registration failed', null, 500);
    }
}

function handleLogout() {
    Session::destroy();
    Response::success('Logout successful');
}
