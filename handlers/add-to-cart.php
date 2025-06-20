<?php
session_start();

include '../includes/db.php';

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    header('Location: ../products.php');
    // echo json_encode(['success' => false, 'message' => 'Invalid request: not AJAX']);
    exit;
}

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {

    $product_id = (int) $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Handle remove action

    if (isset($_POST['remove'])) {


        // Remove from session cart
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }

        // Remove from database
        if (isset($_SESSION['customer_id'])) {
            $customer_id = $_SESSION['customer_id'];
            $del_stmt = $conn->prepare("DELETE FROM user_carts WHERE user_id = ? AND product_id = ?");
            $del_stmt->bind_param("ii", $customer_id, $product_id);
            $del_stmt->execute();
            $del_stmt->close();
        }

        $response['success'] = true;
        $response['message'] = "Product removed from cart.";
        echo json_encode($response);
        exit;
    }

    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

    if ($quantity < 1) {
        $response['message'] = "Invalid quantity.";
        echo json_encode($response);
        exit;
    }


    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    } else {
        $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
        if (!$stmt) {
            $response['message'] = "DB prepare failed: " . $conn->error;
            echo json_encode($response);
            exit;
        }

        $stmt->bind_param("i", $product_id);


        if (!$stmt->execute()) {
            $response['message'] = "DB execute failed: " . $stmt->error;
            echo json_encode($response);
            exit;
        }

        $result = $stmt->get_result();

        if ($product = $result->fetch_assoc()) {

            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity
            ];
        } else {
            $response['message'] = "Product not found.";
            echo json_encode($response);
            exit;
        }
        $stmt->close();
    }

    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];

        $check_stmt = $conn->prepare("SELECT quantity FROM user_carts WHERE user_id = ? AND product_id = ?");
        if (!$check_stmt) {
            $response['message'] = "DB prepare failed: " . $conn->error;
            echo json_encode($response);
            exit;
        }
        $check_stmt->bind_param("ii", $customer_id, $product_id);


        if (!$check_stmt->execute()) {
            $response['message'] = "DB execute failed: " . $check_stmt->error;
            echo json_encode($response);
            exit;
        }

        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $update_stmt = $conn->prepare("UPDATE user_carts SET quantity = ? WHERE user_id = ? AND product_id = ?");
            if (!$update_stmt) {
                $response['message'] = "DB prepare failed: " . $conn->error;
                echo json_encode($response);
                exit;
            }
            $update_stmt->bind_param("iii", $quantity, $customer_id, $product_id);
            if (!$update_stmt->execute()) {
                $response['message'] = "DB execute failed: " . $update_stmt->error;
                echo json_encode($response);
                exit;
            }
            $update_stmt->close();
        } else {
            $insert_stmt = $conn->prepare("INSERT INTO user_carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
            if (!$insert_stmt) {
                $response['message'] = "DB prepare failed: " . $conn->error;
                echo json_encode($response);
                exit;
            }
            $insert_stmt->bind_param("iii", $customer_id, $product_id, $quantity);
            if (!$insert_stmt->execute()) {
                $response['message'] = "DB execute failed: " . $insert_stmt->error;
                echo json_encode($response);
                exit;
            } else {
                error_log("Inserted into user_carts: user_id=$customer_id, product_id=$product_id, quantity=$quantity");
            }

            $insert_stmt->close();
        }

        $check_stmt->close();
    }

    $response['success'] = true;
    $response['message'] = isset($_SESSION['cart'][$product_id]) ? "Cart updated." : "Product added to cart.";
} else {
    $response['message'] = "Invalid request.";
}

echo json_encode($response);
exit();
