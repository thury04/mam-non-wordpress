<?php
header('Content-Type: application/json; charset=utf-8');

// Kết nối database
$conn = new mysqli("localhost", "root", "", "mam_non"); // thay tên DB nếu khác
if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Không kết nối được database"]);
  exit();
}

// Nhận dữ liệu JSON từ JS
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
  echo json_encode(["status" => "error", "message" => "Không có dữ liệu gửi lên"]);
  exit();
}

// Chuẩn bị lệnh thêm dữ liệu
$stmt = $conn->prepare("INSERT INTO dangkyhoc 
(tenBe, ngaySinh, gioiTinh, diaChi, lopDangKy, phuHuynh, soDienThoai, email, goiHocPhi, phuongThuc)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
  "ssssssssss",
  $data['tenBe'],
  $data['ngaySinh'],
  $data['gioiTinh'],
  $data['diaChi'],
  $data['lopDangKy'],
  $data['phuHuynh'],
  $data['soDienThoai'],
  $data['email'],
  $data['goiHocPhi'],
  $data['phuongThuc']
);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Đăng ký thành công!"]);
} else {
  echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
